<?php
/*
Module Name : Model edit controller for rule
Description: displays list of rules present.
Author Name: Navya H.K
*quotemeta()*/
Loader::library('controllers/model_edit_controller','openjuice');
Loader::model('advanced_mail','advanced_mail_notification');

define('RULE_LIST_URL','/dashboard/system/advanced_notification/notification_rule_list');
class DashboardSystemAdvancedNotificationAddNotificationRuleController extends ModelEditController{	
		protected $modelName = 'Rule';
		protected $listURL = RULE_LIST_URL;
		protected $ajaxFieldReloads = array('notifyFor'=>array('pageTypes','pages','pagesBelow'));
}
