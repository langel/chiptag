<?php


class chiptag	{
  
  function Open($filename) {
    $a = new mp3;
    $a->filename = $filename;
    $a->filesize = filesize($filename);
    $a->file = fopen($a->filename,'r+b');
    $a->FetchID3v1();
    $a->FetchID3v2();
    $a->FetchInfos();
    $a->newTags = array();
    print_r($a);
    return $a;
  }

  function Close() {
    fclose($this->file);
  }

}


?>
