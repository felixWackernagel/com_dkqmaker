<?php
defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldQuiz extends JFormFieldList
{
    protected $type = 'Quiz';

    public function getOptions()
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select('id, number')
            ->from('#__quizzes')
            ->order('number');
        $db->setQuery($query);
        $quizzes = $db->loadObjectList();
        $options  = array();
        if ($quizzes)
        {
            foreach ($quizzes as $quiz)
            {
                $options[] = JHtml::_('select.option', $quiz->id, $quiz->number);
            }
        }
        return array_merge(parent::getOptions(), $options);
    }
}