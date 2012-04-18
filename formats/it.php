<?php
/**********************************************************

	Impulse Tracker

	extension for CHIPTAG

	worked from the Schism Tracker spec --
	not sure where I got it;
	...it's basically the same as Jeffrey Lim's version

**********************************************************/


class chiptag_format_it extends chiptag_format	{

	static	$format_token = 'IMPM';

	function __construct($file)	{
		$this->file = $file;
		$this->report = array('file : '.$file);
	}

	function FetchInfo()	{
		$f = fopen($this->file,'r');
		$head = fread($f,192);
		fclose($f);

		$format_token = substr($head,0,4);
		if($format_token!=chiptag_format_it::$format_token)	{
			$this->report[] = 'format token invalid';
		}
		$this->title = substr($head,4,26);


		return $this->report;
	}

}
