<?php

defined('_JEXEC') or die;

class MenuHelper {

    public static function addSubmenu( $activeMenu )
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

        JHtmlSidebar::addEntry(
            JText::_('COM_DKQMAKER_SIDEBAR_MENU_MESSAGES'),
            'index.php?option=com_dkqmaker&view=messages',
            $activeMenu == 'messages'
        );
    }

}