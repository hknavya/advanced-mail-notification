<?php
defined('C5_EXECUTE') or die("Access Denied.");

class HiddenField extends OJField{
	protected $hidden = true;
	
	public function initialize(){
		$this->template = "{{{field}}}";
		$form = Loader::helper('form');
		$this->field = $form->hidden($this->getDisplayFieldName(),$this->default);
	}
}