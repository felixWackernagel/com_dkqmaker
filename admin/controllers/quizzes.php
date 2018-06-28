<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class DKQMakerControllerQuizzes extends JControllerAdmin
{
        /**
         * Proxy for getModel.
         * @since       1.6
         */
        public function getModel($name = 'Quiz', $prefix = 'DKQMakerModel', $config = array('ignore_request' => true) )
        {
                $model = parent::getModel($name, $prefix, $config);
                return $model;
        }
		
}