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
		$this->info_scheme = array();
		$this->infos = array();
	}


	function FetchInfo()	{
		return $this->report;
	}
	

	function ReadTags()	{
		if (!is_file($this->file))	{
			$this->report[] = 'Can not find file to read tags.';
			return false;
		}
		$f = fopen($this->file,'r');
		$this->report[] = 'Reading tags . . .';
		foreach ((array)$this->tag_scheme as $tag => $tag_scheme)	{
			fseek($f,$tag_scheme['position']);
			$this->tags[$tag] = fread($f,$tag_scheme['length']);
			if (isset($tag_scheme['delimiter']))	{
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
							$temp[] = $this->lookups[$key];
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
		$this->report[] = '. . . done reading tags.';
		fclose($f);
		return true;
	}


	function SetTag($tag,$val)	{
		if (array_key_exists($tag,$this->tag_scheme))	{
			$this->tags[$tag] = $val;
			$this->report[] = 'Tag `'.$tag.'` set to `'.$val.'`.';
			return true;
		}
		else	{
			$this->report[] = 'Can not set `'.$tag.'` tag.';
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
		fclose($f);
	}

}

?>
