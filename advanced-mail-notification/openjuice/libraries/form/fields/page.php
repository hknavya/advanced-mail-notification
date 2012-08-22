<?php
defined('C5_EXECUTE') or die("Access Denied.");

class PageField extends OJField{
	public function initialize(){
		$pageSelector = Loader::helper('form/page_selector');
		$this->field = $pageSelector->selectPage($this->getDisplayFieldName(), $this->default); 
	}
}