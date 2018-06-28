<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * HelloWorld Controller
 */
class DKQMakerControllerQuiz extends JControllerForm
{
        public function save($key = null, $urlVar = null)
        {
            $return = parent::save($key, $urlVar);
            $this->setRedirect(JRoute::_('index.php?option=com_dkqmaker&view=quizzes'));
            return $return;
        }

        public function cancel($key = null, $urlVar = null)
        {
            $return = parent::cancel($key, $urlVar);
            $this->setRedirect(JRoute::_('index.php?option=com_dkqmaker&view=quizzes'));
            return $return;
        }

		public function delete()
		{
			$cid = JRequest::getVar('cid',0);
			
			$db = &JFactory::getDBO();
			if(is_array($cid))
			{
				foreach($cid as $id)
				{
					if(intval($id)>0)
					{
						$query=$db->getQuery(true);
						$query='DELETE FROM #__quizzes WHERE id = '.$id;
						$db->setQuery($query);
						$db->query();
					}
				}
			}
			else
			{
				if(intval($cid)>0)
				{
					$db = &JFactory::getDBO();
					$query=$db->getQuery(true);
					$query='DELETE FROM #__quizzes WHERE id = '.$cid;
					$db->setQuery($query);
					$db->query();
				}
			}
			JFactory::getApplication()->enqueueMessage(JText::_('COM_DKQMAKER_QUIZ_DELETED_MESSAGE'));
			$app =& JFactory::getApplication();

			$app->redirect('index.php?option=com_dkqmaker&view=quizzes');
		}

}