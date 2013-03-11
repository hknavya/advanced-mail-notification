<?php 
/**
Module Name : Model List controller
Description: Creates new rule with the help of model class RULE
Author Name: Navya H.K.
**/
Loader::library('controllers/model_list_controller','openjuice');
Loader::model('advanced_mail','advanced_mail_notification');

define('RULE_EDIT_URL',View::url('/dashboard/system/advanced_notification/add_notification_rule/load'));
class DashboardSystemAdvancedNotificationNotificationRuleListController extends ModelListController{
		protected $model = 'Rule';
		protected $fieldsToShow = array(
				'name'=>array('wrapper'=>array('name'=>'edit','url'=>RULE_EDIT_URL)));

		public function renderList($args=null,$ajax=true){
		return '<a href="' . View::url('/dashboard/system/advanced_notification/add_notification_rule/') . '" class="btn primary ccm-button-v2-right" title="Add rule">Add Rule</a><div style="clear:both;"></div><br />' . parent::renderList($args,$ajax);
	}

}
