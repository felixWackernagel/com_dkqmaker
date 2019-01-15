<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class DKQMakerModelQuizzes extends JModelList
{
    public function __construct($config = array())
    {
        // searchable fields
        if( empty( $config['filter_fields'] ) ) {
            $config['filter_fields'] = array(
                'id', 'q.id',
                'number', 'q.number',
                'location', 'q.location',
                'address', 'q.address',
                'quiz_date', 'q.quiz_date',
                'name', 'u.name', 'w.name',
                'latitude', 'q.latitude',
                'longitude', 'q.longitude',
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
    protected function populateState($ordering = 'number', $direction = 'ASC') {
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        parent::populateState($ordering, $direction);
    }

    /**
     * Method to build an SQL query to load the list data.
     *
     * @return      string  An SQL query
     */
    protected function getListQuery()
    {
        // Create a new query object.
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select('q.id, q.number, q.location, q.address, q.quiz_date, u.name as quiz_master_name, w.name as winner_name, q.latitude, q.longitude, q.published, q.version, q.last_update')
            ->from('#__quizzes as q')
            ->leftJoin('#__dkq_quizzers as u ON u.id = q.quiz_master_id')
            ->leftJoin('#__dkq_quizzers as w ON w.id = q.winner_id');

        // Filter by published
        $published = $this->getState('filter.published');
        if (is_numeric($published))
        {
            $query->where($db->quoteName('published') . ' = ' . (int) $published);
        }
        elseif ($published === '')
        {
            $query->where($db->quoteName('published') . ' IN (0, 1)');
        }

        // Filter by quiz master id
        $quizMasterId = $this->getState('filter.quiz_master_id');
        if (is_numeric($quizMasterId))
        {
            $query->where($db->quoteName('quiz_master_id') . ' = ' . (int) $quizMasterId);
        }

        // Filter by winner id
        $winnerId = $this->getState('filter.winner_id');
        if (is_numeric($winnerId))
        {
            $query->where($db->quoteName('winner_id') . ' = ' . (int) $winnerId);
        }

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
                $query->where('(location LIKE ' . $search . ' OR q.number LIKE ' . $search . ' OR address LIKE ' . $search . ' OR quiz_date LIKE ' . $search . ' OR latitude LIKE ' . $search . ' OR longitude LIKE ' . $search . ' OR u.name LIKE ' . $search . ' OR w.name LIKE ' . $search . ')');
            }
        }

        // sorting
        $orderColumn = $this->getState('list.ordering', 'number');
        $orderDirection = $this->getState('list.direction', 'ASC');
        $query->order($db->escape($orderColumn) . ' ' . $db->escape($orderDirection));

        return $query;
    }
}
