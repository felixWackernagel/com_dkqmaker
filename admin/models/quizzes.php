<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class DKQMakerModelQuizzes extends JModelList
{
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
                // Select some fields from the table
                $query
                    ->select('id, number, location, address, quiz_date, quiz_master, latitude, longitude, published, version, last_update')
                    ->from('#__quizzes');

                // START TABLE SORTING
                $orderCol = $this->state->get('list.ordering', 'number');
                $orderDir = $this->state->get('list.direction', 'DESC');
                $query
                    ->order($db->escape($orderCol) . ' ' . $db->escape($orderDir));
                // END TABLE SORTING
 
                return $query;
        }

        /* START TABLE SORTING */
        /* https://docs.joomla.org/Adding_sortable_columns_to_a_table_in_a_component */

        public function __construct($config = array())
        {
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

        protected function populateState($ordering = null, $direction = null) {
            parent::populateState('number', 'ASC');
        }

        /* END TABLE SORTING */
}
