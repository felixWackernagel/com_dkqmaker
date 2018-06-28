<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * Quiz Model
 */
class DKQMakerModelQuiz extends JModelAdmin
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
        public function getTable($name = 'Quiz', $prefix = 'DKQMakerTable', $options = array())
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
                $form = $this->loadForm('com_dkqmaker.quiz', 'quiz',
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
                $data = JFactory::getApplication()->getUserState('com_dkqmaker.edit.quiz.data', array());
                if (empty($data))
                {
                        $data = $this->getItem();
                }
                return $data;
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