<?php 
defined('C5_EXECUTE') or die("Access Denied.");
Loader::model('advanced_mail','advanced_mail_notification');
Loader::library('templating/mustache','openjuice');

class DashboardSystemAdvancedNotificationStatusDescriptionsController extends controller{
	public function view(){
		$co = new Config();
		$pkg=Package::getByHandle('advanced_mail_notification');	
		$co->setPackageObject($pkg);
		$this->set('pageAdd', $co->get('Page_Added_Description'));
		$this->set('pageUpdate', $co->get('Page_Updated_Description'));
		$this->set('pageDelete', $co->get('Page_Deleted_Description'));
		$this->set('pageMove', $co->get('Page_Moved_Description'));
		$this->set('pageDuplicate', $co->get('Page_Duplicated_Description'));
		$this->set('pageVersionApprove', $co->get('Page_VersionApproved_Description'));
		$this->set('pageVersionAdd', $co->get('Page_VersionAdded_Description'));
	}
	public function save(){
		$co = new Config();
		$pkg=Package::getByHandle('advanced_mail_notification');	
		$co->setPackageObject($pkg);
		$val = Loader::helper('validation/form');
		$val->setData($this->post());
		$val->addRequired('pageAdd', 'Page Add Field is Required.');
		$val->addRequired('pageUpdate', 'Page Update Field is Required.');
		$val->addRequired('pageDelete', 'Page Delete Field is Required.');
		$val->addRequired('pageMove', 'Page Move Field is Required.');
		$val->addRequired('pageDuplicate', 'Page Duplicate Field is Required.');
		$val->addRequired('pageVersionApprove', 'Page Version Approve Field is Required.');
		$val->addRequired('pageVersionAdd', 'Page Version Add Field is Required.');

		if ($val->test()) {
			$co->save('Page_Added_Description',$_POST['pageAdd']);
			$co->save('Page_Updated_Description',$_POST['pageUpdate']);
			$co->save('Page_Deleted_Description',$_POST['pageDelete']);
			$co->save('Page_Moved_Description',$_POST['pageMove']);
			$co->save('Page_Duplicated_Description',$_POST['pageDuplicate']);
			$co->save('Page_VersionApproved_Description',$_POST['pageVersionApprove']);
			$co->save('Page_VersionAdded_Description',$_POST['pageVersionAdd']);
			$this->set('message',t('Settings saved.'));
			$this->view();
		} 
		else {
			$errorList = $val->getError()->getList();
			$this->set('errors',$errorList);
		}
	}
}