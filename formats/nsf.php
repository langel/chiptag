<?php
/**********************************************************

	Nintendo Sound Format

	extension for CHIPTAG

	worked from the Kevtris spec --
	http://kevtris.org/nes/nsfspec.txt

**********************************************************/


class chiptag_format_nsf extends chiptag_format	{

	static	$extra_sound = array(
					'VRCVI',
					'VRCVII',
					'FDS Sound',
					'MMC5 audio',
					'Namco 106',
					'Sunsoft FME-07',
				);	

	function __construct($file)	{
		$this->file = $file;
		$this->format_token = 'NESM'.chr(26);
		$this->report = array($file);
	}

	function FetchInfo()	{
		$f = fopen($this->file,'r');
		$head = fread($f,128);
		fclose($f);
		$format_token = substr($head,0,5);
		if ($format_token!=$this->format_token)	{
			$this->report[] = 'format token invalid';
		}
		$this->artist = substr($head,46,32);
		$this->title = substr($head,14,32);
		$this->copy = substr($head,78,32);

		$this->ReportHelp();

      $bitnums = chiptag_format::$bitnums;
		$sounds = chiptag_format_nsf::$extra_sound;	
		$extra_sound_byte = ord(substr($head,123,1));
		foreach ($sounds as $key => $chip)	{
			if ($extra_sound_byte&$bitnums[$key])	{
				$this->report[] = 'expansion : '.$chip;
			}	
		}

		return $this->report;
	}

}

?>
