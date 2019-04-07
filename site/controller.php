<?php
/**
* @package Joomla.Administrator
* @subpackage com_helloworld
*
* @copyright Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
*/
 
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

JLoader::register('MessagesHelper', JPATH_ADMINISTRATOR . '/components/com_dkqmaker/helpers/messagesHelper.php');
JLoader::register('QuizzersHelper', JPATH_ADMINISTRATOR . '/components/com_dkqmaker/helpers/quizzersHelper.php');
JLoader::register('VersionsHelper', JPATH_ADMINISTRATOR . '/components/com_dkqmaker/helpers/versionsHelper.php');
JLoader::register('QuizzesHelper', JPATH_ADMINISTRATOR . '/components/com_dkqmaker/helpers/quizzesHelper.php');
JLoader::register('QuestionsHelper', JPATH_ADMINISTRATOR . '/components/com_dkqmaker/helpers/questionsHelper.php');

class DKQMakerController extends JControllerLegacy
{
    private $latestVersion = 4;

	public function show()
	{
        // read url parameter
        $view = JRequest::getVar('view', 'quizzes');
        $id = intval(JRequest::getVar('id',-1));
        $quizNumber = intval(JRequest::getVar('quiz',-1));
        $questionNumber = intval(JRequest::getVar('question',-1));
        $apiVersion = intval(JRequest::getVar('v',$this->latestVersion));
        $lastUpdate = JRequest::getVar('lastUpdate','0000-00-00 00:00:00');

        $data = array();

        $app = JFactory::getApplication();
        $params = $app->getParams('com_dkqmaker');
        $apiEnabled = $params->get('web_api_enabled');

        if( $apiEnabled == 1 || $apiVersion < 4 )
        {
            try {
                $result = array();
                switch ($view) {
                    case "quizzes":
                        $result = QuizzesHelper::instance($apiVersion)->buildJsonData($quizNumber);
                        break;

                    case "questions":
                        $result = QuestionsHelper::instance($apiVersion)->buildJsonData($quizNumber, $questionNumber);
                        break;

                    case "messages":
                        $result = MessagesHelper::instance($apiVersion)->buildJsonData($id);
                        break;

                    case "quizzers":
                        $result = QuizzersHelper::instance($apiVersion)->buildJsonData($id);
                        break;

                    case "versions":
                        $result = VersionsHelper::instance($apiVersion)->buildJsonData($id);
                        break;
                }
                if( $apiVersion < 4 )
                {
                    $data = $result;
                }
                else
                {
                    $data = array(
                        "status" => "ok",
                        "code" => intval( 202 ),
                        "result" => $result
                    );
                }
            }
            catch ( Exception $e )
            {
                $data = array(
                    "status" => "error",
                    "code" => intval( $e->getCode() ),
                    "message" => $e->getMessage()
                );
            }
        }
        else
        {


            $data = array(
                "status" => "error",
                "code" => intval( 503 ),
                "message" => JText::_("COM_DKQMAKER_ERROR_503")
            );
        }

		// set headers for pretty print
		header('content-type: application/json; charset=utf-8');
		
		// write response
		echo json_encode($data,JSON_PRETTY_PRINT);
		
		// don't print template
		$app = JFactory::getApplication('site');
		$app->close();
	}
}
