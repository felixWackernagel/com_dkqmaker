<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
    <th width="20">
        <?php echo JHtml::_('grid.checkall'); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZERS_HEADER_ID', 'id', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZERS_HEADER_NUMBER', 'number', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZERS_HEADER_NAME', 'name', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZERS_HEADER_IMAGE', 'image', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZERS_HEADER_VERSION', 'version', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZERS_HEADER_LAST_UPDATE', 'last_update', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>

    </th>
</tr>
