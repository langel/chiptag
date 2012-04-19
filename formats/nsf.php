<?php
/**********************************************************

	Nintendo Sound Format

	extension for CHIPTAG

	worked from the Kevtris spec --
	http://kevtris.org/nes/nsfspec.txt

**********************************************************/


class chiptag_format_nsf extends chiptag_format	{


	function __construct($file)	{
		$this->file = $file;
		$this->format_token = 'NESM'.chr(26);
		$this->report = array('FILE : '.$file);
		
		$this->tag_scheme = array(
			'artist'	=>	array(
				'position'	=>	46,
				'length'	=>	32,
				'delimiter'	=>	chr(0),
				'write'		=>	true,
			),
			'title'	=>	array(	
				'position'	=>	14,
				'length'	=>	32,
				'delimiter'	=>	chr(0),
				'write'		=>	true,
			),
			'copy'	=>	array(
				'position'	=>	78,
				'length'	=>	32,
				'delimiter' =>	chr(0),
				'write'		=>	true,
			),
			// read only info below
			'no. songs'	=>	array(
				'position'	=>	6,
				'length'	=>	1,
				'ord'		=>	true,
			),
			'1st song'	=> array(
				'position'	=>	7,
				'length'	=>	1,
				'ord'		=>	true,
			),
			'pal/ntsc' 	=> array(
				'position'	=>	122,
				'length'	=>	1,
				'ord'		=>	true,
				'lookup'	=>	'pal_ntsc',
			),
			'extra sound'=>	array(
				'position'	=>	123,
				'length'	=>	1,
				'ord'		=>	true,
				'lookup'	=>	'extra_sound',
				'bitwise'	=>	true,
			),
		);

		$this->lookups	=	array(
			'pal_ntsc'	=>		array(
				'NTSC',
				'PAL',
				'PAL/NTSC',
			),
			'extra_sound' =>	array(
				'VRCVI',
				'VRCVII',
				'FDS Sound',
				'MMC5 audio',
				'Namco 106',
				'Sunsoft FME-07',
			),
		);
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

		$this->ReadTags();

		return $this->report;
	}


}

?>
