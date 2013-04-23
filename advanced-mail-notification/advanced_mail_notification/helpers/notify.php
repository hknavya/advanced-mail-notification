<?php	
/*
Module Name :Events
Description: When the below event is triggered ,sends a mail to the  email address provided in the rule.
Author Name: Navya H.K
*/			 
defined('C5_EXECUTE') or die("Access Denied.");
class MailNotification{
	function page_add($page,$data) {
		$pkg=Package::getByHandle('advanced_mail_notification');
		if(self::isNotificationEnabled($page,$data))
		$status = $pkg->config('Page_Added_Description');
		MailNotification::send($page,'Added',$data,$status);
	}
	
	function page_update($page,$data) {
		$pkg=Package::getByHandle('advanced_mail_notification');
		if(self::isNotificationEnabled($page,$data))
		$status = $pkg->config('Page_Updated_Description');
		MailNotification::send($page, 'Updated',$data,$status);
	}
	
	function page_delete($page,$data) {
		$pkg=Package::getByHandle('advanced_mail_notification');
		if(self::isNotificationEnabled($page,$data))
		$status = $pkg->config('Page_Deleted_Description');
		MailNotification::send($page,'Deleted',$data,$status);
	}

	function page_move($page, $old_parent_page, $new_parent_page,$data) {
		$pkg=Package::getByHandle('advanced_mail_notification');
		if(self::isNotificationEnabled($page,$data))
		$status = $pkg->config('Page_Moved_Description');
		MailNotification::send($page, 'Moved',$data,$status);
	}

	function page_duplicate($new_page, $current_page,$data) {
		$pkg=Package::getByHandle('advanced_mail_notification');
		if(self::isNotificationEnabled($page,$data))
		$status = $pkg->config('Page_Duplicated_Description');
		MailNotification::send($new_page, 'Duplicated',$data,$status);
	}

	function page_version_add($page,$nv,$data) {
		$pkg=Package::getByHandle('advanced_mail_notification');
		if(self::isNotificationEnabled($page,$data))
		$status = $pkg->config('Page_VersionAdded_Description');
		MailNotification::send($page, 'Version Added',$data,$status);
	}

	function page_version_approve($page,$data) {
		$pkg=Package::getByHandle('advanced_mail_notification');
		if(self::isNotificationEnabled($page,$data))
		$status = $pkg->config('Page_VersionApproved_Description');
		MailNotification::send($page, 'Version Approved',$data,$status);
	}
	/*checks if the notification is enabled for all ,pages or pagetypes*/
	function isNotificationEnabled($page,$data){
		$notifyFor = $data['notifyFor'];
		$pages = $data['pages']; 
		$pageTypes = $data['pageTypes'];
		$pagesBelow = $data['pagesBelow'];

		if($notifyFor == 'all'){
			return true;
		}
		else if($notifyFor == 'page'){
			$allPages = split(',', $pages);
			return in_array($page->getCollectionHandle(),$allPages);
		}else if($notifyFor == 'page_types'){
			$allPageTypes = split(',', $pageTypes);
			return in_array($page->getCollectionTypeHandle(), $allPageTypes);
		}else if($notifyFor == 'below'){
			return in_array($page->cID, Page::getByID($pagesBelow)->getCollectionChildrenArray());
		}
	}
	/*sends mail if the notifiaction is enabled*/
	function send($page,$action,$data,$status) {
			/*get user Attribute*/
			$u = new User();
  			if($u->isLoggedIn()) {
    		$ui = UserInfo::getByID($u->getUserID());
    		$name = $ui->getAttribute('name');
    			if(empty($name)){
	    			$name = $ui->getUserEmail();
	    		}		
			}
			$mailTo = $data['mailTo'];
			$mailFrom = $data['mailFrom'];
			$mailSubject = $data['mailSubject'];
			$mailTemplate = $data['mailTemplate'];
			$cv = $page->getVersionObject();
			Loader::model('collection_version');
			/*variables used to render mail template*/
			$vars = array(
			'page_name'=> $page->getCollectionName(),
			'page_type' => $page->getCollectionTypeName(),
			'page_link' => BASE_URL . View::url($page->getCollectionPath()),
			'action'=> $action,
			'action_description'=>$status,
			'name' => $name,
			'email'=>$ui->getUserEmail(),
			'user_groups' => implode(', ', $u->getUserGroups()),
			'date'=>date('d/m/Y'),
			'time'=>date('h:i:s A'),
			'version_comment'=>$cv->getVersionComments(),
			);

			$mh = Loader::helper('mail');
			$mh->addParameter('mailSubject',$mailSubject);
			$mh->addParameter('mailTemplate',$mailTemplate);
			$mh->addParameter('vars',$vars);
			/*loads a mail template and uses mustache to render it*/
			$mh->load('notification','advanced_mail_notification');
			$mh->to($mailTo);
			$mh->from($mailFrom);
			$mh->sendMail();

		}
}
