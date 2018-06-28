<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class DKQMakerViewQuizzes extends JViewLegacy
{
    function display($tpl = null)
    {
        // Get data from the model
        $items = $this->get('Items');
        $pagination = $this->get('Pagination');
        $state = $this->get('State');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        // Assign data to the view
        $this->items = $items;
        $this->pagination = $pagination;

        // Start Table Sorting
        $this->sortDirection = $state->get('list.direction');
        $this->sortColumn = $state->get('list.ordering');
        // End Table Sorting

        // Display the template
        $this->addSubmenu('quizzes');
        $this->sidebar = JHtmlSidebar::render();
        $this->addToolBar();
        $this->setDocument();
        parent::display($tpl);
    }

    protected function addSubmenu($activeMenu)
    {
        JHtmlSidebar::addEntry(
            JText::_('COM_DKQMAKER_SIDEBAR_MENU_QUIZZES'),
            'index.php?option=com_dkqmaker&view=quizzes',
            $activeMenu == 'quizzes'
        );

        JHtmlSidebar::addEntry(
            JText::_('COM_DKQMAKER_SIDEBAR_MENU_QUESTIONS'),
            'index.php?option=com_dkqmaker&view=questions',
            $activeMenu == 'questions'
        );
    }

    protected function addToolBar()
    {
        JToolBarHelper::title(JText::_('COM_DKQMAKER_QUIZZES_TITLE'));
        JToolBarHelper::addNew('quiz.add');
        JToolBarHelper::editList('quiz.edit');
        JToolBarHelper::deleteList('', 'quiz.delete');
    }

    protected function setDocument()
    {
        $document = JFactory::getDocument();
        $document->setTitle(JText::_('COM_DKQMAKER_QUIZZES_TITLE'));
    }
}