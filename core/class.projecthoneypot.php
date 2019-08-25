<?php
/**
* ProjectHoneyPot
* Check an IP Against the Project Honey Pot Blacklist (https://www.projecthoneypot.org)
* @author Jeremy M. Usher <jeremy@firefly.us>
* @copyright 2014 Jeremy M. Usher 
* @category Security
* @version 0.90
* @license http://opensource.org/licenses/MIT MIT License
*
*/
class ProjectHoneyPot{
	const SEARCH_DOMAIN='dnsbl.httpbl.org';
	const NOT_FOUND='127.0.0.1';
	const SEARCH_ENGINE=0;
	const SUSPICIOUS=1;
	const HARVESTER=2;
	const COMMENT_SPAMMER=4;
	protected$access_key;
	protected$ip;
	protected$raw_response;
	protected$response;
	protected$threat_score;
	protected$visitor_type;
	protected$last_activity;
	protected$search_host;
	public function __construct($ip,$access_key){
		if(!filter_var($ip,FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
			throw new Exception("Provided IP must be in IPv4 notation.");
		$this->ip=$ip;
		$this->access_key=$access_key;
		$this->raw_response=$this->lookup($ip);
		$this->response=explode('.', $this->raw_response);
		if($this->response[0]!=127)
			throw new Exception("Project Honeypot Lookup for IP $ip Failed. Response was {$this->raw_response}");
		$this->last_activity=(int)$this->response[1];
		$this->threat_score=(int)$this->response[2];
		$this->visitor_type=(int)$this->response[3];
	}
	protected function lookup($ip){
		$reverse_octet=implode('.',array_reverse(explode('.',$ip)));
		$this->search_host="{$this->access_key}.$reverse_octet.".self::SEARCH_DOMAIN;
		$response=@gethostbyname($this->search_host);
		if($response==$this->search_host) $response=self::NOT_FOUND;
		return$response;
	}
	public function getThreatScore(){
		return$this->threat_score;
	}
	public function getVisitorType(){
		return$this->visitor_type;
	}
	public function hasRecord(){
		return($this->raw_response!=self::NOT_FOUND)?true:false;
	}
	public function isSuspicious(){
		return($this->hasRecord()&&($this->getVisitorType() & self::SUSPICIOUS))?true:false;
	}
	public function isHarvester(){
		return($this->hasRecord()&&($this->getVisitorType() & self::HARVESTER))?true:false;
	}
	public function isSearchEngine(){
		return($this->hasRecord()&&($this->getVisitorType()==self::SEARCH_ENGINE))?true:false;
	}
	public function isCommentSpammer(){
		return($this->hasRecord()&&($this->getVisitorType() & self::COMMENT_SPAMMER))?true:false;
	}
	public function getSearchEngine(){
		if(!$this->isSearchEngine())
			return false;
		$engines='Undocumented|AltaVista|Ask|Baidu|Excite|Google|Looksmart|Lycos|MSN|Yahoo|Cull|Infoseek|Miscellaneous';
		$engines=explode('|',$engines);
		return$engines[$this->response[2]];
	}
	public function getLastActivity(){
		if(!$this->hasRecord())return false;
		return$this->last_activity;
	}
	public function getSearchHost(){
		return$this->search_host;
	}
}
