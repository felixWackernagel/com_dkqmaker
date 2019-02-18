<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class DKQMakerModelMessages extends JModelList
{
    public function __construct($config = array())
    {
        // searchable fields
        if( empty( $config['filter_fields'] ) ) {
            $config['filter_fields'] = array(
                'id', 'm.id',
                'number', 'm.number',
                'quiz_id', 'm.quiz_id',
                'title', 'm.title',
                'content', 'm.content',
                'image', 'm.image',
                'online_date', 'm.online_date',
                'offline_date', 'm.offline_date',
                'version', 'm.version',
                'last_update', 'm.last_update'
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
    protected function populateState($ordering = 'id', $direction = 'ASC') {
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
            ->select('m.id, m.number, q.number as quiz_number, m.title, m.content, m.image, m.online_date, m.offline_date, m.version, m.last_update')
            ->from('#__dkq_messages AS m')
            ->leftJoin('#__quizzes as q ON q.id=m.quiz_id' );

        // Filter by search
        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            // search inside id when search term starts with id:
            if (stripos($search, 'id:') === 0)
            {
                $query->where('id = ' . (int) substr($search, 3));
            }
            else
            {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(title LIKE ' . $search . ' OR content LIKE ' . $search . ')');
            }
        }

        // sorting
        $orderColumn = $this->getState('list.ordering', 'id');
        $orderDirection = $this->getState('list.direction', 'ASC');
        $query->order($db->escape($orderColumn) . ' ' . $db->escape($orderDirection));

        return $query;
    }
}
