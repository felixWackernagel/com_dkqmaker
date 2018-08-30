<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_ADMINISTRATOR.'/'.'components'.'/'.'com_dkqmaker'.'/'.'helpers'.'/'.'menu.php');

class DKQMakerViewQuizzes extends JViewLegacy
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
        MenuHelper::addSubmenu('quizzes');
        $this->sidebar = JHtmlSidebar::render();
        $this->addToolBar();
        $this->setDocument();
        parent::display($tpl);
    }

    protected function addToolBar()
    {
        JToolBarHelper::title(JText::_('COM_DKQMAKER_QUIZZES_TITLE'));
        JToolBarHelper::addNew('quiz.add');
        JToolBarHelper::editList('quiz.edit');
        JToolBarHelper::deleteList('', 'quiz.delete');
        JToolBarHelper::preferences('com_dkqmaker');
    }

    protected function setDocument()
    {
        $document = JFactory::getDocument();
        $document->setTitle(JText::_('COM_DKQMAKER_QUIZZES_TITLE'));
    }
}