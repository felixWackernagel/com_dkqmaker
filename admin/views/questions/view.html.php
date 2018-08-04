<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class DKQMakerViewQuestions extends JViewLegacy
{
    function display($tpl = null)
    {
        // Get data from the model and assign data to the view
        $this->items         = $this->get('Items');
        $this->pagination    = $this->get('Pagination');
        $state               = $this->get('State');
        $this->state         = $state;

        // Table Filter
        $this->filterForm    = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

        // Table Sorting
        $this->sortDirection = $state->get('list.direction');
        $this->sortColumn    = $state->get('list.ordering');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }

        // Display the template
        $this->addSubmenu('questions');
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
        JToolBarHelper::title(JText::_('COM_DKQMAKER_QUESTIONS_TITLE'));
        JToolBarHelper::addNew('question.add');
        JToolBarHelper::editList('question.edit');
        JToolBarHelper::deleteList('', 'question.delete');
    }

    protected function setDocument()
    {
        $document = JFactory::getDocument();
        $document->setTitle(JText::_('COM_DKQMAKER_QUESTIONS_TITLE'));
    }
}