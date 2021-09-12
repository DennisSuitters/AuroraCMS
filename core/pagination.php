<?php
//namespace auroraCMS;
class Paginator{
  const NUM_PLACEHOLDER='(:num)';
  protected $totalItems;
  protected $numPages;
  protected $itemsPerPage;
  protected $currentPage;
  protected $urlPattern;
  protected $maxPagesToShow=5;
  protected $previousText='Previous';
  protected $nextText='Next';
  public function __construct($totalItems,$itemsPerPage,$currentPage,$urlPattern=''){
    $this->totalItems = $totalItems;
    $this->itemsPerPage = $itemsPerPage;
    $this->currentPage = $currentPage;
    $this->urlPattern = $urlPattern;
    $this->updateNumPages();
  }
  protected function updateNumPages(){
    $this->numPages = ($this->itemsPerPage == 0 ? 0 : (int) ceil($this->totalItems/$this->itemsPerPage));
  }
  public function setMaxPagesToShow($maxPagesToShow){
    if ($maxPagesToShow < 3) {
      throw new \InvalidArgumentException('maxPagesToShow cannot be less than 3.');
    }
    $this->maxPagesToShow = $maxPagesToShow;
  }
  public function getMaxPagesToShow(){
    return $this->maxPagesToShow;
  }
  public function setCurrentPage($currentPage){
    $this->currentPage = $currentPage;
  }
  public function getCurrentPage(){
    return $this->currentPage;
  }
  public function setItemsPerPage($itemsPerPage){
    $this->itemsPerPage = $itemsPerPage;
    $this->updateNumPages();
  }
  public function getItemsPerPage(){
    return $this->itemsPerPage;
  }
  public function setTotalItems($totalItems){
    $this->totalItems = $totalItems;
    $this->updateNumPages();
  }
  public function getTotalItems(){
    return $this->totalItems;
  }
  public function getNumPages(){
    return $this->numPages;
  }
  public function setUrlPattern($urlPattern){
    $this->urlPattern = $urlPattern;
  }
  public function getUrlPattern(){
    return $this->urlPattern;
  }
  public function getPageUrl($pageNum){
    return str_replace(self::NUM_PLACEHOLDER, $pageNum, $this->urlPattern);
  }
  public function getNextPage(){
    if ($this->currentPage < $this->numPages) {
      return $this->currentPage + 1;
    }
    return null;
  }
  public function getPrevPage(){
    if ($this->currentPage > 1) {
      return $this->currentPage - 1;
    }
    return null;
  }
  public function getNextUrl(){
    if (!$this->getNextPage()) {
      return null;
    }
    return $this->getPageUrl($this->getNextPage());
  }
  public function getPrevUrl(){
    if (!$this->getPrevPage()) {
      return null;
    }
    return $this->getPageUrl($this->getPrevPage());
  }
  public function getPages(){
    $pages = array();
    if ($this->numPages <= 1) {
      return array();
    }
    if ($this->numPages <= $this->maxPagesToShow) {
      for ($i = 1; $i <= $this->numPages; $i++) {
        $pages[] = $this->createPage($i, $i == $this->currentPage);
      }
    } else {
      $numAdjacents = (int) floor(($this->maxPagesToShow - 3) / 2);
      if ($this->currentPage + $numAdjacents > $this->numPages) {
        $slidingStart = $this->numPages - $this->maxPagesToShow + 2;
      } else {
        $slidingStart = $this->currentPage - $numAdjacents;
      }
      if ($slidingStart < 2) $slidingStart = 2;
      $slidingEnd = $slidingStart + $this->maxPagesToShow - 3;
      if ($slidingEnd >= $this->numPages) $slidingEnd = $this->numPages - 1;
      $pages[] = $this->createPage(1, $this->currentPage == 1);
      if ($slidingStart > 2) {
        $pages[] = $this->createPageEllipsis();
      }
      for ($i = $slidingStart; $i <= $slidingEnd; $i++) {
        $pages[] = $this->createPage($i, $i == $this->currentPage);
      }
      if ($slidingEnd < $this->numPages - 1) {
        $pages[] = $this->createPageEllipsis();
      }
      $pages[] = $this->createPage($this->numPages, $this->currentPage == $this->numPages);
    }
    return $pages;
  }
  protected function createPage($pageNum, $isCurrent = false){
    return array(
      'num' => $pageNum,
      'url' => $this->getPageUrl($pageNum),
      'isCurrent' => $isCurrent,
    );
  }
  protected function createPageEllipsis(){
    return array(
      'num' => ' ... ',
      'url' => null,
      'isCurrent' => false,
    );
  }
  public function toHtml(){
    if ($this->numPages <= 1) {
      return '';
    }
    $html='';
    if ($this->getPrevUrl())$html.='<a href="'.htmlspecialchars($this->getPrevUrl()).'">'.$this->previousText.'</a>&nbsp;';
    foreach($this->getPages() as $page){
      if($page['url'])
        $html.=($page['isCurrent']?'&nbsp;'.htmlspecialchars($page['num']):'&nbsp;<a href="'.htmlspecialchars($page['url']).'">'.htmlspecialchars($page['num']).'</a>');
      else
        $html.='<span>'.htmlspecialchars($page['num']).'</span>';
    }
    if($this->getNextUrl())$html.='&nbsp;<a href="'.htmlspecialchars($this->getNextUrl()).'">'.$this->nextText.'</a>';
    return$html;
  }
  public function __toString(){
    return $this->toHtml();
  }
  public function getCurrentPageFirstItem(){
    $first = ($this->currentPage - 1) * $this->itemsPerPage + 1;
    if ($first > $this->totalItems) {
      return null;
    }
    return $first;
  }
  public function getCurrentPageLastItem(){
    $first = $this->getCurrentPageFirstItem();
    if ($first === null) {
      return null;
    }
    $last = $first + $this->itemsPerPage - 1;
    if ($last > $this->totalItems) {
      return $this->totalItems;
    }
    return $last;
  }
  public function setPreviousText($text){
    $this->previousText = $text;
    return $this;
  }
  public function setNextText($text){
    $this->nextText = $text;
    return $this;
  }
}
