<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
    <th width="20">
        <?php echo JHtml::_('grid.checkall'); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_MESSAGES_HEADER_ID', 'id', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_MESSAGES_HEADER_NUMBER', 'number', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_MESSAGES_HEADER_QUIZ_ID', 'quiz_number', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_MESSAGES_HEADER_TITLE', 'title', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_MESSAGES_HEADER_CONTENT', 'content', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_MESSAGES_HEADER_IMAGE', 'image', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_MESSAGES_HEADER_ONLINE_DATE', 'online_date', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_MESSAGES_HEADER_OFFLINE_DATE', 'offline_date', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_MESSAGES_HEADER_VERSION', 'version', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_MESSAGES_HEADER_LAST_UPDATE', 'last_update', $this->sortDirection, $this->sortColumn); ?>
    </th>
</tr>
