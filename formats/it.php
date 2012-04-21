<?php
/**********************************************************

	Impulse Tracker

	extension for CHIPTAG

	worked from the Schism Tracker spec --
	http://schismtracker.org/wiki/ITTECH.TXT

**********************************************************/


class chiptag_format_it extends chiptag_format	{


	function __construct($file)	{
		$this->file = $file;
		$this->report = array('IT object instantiated');
		$this->identifier = array(
			'token'		=>	'IMPM',
			'position'	=>	0,
		);

		$this->tag_scheme = array(
			'title'		=>	array(
				'position'	=>	4,
				'length'	=>	26,
				'delimiter'	=>	chr(0),
				'write'		=>	true,
			),
			'order count'	=>	array(
				'position'	=>	32,
				'length'	=>	1,
				'ord'		=>	true,
			),
			'instrument count'	=>	array(
				'position'	=>	33,
				'length'	=>	1,
				'ord'		=>	true,
			),
			'sample count'	=>	array(
				'position'	=>	34,
				'length'	=>	1,
				'ord'		=>	true,
			),
			'pattern count'	=>	array(
				'position'	=>	35,
				'length'	=>	1,
				'ord'		=>	true,
			),
		);
	}


}
