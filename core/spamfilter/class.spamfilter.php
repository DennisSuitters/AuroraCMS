<?php
class SpamFilter{
  public function __construct($blacklists=null){
    if(is_array($blacklists)){
      $this->blacklist_directory=null;
      $this->blacklists=$blacklists;
    }elseif($blacklists===null){
      $blacklists=SpamFilter::default_blacklist_directory();
      $this->blacklist_directory=$blacklists;
      $this->blacklists=$this->get_blacklists_from_directory($blacklists);
    }elseif(is_string($blacklists)){
      $this->blacklist_directory=$blacklists;
      $this->blacklists=$this->get_blacklists_from_directory($blacklists);
    }else{
      $this->blacklist_directory=null;
      $this->blacklists=array();
    }
  }
  private function get_blacklists_from_directory($blacklist_directory){
    $blacklist_index=$blacklist_directory.DIRECTORY_SEPARATOR.'index.txt';
    if(!file_exists($blacklist_index)){
      return array();
    }else{
      $index=$blacklist_directory.DIRECTORY_SEPARATOR.'index.txt';
      return$this->get_list_from_file($index);
    }
  }
  private function get_list_from_file($file_path){
    $file_contents=file_get_contents($file_path);
    return preg_split("/((\r?\n)|(\r\n?))/",$file_contents,0,PREG_SPLIT_NO_EMPTY);
  }
  public static function default_blacklist_directory(){
    if(file_exists('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'blacklists'.DIRECTORY_SEPARATOR.'index.txt'))
      return'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'blacklists';
    elseif(file_exists('..'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'blacklists'.DIRECTORY_SEPARATOR.'index.txt'))
      return'..'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'blacklists';
    else
      return'core'.DIRECTORY_SEPARATOR.'blacklists';
  }
  private $blacklist_directory;
  private $blacklists;
  public function check_text($text){
    foreach($this->blacklists as$blacklist_filename){
      $match=$this->regex_match_from_blacklist($text,$blacklist_filename);
      if($match)return$match;
    }
  }
  public function check_url($url){
    return$this->check_text($url,$blacklist);
  }
  public function check_email($email){
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
      $domain=explode("@",$email);
      if(!checkdnsrr($domain[1],"MX"))return'invalid';
    }else
      return'invalid';
  }
  private function regex_match_from_blacklist($text,$blacklist){
    if(!file_exists($blacklist)){
      $path=$this->blacklist_directory;
      if($path===null)$path=SpamFilter::default_blacklist_directory();
      $blacklist_absolute=$path.DIRECTORY_SEPARATOR.$blacklist;
      if(file_exists($blacklist_absolute))
        $blacklist=$blacklist_absolute;
      else
        return false;
    }
    $keywords=file($blacklist);
    $current_line=0;
    $regex_match=array();
    foreach($keywords as$regex){
      $current_line++;
      $regex=preg_replace('/(^\s+|\s+$|\s*#.*$)/i',"",$regex);
      if(empty($regex))continue;
      $match=@preg_match("/$regex/i",$text,$regex_match);
      if($match)
        return$regex_match[0];
      elseif($match===false)
        continue;
    }
    return false;
  }
}
