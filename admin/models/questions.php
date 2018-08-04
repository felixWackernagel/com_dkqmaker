<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class DKQMakerModelQuestions extends JModelList
{
    public function __construct($config = array())
    {
        // searchable fields
        if( empty( $config['filter_fields'] ) ) {
            $config['filter_fields'] = array(
                'id', 'q.id',
                'quiz_id', 'q.quiz_id',
                'question', 'q.question',
                'answer', 'q.answer',
                'number', 'q.number',
                'published', 'q.published',
                'version', 'q.version',
                'last_update', 'q.last_update'
            );
        }
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param   string  $ordering   An optional ordering field.
     * @param   string  $direction  An optional direction (asc|desc).
     *
     * @return    void
     *
     * @since    3.1
     */
    protected function populateState($ordering = 'quiz_number', $direction = 'ASC') {
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        parent::populateState( $ordering, $direction );
    }

    /* END TABLE SORTING */

    /**
     * Method to build an SQL query to load the list data.
     *
     * @return      string  An SQL query
     */
    protected function getListQuery()
    {
        // Create a new query
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select('q.id, u.number as quiz_number, q.number, q.question, q.answer, q.published, q.version, q.last_update')
            ->from('#__questions as q')
            ->leftJoin('#__quizzes as u ON u.id=q.quiz_id' );

        // Filter by search
        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            if (stripos($search, 'id:') === 0)
            {
                $query->where('q.id = ' . (int) substr($search, 3));
            }
            else
            {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(q.question LIKE ' . $search . ' OR q.answer LIKE ' . $search . ')');
            }
        }

        // sorting
        $orderColumn = $this->getState('list.ordering', 'quiz_number');
        $orderDirection = $this->getState('list.direction', 'ASC');
        $query->order($db->escape($orderColumn) . ' ' . $db->escape($orderDirection));

        return $query;
    }
}
