<?php
/**********************************************************

	Fast Tracker

	extension for CHIPTAG

	worked from the game programming wiki --
	http://content.gpwiki.org/index.php/XM

**********************************************************/


class chiptag_format_xm extends chiptag_format	{


	function __construct($file)	{
		$this->file = $file;
		$this->report = array('XM object instantiated');
		$this->identifier = array(
			'token'		=>	'Extended Module: ',
			'position'	=>	0,
		);


// XXX tags which are ord and length of 2
// might now be read correctly (2 byte words)
		$this->tag_scheme = array(
			'title'		=>	array(
				'position'	=>	17,
				'length'	=>	20,
				'delimiter'	=>	chr(20),
				'write'		=>	true,
			),
			'tracker used'	=>	array(
				'position'	=>	38,
				'length'	=>	20,
				'delimiter'	=>	chr(20),
			),
			'order length'	=>	array(
				'position'	=>	64,
				'length'	=>	2,
				'ord'		=>	true,
			),
			'channel count'	=>	array(
				'position'	=>	68,
				'length'	=>	2,
				'ord'		=>	true,
			),
			'pattern count'	=>	array(
				'position'	=>	70,
				'length'	=>	2,
				'ord'		=>	true,
			),
			'instrument count'	=>	array(
				'position'	=>	72,
				'length'	=>	2,
				'ord'		=>	true,
			),
			'ticks per beat'	=>	array(
				'position'	=>	76,
				'length'	=>	2,
				'ord'		=>	true,
			),
			'beats per minute'	=>	array(
				'position'	=>	78,
				'length'	=>	2,
				'ord'		=>	true,
			),
		);

	}

}

?>
