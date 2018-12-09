<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
    <th width="20">
        <?php echo JHtml::_('grid.checkall'); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZES_HEADER_ID', 'id', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZES_HEADER_NUMBER', 'number', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZES_HEADER_LOCATION', 'location', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZES_HEADER_ADDRESS', 'address', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZES_HEADER_ID_QUIZ_DATE', 'quiz_date', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZES_HEADER_QUIZ_MASTER', 'quiz_master_name', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZES_HEADER_WINNER', 'winner_name', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZES_HEADER_LATITUDE', 'latitude', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZES_HEADER_LONGITUDE', 'longitude', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZES_HEADER_PUBLISHED', 'published', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZES_HEADER_VERSION', 'version', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>
        <?php echo JHTML::_( 'grid.sort', 'COM_DKQMAKER_QUIZZES_HEADER_LAST_UPDATE', 'last_update', $this->sortDirection, $this->sortColumn); ?>
    </th>
    <th>

    </th>
</tr>
