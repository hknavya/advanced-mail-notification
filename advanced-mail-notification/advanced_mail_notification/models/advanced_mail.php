<?php
/*
Module Name : Rule model
Description: model class for rule which extends model from 'openjuice package'.
Author Name: Navya H.K
*/
/*loads openjuice model*/
Loader::library('model','openjuice');
class Rule extends OJModel
{

	protected $identifier = 'ruleID';

	protected $meta = array(
		'adapter' => 'mysql',
		'table'   => 'Rule'
	);
		
	protected $fields = array(
		'name' => array(
					'db_col'=>'ruleName',
					'label'=>'Rule Name',
					'type'=>'text',
					'validations'=>'required', 
				),
		'enabled' => array(
					'db_col'=>'ruleEnabled',
					'label'=>'Enable Rule',
					'type'=>'checkbox'
				),
		'added' => array(
					'db_col'=>'pageAdded',
					'label'=>'Page added',
					'type'=>'checkbox',
					'field_group' => 'notify_on'
				),
		'updated' => array(
					'db_col'=>'pageUpdated',
					'label'=>'Page updated',
					'type'=>'checkbox',
					'field_group' => 'notify_on'
				),
		'deleted' => array(
					'db_col'=>'pageDeleted',
					'label'=>'Page deleted',
					'type'=>'checkbox',
					'field_group' => 'notify_on'
				),
		'moved' => array(
					'db_col'=>'pageMoved',
					'label'=>'Page moved',
					'type'=>'checkbox',
					'field_group' => 'notify_on'
				),
		'duplicated' => array(
					'db_col'=>'pageDuplicated',
					'label'=>'Page duplicated',
					'type'=>'checkbox',
					'field_group' => 'notify_on'
				),
		'versionApproved' => array(
					'db_col'=>'pageVersionApproved',
					'label'=>'Page version approved',
					'type'=>'checkbox',
					'field_group' => 'notify_on'
				),
		'versionAdded' => array(
					'db_col'=>'pageVersionAdded',
					'label'=>'Page version added',
					'type'=>'checkbox',
					'field_group' => 'notify_on'
				),

		'notifyFor' => array(
					'db_col'=>'notifyFor',
					'label'=>'Send Notifications For',
					'type' =>'select',
					'values' => array('all'=> 'All Pages','page_types'=>'Page Types','page'=>'Particular Page','below' => 'All Pages Below')
				),
		'pageTypes' => array(
					'db_col' => 'pageTypes',
					'label' => 'Page Types',
					'type' => 'multiCheckBox',
					'values' => 'PageTypeProvider'
		),
		'pages' => array(
					'db_col' => 'pages',
					'label' => 'Page',
					'type' => 'page',
		),
		'pagesBelow' => array(
					'db_col' => 'pagesBelow',
					'label' => 'Pages Below',
					'type' => 'page',
		),
		'mailTo' => array(
					'db_col'=>'mailTo',
					'label'=>'To',
					'type'=>'text',
				),
		'mailFrom' => array(
					'db_col'=>'mailFrom',
					'label'=>'From',
					'type'=>'text',
				),
		'mailSubject' => array(
					'db_col'=>'mailSubject',
					'label'=>'Subject',
					'type'=>'text',
					'template' => '<div class="well">Available tags are &#123;&#123;page_name&#125;&#125;,&#123;&#123;version_comment&#125;&#125;,&#123;&#123;page_type&#125;&#125;,&#123;&#123;page_link&#125;&#125;,&#123;&#123;action&#125;&#125;,&#123;&#123;user_name&#125;&#125;,&#123;&#123;user_groups&#125;&#125;,&#123;&#123;date&#125;&#125;,&#123;&#123;time&#125;&#125;</div><div class="clearfix" {{parentAttrs}}><label for="{{fieldPrefix}}{{fieldName}}">{{label}}</label><div class="input input-xxlarge">{{{field}}}</div></div>'
				),
		'mailTemplate' => array(
					'db_col'=>'mailTemplate',
					'label'=>'Mail Template',
					'type'=>'richText'
		)
	);
	protected $fieldGroups = array(	

	'notify_on' => array('template'=>'<div class="clearfix" {{parentAttrs}}><label>{{group_name}} </label><div class="input">{{#fields}}<div>{{{field}}}</div><br/>{{/fields}}</div></div>',
						'field_template' => '{{{field}}}<span for="{{fieldPrefix}}{{fieldName}}">&nbsp;&nbsp;{{label}}</span>',
						'group_name' => 'Send Notification On')
	);
	//jquery for select box
	protected $formRules = array(
		'pageTypes'  => array(array('condition'=>'notifyFor != page_types','action'=>'hide')),
		'pages'  => array(array('condition'=>'notifyFor != page','action'=>'hide')),
		'pagesBelow'  => array(array('condition'=>'notifyFor != below','action'=>'hide'))
	);
	//get all the values from database
	public function getEnabledRules(){

		$filter = "`enabled` = 1";
		$values = $this->getDataAdapterObj()->find($filter);
		return $values;
	}
}
class PageTypeProvider{
	function getValues(){
		$pageTypes = CollectionType::getList();
		$pageTypeValues = array();
		foreach ($pageTypes as $pType) {
			$pageTypeValues[$pType->getCollectionTypeHandle()] = $pType->getCollectionTypeName();
		}
		return $pageTypeValues;
	}
}