<?php
/**********************************************************
	Game Boy Sound
	extension for CHIPTAG
	Created by DevEd
	info derived from http://ocremix.org/info/GBS_Format_Specification
**********************************************************/
class chiptag_format_gbs extends chiptag_format	{
	function __construct($file)	{
		$this->file = $file;
		$this->report = array('GBS object instantiated');
		$this->identifier = array(
			'token'		=>	'GBS',
			'position'	=>	0,
		);
		
		$this->tag_scheme = array(
			'artist'	=>	array(
				'position'	=>	48,
				'length'	=>	32,
				'delimiter'	=>	chr(0),
				'write'		=>	true,
			),
			'title'	=>	array(	
				'position'	=>	16,
				'length'	=>	32,
				'delimiter'	=>	chr(0),
				'write'		=>	true,
			),
			'copy'	=>	array(
				'position'	=>	80,
				'length'	=>	32,
				'delimiter' =>	chr(0),
				'write'		=>	true,
			),
			// read only info below
			'no. songs'	=>	array(
				'position'	=>	4,
				'length'	=>	1,
				'ord'		=>	true,
			),
			'1st song'	=> array(
				'position'	=>	5,
				'length'	=>	1,
				'ord'		=>	true,
			),
		);
	}
}
