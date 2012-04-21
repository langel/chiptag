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
		$this->report = array('NSF object instantiated.');
		$this->identifier = array(
			'token'		=>	'NESM'.chr(26),
			'position'	=>	0,
		);
		
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

}

?>
