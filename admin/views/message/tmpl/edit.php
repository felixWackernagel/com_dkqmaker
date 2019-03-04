<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidator');
?>
<script type="text/javascript">
    /* Override joomla.javascript, as form-validation not work with ToolBar */
    var submitbuttonfn = Joomla.submitbutton;
    Joomla.submitbutton = function( pressedButtonTask ) {
        if( pressedButtonTask.includes( 'cancel' ) ) {
            submitbuttonfn(pressedButtonTask);
        } else {
            var form = document.adminForm;
            if( document.formvalidator.isValid( form ) ) {
                submitbuttonfn( pressedButtonTask );
            }
        }
    }
</script>
<form class="form-validate" action="<?php echo JRoute::_('index.php?option=com_dkqmaker&view=message&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="message.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>