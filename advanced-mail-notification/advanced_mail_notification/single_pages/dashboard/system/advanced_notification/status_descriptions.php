<?php          
defined('C5_EXECUTE') or die(_("Access Denied."));	
$dh = Loader::helper('concrete/dashboard');
$ih = Loader::helper('concrete/interface');
$form = Loader::helper('form');
$statusTypes = 
array(
	'pageAdd' => 'Page Added Status',
	'pageUpdate' => 'Page Updated Status',
	'pageDelete' => 'Page Deleted Status',
	'pageMove' => 'Page Moved Status',
	'pageDuplicate'=> 'Page Duplicated Status',
	'pageVersionApprove' => 'Page Version Approved Status',
	'pageVersionAdd'=>'Page Version Added Status');
	?>

	<?php echo $dh->getDashboardPaneHeaderWrapper(t('Add Page Status'),t('Add status'),false,false); ?>
	<form method="post" action="<?php echo $this->action('save')?>" id="ccm-status-save">
		<div class="ccm-pane-body">
			<?php if (isset($errors)){?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">×</button>
				<?php foreach ($errors as $error) { ?>
				<?php echo $error;?><br>
				<?php }?>
			</div>
			<?php }?>
			<fieldset>
				<?php foreach ($statusTypes as $statusType => $label): ?>
					<div class="clearfix">
						<label><?php echo t($label); ?></label>
						<div class="input">
							<?php echo $form->text("$statusType",$$statusType,array('class'=>'input-xxlarge'));	?>
						</div>
					</div>
				<?php endforeach ?>
			</fieldset>	
		</div>	
	<div class="ccm-pane-footer">
		<?php echo $ih->submit(t('Save'),'ccm-status-save','right','primary')?>
	</div>
</form>
<?php echo $dh->getDashboardPaneFooterWrapper(false);?>