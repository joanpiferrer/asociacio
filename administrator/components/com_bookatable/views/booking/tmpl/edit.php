<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

?>
<form
	action="<?php echo JRoute::_('index.php?option=com_bookatable&layout=edit&id='.(int) $this->item->id); ?>"
	method="post" name="adminForm" id="adminForm" class="form-validate">

	<div class="span10 form-horizontal">
		<fieldset>
			<legend>
				<?php echo JText::_( 'COM_BOOKATABLE_DETAILS' ); ?>
			</legend>
			<div class="tab-content">
				<?php foreach($this->form->getFieldset() as $field): ?>
				<div class="control-group">
					<div class="control-label">
						<?php echo $field->label ?>
					</div>
					<div class="controls">
						<?php echo $field->input; ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</fieldset>
	</div>

	<input type="hidden" name="task" value="booking.edit" />
	<?php echo JHtml::_('form.token'); ?>

</form>
