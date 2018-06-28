<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
JHtml::_('formbehavior.chosen', 'select');
?>
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
    <form action="index.php?option=com_dkqmaker&view=questions" method="post" name="adminForm" id="adminForm">

            <table class="table table-striped table-hover">
                    <thead><?php echo $this->loadTemplate('head');?></thead>
                    <tbody><?php echo $this->loadTemplate('body');?></tbody>
                    <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
            </table>
             <div>
                    <input type="hidden" name="task" value="" />
                    <input type="hidden" name="boxchecked" value="0" />

		    <?php // start table sorting ?>
                    <input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
                    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
                    <?php // end table sorting ?>

                    <?php echo JHtml::_('form.token'); ?>
            </div>

    </form>
</div>
