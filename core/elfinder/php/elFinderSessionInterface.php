<?php interface elFinderSessionInterface{public function start();public function close();public function get($key,$empty='');public function set($key,$data);public function remove($key);}
