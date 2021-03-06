<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * Quiz Model
 */
class DKQMakerModelMessage extends JModelAdmin
{
        /**
         * Returns a reference to the a Table object, always creating it.
         *
         * @param       type    The table type to instantiate
         * @param       string  A prefix for the table class name. Optional.
         * @param       array   Configuration array for model. Optional.
         * @return      JTable  A database object
         * @since       2.5
         */
        public function getTable($name = 'Message', $prefix = 'DKQMakerTable', $options = array())
        {
                return JTable::getInstance($name, $prefix, $options);
        }
        /**
         * Method to get the record form.
         *
         * @param       array   $data           Data for the form.
         * @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
         * @return      mixed   A JForm object on success, false on failure
         * @since       2.5
         */
        public function getForm($data = array(), $loadData = true)
        {
                // Get the form.
                $form = $this->loadForm('com_dkqmaker.message', 'message',
                                        array('control' => 'jform', 'load_data' => $loadData));
                if (empty($form))
                {
                        return false;
                }
                return $form;
        }

        /**
         * Method to get the data that should be injected in the form.
         *
         * @return      mixed   The data for the form.
         * @since       2.5
         */
        protected function loadFormData()
        {
            // Check the session for previously entered form data.
            $data = JFactory::getApplication()->getUserState('com_dkqmaker.edit.message.data', array());
            if( empty( $data ) )
            {
                // no session data so load from database
                $data = $this->getItem();
            }

            if( $data->number == 0 ) {
                $data->number = $this->loadNextMessageNumber();
            }

            if( $data->offline_date == '0000-00-00' || $data->offline_date == '0000-00-00 00:00:00') {
                $data->offline_date = NULL;
            }

            return $data;
        }

    private function loadNextMessageNumber()
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select('MAX(' . $db->quoteName('number') .')' )
            ->from( $db->quoteName('#__dkq_messages' ) );
        $db->setQuery($query);
        return intval( $db->loadResult() ) + 1;
    }

        /**
         * Prepare and sanitise the table data prior to saving.
         *
         * @param   JTable  $table  A JTable object.
         *
         * @return  void
         *
         * @since   1.6
         */
        protected function prepareTable($table)
        {
            // Increment the content version number.
            $table->version++;

            // set last update to now
            $table->last_update = JFactory::getDate()->toSql();
        }
}