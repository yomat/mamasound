<?php

namespace AppBundle\Tools;

class ArticleShortener extends \Twig_Extension{
	
	protected $session, $suite, $max;
	public function __construct($session, $suite, $max){
		$this->session=$session;
		$this->suite=$suite;
		$this->max=$max;
	}
	
	function getShortenedArticle($text) {
		$end = $this -> max;
		
		if ($end < 0) $end = $this->length;
	
		$str_return = html_entity_decode(strip_tags($text), ENT_QUOTES);
	
		while ($str_return != '' && strpos($str_return, ' ') === 0)
			$str_return = substr($str_return, 1);
	
		if ($str_return == '') return '';
		
		if (strlen($str_return) <= $end || strpos($str_return, ' ') === false)
			return $str_return;
	
		if (strpos($str_return, ' ') > $end)
			return substr($str_return, 0, strpos($str_return, ' '));
	
		$str_return = substr($str_return, 0, $end);
		return substr($str_return, 0, strrpos($str_return, ' ')) ." ". $this->suite;
	}
	
	public function getName(){
		return "ArticleShortener";
	}
	
	public function getFunctions(){
		return array(new \Twig_SimpleFunction('shortenedArticle', array($this, 'getShortenedArticle')));
	}

}
