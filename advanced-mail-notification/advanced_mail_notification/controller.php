<?php  
/*
Module Name : Package Controller
Description: Controlls the whole package,adds single pages and when the following events are triggered , a mail will be sent to the specified email address.
Author Name: Navya H.K
*/       
defined('C5_EXECUTE') or die("Access Denied.");
class AdvancedMailNotificationPackage extends Package {
	protected $pkgHandle = 'advanced_mail_notification';
	protected $appVersionRequired = '5.6';
	protected $pkgVersion = '1.5';
	
	public function getPackageName() {
		return t("Advanced Mail Notification");
	}

	public function getPackageDescription() {
		return t("Sends an email to the given user when a page is updated or approved");
	}

	public function install() {
		$pkg = parent::install();
		/*loads all the single pages given below*/
		Loader::model('single_page');
		$mailPage = SinglePage::add('/dashboard/system/advanced_notification/notification_rule_list',$pkg);
		$mailPage->update(array('cName'=>t(" Notification Rule List"), 'cDescription'=>t("rule based settings for mail.")));
		$detailPage = SinglePage::add('/dashboard/system/advanced_notification/add_notification_rule',$pkg);
		$detailPage->update(array('cName'=>t("Add Notification Rule "), 'cDescription'=>t("rule based settings for mail.")));
		$descriptionPage = SinglePage::add('/dashboard/system/advanced_notification/status_descriptions',$pkg);
		$descriptionPage->update(array('cName'=>t("Status Description "), 'cDescription'=>t("Status Description.")));

		/*Adding User Attribute*/
		Loader::model('attribute/categories/user');
		UserAttributeKey::add('text',array(
			'akIsAutoCreated' => 1,
			'akHandle'        => 'name',
			'akName'          => 'Name',
			'uakProfileDisplay'=>1,
			'uakProfileEdit'=>1,
			'uakProfileEditRequired'=>1,
			'uakRegisterEdit'=>1,
			'uakRegisterEditRequired'=>1,
			'uakMemberListDisplay'=>1,
   
		),$pkg);

	}
	public function upgrade() {
		parent::upgrade();
		/*Adding user Attribute 'Name'*/
		Loader::model('attribute/categories/user');
		UserAttributeKey::add('text',array(
			'akIsAutoCreated' => 1,
			'akHandle'        => 'name',
			'akName'          => 'Name',
			'uakProfileDisplay'=>1,
			'uakProfileEdit'=>1,
			'uakProfileEditRequired'=>1,
			'uakRegisterEdit'=>1,
			'uakRegisterEditRequired'=>1,
			'uakMemberListDisplay'=>1,
   
		),$pkg);
	  // adding Status Description Page
 		$p = Page::getByPath('/dashboard/system/advanced_notification/status_descriptions');
	  	if ($p->isError() || (!is_object($p))) {
			SinglePage::add('/dashboard/system/advanced_notification/status_descriptions', $this);
	  	}
	}

	public function on_start() {
		$v = View::getInstance();
		$html = Loader::helper('html');
		$v->addFooterItem($html->javascript('advance_mail.js','advanced_mail_notification'));
		$start = microtime(true);
		$u = new User();
		if($u->isSuperUser() && defined('NO_ALERTS_FOR_ADMIN') && NO_ALERTS_FOR_ADMIN)
			return;
		Loader::model('advanced_mail','advanced_mail_notification');
		$newRule = new Rule();
		/*gets all the rule  data from database */
		$rulesData = $newRule->getEnabledRules();
		foreach($rulesData as $data){
			$ruleID = $data['ruleID'];
			$ruleEnabled = $data['enabled'];
			$pageAdded = $data['added'];
			$pageUpdated = $data['updated'];
			$pageDeleted = $data['deleted'];
			$pageMoved = $data['moved'];
			$pageDuplicated = $data['duplicated'];
			$pageVersionApproved = $data['versionApproved'];
			$pageVersionAdded = $data['versionAdded'];

			if($ruleEnabled){
				if($pageAdded){
					Events::extend('on_page_add', 'MailNotification', 'page_add', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/' . DIRNAME_HELPERS . '/notify.php',array($data));
				}
				if($pageUpdated){
					Events::extend('on_page_update', 'MailNotification', 'page_update', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/' . DIRNAME_HELPERS . '/notify.php',array($data));
				}
				if($pageDeleted){
					Events::extend('on_page_delete', 'MailNotification', 'page_delete', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/' . DIRNAME_HELPERS . '/notify.php',array($data));
				}
				if($pageMoved){	
					Events::extend('on_page_move', 'MailNotification', 'page_move', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/' . DIRNAME_HELPERS . '/notify.php',array($data));
				}
				if($pageDuplicated){
					Events::extend('on_page_duplicate', 'MailNotification', 'page_duplicate', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/' . DIRNAME_HELPERS . '/notify.php',array($data));
				}
				if($pageVersionAdded){

					Events::extend('on_page_version_add', 'MailNotification', 'page_version_add', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/' . DIRNAME_HELPERS . '/notify.php',array($data));
				}
				if($pageVersionApproved){
					Events::extend('on_page_version_approve', 'MailNotification', 'page_version_approve', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/' . DIRNAME_HELPERS . '/notify.php',array($data));
				}

			}
		}
	}

}

