<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

class DKQMakerControllerQuestion extends JControllerForm
{
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
						$query='DELETE FROM #__questions WHERE id = '.$id;
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
					$query='DELETE FROM #__questions WHERE id = '.$cid;
					$db->setQuery($query);
					$db->query();
				}
			}
			JFactory::getApplication()->enqueueMessage(JText::_('COM_DKQMAKER_QUESTION_DELETED_MESSAGE'));
			$app =& JFactory::getApplication();

			$app->redirect('index.php?option=com_dkqmaker&view=questions');
		}

}