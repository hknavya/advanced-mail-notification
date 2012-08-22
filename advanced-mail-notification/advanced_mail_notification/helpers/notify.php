<?php	
/**
Module Name :Events
Description: When the below event is triggered ,sends a mail to the  email address provided in the rule.
Author Name: Navya H.K
**/			 
defined('C5_EXECUTE') or die("Access Denied.");
class MailNotification{
	function page_add($page,$data) {
		if(self::isNotificationEnabled($page,$data))
		MailNotification::send($page,'Added',$data);
	}
	
	function page_update($page,$data) {
		if(self::isNotificationEnabled($page,$data))
		MailNotification::send($page, 'Updated',$data);
	}
	
	function page_delete($page,$data) {
		if(self::isNotificationEnabled($page,$data))
		MailNotification::send($page,'Deleted',$data);
	}

	function page_move($page, $old_parent_page, $new_parent_page,$data) {
		if(self::isNotificationEnabled($page,$data))
		MailNotification::send($page, 'Moved',$data);
	}

	function page_duplicate($new_page, $current_page,$data) {
		if(self::isNotificationEnabled($page,$data))
		MailNotification::send($new_page, 'Duplicated',$data);
	}

	function page_version_add($page,$nv,$data) {
		if(self::isNotificationEnabled($page,$data))
		MailNotification::send($page, 'Version Added',$data);
	}

	function page_version_approve($page,$data) {
		if(self::isNotificationEnabled($page,$data))
		MailNotification::send($page, 'Version Approved',$data);
	}
	/*checks if the notification is enabled for all ,pages or pagetypes*/
	function isNotificationEnabled($page,$data){
		$notifyFor = $data['notifyFor'];
		$pages = $data['pages']; 
		$pageTypes = $data['pageTypes'];

		if($notifyFor == 'all'){
			return true;
		}
		else if($notifyFor == 'page'){
			$allPages = split(',', $pages);
			return in_array($page->getCollectionHandle(),$allPages);
		}else if($notifyFor == 'page_types'){
			$allPageTypes = split(',', $pageTypes);
			return in_array($page->getCollectionTypeHandle(), $allPageTypes);
		}
	}
	/*sends mail if the notifiaction is enabled*/
	function send($page,$action,$data) {

			$mailTo = $data['mailTo'];
			$mailFrom = $data['mailFrom'];
			$mailSubject = $data['mailSubject'];
			$mailTemplate = $data['mailTemplate'];
			$u = new User();
			/*variables used to render mail template*/
			$vars = array(
			'page_name'=> $page->getCollectionName(),
			'page_type' => $page->getCollectionTypeName(),
			'page_link' => BASE_URL . View::url($page->getCollectionPath()),
			'action'=> $action,
			'user_name' => $u->getUserName(),
			'user_groups' => implode(', ', $u->getUserGroups()),
			'date'=>date('d/m/Y'),
			'time'=>date('h:i:s A'),
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
