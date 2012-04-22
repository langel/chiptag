<?php
/**********************************************************

	C H I P T A G

	a chiptune tag reader / writer in php

	a proud member of the NinjaWizard family

**********************************************************/


// Load all format classes in subdirectory.
foreach (glob(dirname(__FILE__).'/formats/*.php') as $file)	{
	include($file);
}


// Main interface class, returns appropriate object.

class chiptag	{

	function open($file)	{
		if (!is_file($file))	{
			$error = $file.' - file unfound. ';
		}
		$ext = substr($file,strrpos($file,'.')+1);
		$class = 'chiptag_format_'.$ext;
		if (!class_exists($class))	{
			$error .= strtoupper($ext).' not currently supported. ';
		}
		if ($error=='')	{
			return new $class($file);
		}
		else return new chiptag_format($error);
	}  
}


class chiptag_format	{

	static $bitnums = array(1,2,4,8,16,32,64,128);

	function __construct($errorText)	{
		$this->report = array($errorText);
		$this->tag_scheme = array();
		$this->tags = array();
	}


	function ReadableReport()	{
		return implode('<br>',$this->report);
	}
	

	function FetchInfo()	{
		$this->report[] = 'reading file '.$this->file;
		if (!is_file($this->file))	{
			$this->report[] = 'Can not find file to read tags.';
			return false;
		}
		$f = fopen($this->file,'r');
		if ($this->identifier['token']!='')	{
			if ($this->identifier['position'])	{
				fseek($f,$this->identifier['position']);
			}
			$token = fread($f,strlen($this->identifier['token']));
			if ($token==$this->identifier['token'])	{
				$this->report[] = "'$token' identifier token found";
			}
			else	{
				$this->report[] = "'$token' identifier token not found?!!?  D:";
			}
		}
		$this->report[] = 'fetching infos . . .';
		foreach ((array)$this->tag_scheme as $tag => $tag_scheme)	{
			fseek($f,$tag_scheme['position']);
			$this->tags[$tag] = fread($f,$tag_scheme['length']);
			if (isset($tag_scheme['delimiter'])&&strpos($this->tags[$tag],$tag_scheme['delimiter']))	{
				$this->tags[$tag] = substr($this->tags[$tag],0,strpos($this->tags[$tag],$tag_scheme['delimiter']));
			}
			if ($tag_scheme['ord'])	{
				$this->tags[$tag] = ord($this->tags[$tag]);
			}
			if (isset($tag_scheme['lookup']))	{
				if ($tag_scheme['bitwise'])	{
					$temp = array();
					foreach($this->lookups[$tag_scheme['lookup']] as $key => $val)	{
						if ($this->tags[$tag]&chiptag_format::$bitnums[$key])	{
							$temp[] = $this->lookups[$tag_scheme['lookup']][$key];
						}
					}
					$this->tags[$tag] = implode('/',$temp);
				}
				else	{
					$this->tags[$tag] = $this->lookups[$tag_scheme['lookup']][$this->tags[$tag]];
				}
			}
			// write tag info to report
			if ($this->tags[$tag]!='')	{
				$this->report[] = $tag.' : '.$this->tags[$tag];
			}
		}
		if (method_exists($this,'FetchInfoExtender'))	{
			$this->FetchInfoExtender($f);
		}
		$this->report[] = '. . . done fetching infos';
		fclose($f);
		return true;
	}


	function SetTag($tag,$val)	{
		if ($this->tag_scheme[$tag]['write']===true)	{
			if (strlen($val)>$this->tag_scheme[$tag]['length'])	{
				$val = substr($val,$this->tag_scheme[$tag]['length']);
			}
			$this->tags[$tag] = $val;
			$this->report[] = 'tag `'.$tag.'` set to `'.$val.'`';
			return true;
		}
		else	{
			$this->report[] = '!can not set `'.$tag.'` tag.';
			return false;
		}
	}


	function WriteTags()	{
		$f = fopen($this->file,'r+');
		foreach ((array)$this->tag_scheme as $tag => $tag_scheme)	{
			if ($tag_scheme['write']===true)	{
				if (strlen($tag_scheme['delimiter'])>0 && $tag_scheme['length'])	{
					$tag = str_pad($this->tags[$tag],$tag_scheme['length'],$tag_scheme['delimiter']);
				}
				if ($tag_scheme['position'])	{
					fseek($f,$tag_scheme['position']);
					fwrite($f,$tag,$tag_scheme['length']);
				}
			}
		}
		if (method_exists($this,'WriteTagsExtender'))	{
			$this->WriteTagsExtender($f);
		}
		fclose($f);
	}

}

?>
