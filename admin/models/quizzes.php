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
                'id',
                'number',
                'location',
                'address',
                'quiz_date',
                'quiz_master',
                'latitude',
                'longitude',
                'published',
                'version',
                'last_update'
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
            ->select('id, number, location, address, quiz_date, quiz_master, latitude, longitude, published, version, last_update')
            ->from('#__quizzes');

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
                $query->where('(location LIKE ' . $search . ' OR number LIKE ' . $search . ' OR address LIKE ' . $search . ' OR quiz_date LIKE ' . $search . ' OR quiz_master LIKE ' . $search . ' OR latitude LIKE ' . $search . ' OR longitude LIKE ' . $search . ')');
            }
        }

        // sorting
        $orderColumn = $this->getState('list.ordering', 'number');
        $orderDirection = $this->getState('list.direction', 'ASC');
        $query->order($db->escape($orderColumn) . ' ' . $db->escape($orderDirection));

        return $query;
    }
}
