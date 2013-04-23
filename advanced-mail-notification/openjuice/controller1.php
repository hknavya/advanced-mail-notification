<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));

class WfoPackage extends Package {

	protected $pkgHandle = 'openjuice';
	protected $appVersionRequired = '5.5';
	protected $pkgVersion = '0.1';

	public function getPackageDescription() {
		return t('Open Juice extensions for generic tasks');
	}

	public function getPackageName() {
		return t('Open Juice');
	}
}
