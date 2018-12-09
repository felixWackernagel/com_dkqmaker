<?php
defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldQuizzer extends JFormFieldList
{
    protected $type = 'Quizzer';

    public function getOptions()
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select('id, name')
            ->from('#__dkq_quizzers')
            ->order('name');
        $db->setQuery($query);
        $quizzers = $db->loadObjectList();
        $options  = array();
        if ($quizzers)
        {
            foreach ($quizzers as $quizzer)
            {
                $options[] = JHtml::_('select.option', $quizzer->id, $quizzer->name);
            }
        }
        return array_merge(parent::getOptions(), $options);
    }
}