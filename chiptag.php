<?php
/**********************************************************

	C H I P T A G

	a chiptune tag reader / writer in php

	a proud member of the NinjaWizard family

**********************************************************/


foreach (glob(dirname(__FILE__).'/formats/*.php') as $file)	{
	include($file);
}



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
	}
	
	function FetchInfo()	{
		return $this->report;
	}

	function ReportHelp()	{
		$posse = array('artist','title','copy');
		foreach ($posse as $tag)	{
			if (trim($this->$tag)!='')	{
				$this->report[] = $tag.' : '.$this->$tag;
			}
		}
	}

}

?>
