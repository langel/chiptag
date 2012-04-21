<?php
/**********************************************************

	Amiga Protracker 2.3 module

	extension for CHIPTAG

	worked from the spec found on modland ftp --
	ftp://ftp.modland.com/pub/documents/format_documentation/Protracker%202.3A%20&%20miscellaneous%20info%20(.mod).txt

**********************************************************/

class chiptag_format_mod extends chiptag_format	{
	function __construct($file)	{
			$this->file = $file;
			$this->report = array('MOD object instantiated');
			// TODO fix these identifiers
			$this->identifier = array(
				'token'		=>	'M.K.',	// identifier for a 4-channel mod
				'position'	=>	1080,
			);
			
			// the instrument count is always 31 (or maybe 16, but that's only a theoretical scenario!)
			// and the pattern count is same as the highest pattern in the order list
			
			$this->tag_scheme = array(
			'title'		=>	array(
				'position'	=>	0,
				'length'	=>	20,
				'delimiter'	=>	chr(0),
				'write'		=>	true,
			),
			'order count'	=>	array(	
				'position'	=>	950,
				'length'	=>	1,
				'ord'		=>	true,
			),
			);
	}
}

?>