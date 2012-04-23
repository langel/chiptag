<?php
/**********************************************************

	Scream Tracker 3

	extension for CHIPTAG

	worked from 16 bits dot org --
	http://16-bits.org/s3m/

**********************************************************/


class chiptag_format_s3m extends chiptag_format	{


	function __construct($file)	{
		$this->file = $file;
		$this->report = array('S3M object instantiated');
		$this->identifier = array(
			'token'		=>	'SCRM',
			'position'	=>	44,
		);


// XXX tags which are ord and length of 2
// might now be read correctly (2 byte words)
		$this->tag_scheme = array(
			'title'		=>	array(
				'position'	=>	0,
				'length'	=>	28,
				'delimiter'	=>	chr(0),
				'write'		=>	true,
			),
			'order length'	=>	array(
				'poisition'	=>	32,
				'length'	=>	2,
				'ord'		=>	true,
			),
			'instrument count'	=>	array(
				'position'	=>	34,
				'length'	=>	2,
				'ord'		=>	true,
			),
			'pattern count'	=>	array(
				'position'	=>	36,
				'length'	=>	2,
				'ord'		=>	true,
			),
			'tracker version'	=>	array(
				'position'	=>	38,
				'length'	=>	2,
				'ord'		=>	true,
			),
		);
	}

	function FetchInfoExtender($f)	{
		if ($this->tags['tracker version']!='')	{
			$this->tags['tracker version'] = 'ST3.'.$this->tags['tracker version'];
		}
	}

}

?>
