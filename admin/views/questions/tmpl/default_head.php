<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
    <th width="20">
        <?php echo JHtml::_('grid.checkall'); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUESTIONS_HEADER_ID', 'q.id', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUESTIONS_HEADER_QUIZ_ID', 'q.quiz_id', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUESTIONS_HEADER_NUMBER', 'q.number', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUESTIONS_HEADER_QUESTION', 'q.question', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUESTIONS_HEADER_ANSWER', 'q.answer', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUESTIONS_HEADER_IMAGE', 'q.image', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUESTIONS_HEADER_PUBLISHED', 'q.published', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUESTIONS_HEADER_VERSION', 'q.version', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUESTIONS_HEADER_LAST_UPDATE', 'q.last_update', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>

    </th>
</tr>
