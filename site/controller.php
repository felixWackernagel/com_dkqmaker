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

class DKQMakerController extends JControllerLegacy
{
    private $latestVersion = 4;

	public function show()
	{
		// read url parameter
        $view = JRequest::getVar('view', 'quizzes');
        $id = intval(JRequest::getVar('id',0));
        $quizNumber = intval(JRequest::getVar('quiz',0));
        $questionNumber = intval(JRequest::getVar('question',0));
        $apiVersion = intval(JRequest::getVar('v',$this->latestVersion));
        $lastUpdate = JRequest::getVar('lastUpdate','0000-00-00 00:00:00');

        $data = array();
        switch( $view )
        {
            case "quizzes":
                $data = $this->getQuizJSON( $quizNumber, $apiVersion );
                break;

            case "questions":
                $data = $this->getQuestionJSON( $quizNumber, $questionNumber );
                break;

            case "messages":
                $data = MessagesHelper::instance( $apiVersion )->buildJsonData( $id );
                break;

            case "quizzers":
                $data = QuizzersHelper::instance( $apiVersion )->buildJsonData( $id );
                break;

            case "versions":
                $data = VersionsHelper::instance( $apiVersion )->buildJsonData( $id );
                break;
        }

		// set headers for pretty print
		header('content-type: application/json; charset=utf-8');
		
		// write response
		echo json_encode($data,JSON_PRETTY_PRINT);
		
		// don't print template
		$app = JFactory::getApplication('site');
		$app->close();
	}

	public function getQuizJSON( $quizNumber, $apiVersion )
    {
        $data = array();
        if( $quizNumber > 0 )
        {
            // single quiz with questions
            $data = $this->addReferences( $this->getQuiz( $quizNumber ), $apiVersion );
            if( count( $data ) == 1 )
            {
                $data = $data[0];
            }
            else if( count( $data ) == 0 )
            {
                $data = json_decode("{}");
            }
        }
        else
        {
            // all quizzes without questions
            $data = $this->getQuizzes($apiVersion);
        }
        return $data;
    }

	public function getQuestionJSON( $quizNumber, $questionNumber )
    {
        $data = array();
        if($quizNumber > 0 && $questionNumber > 0)
        {
            // single question
            $data = $this->getQuestion( $quizNumber, $questionNumber );
            if( count( $data ) == 1 )
            {
                $data = $data[0];
            }
            else if( count( $data ) == 0 )
            {
                $data = json_decode("{}");
            }
        }
        else if( $quizNumber > 0 )
        {
            // all questions of a single quiz
            $data = $this->getQuestionsForQuizNumber( $quizNumber );
        }
        return $data;
    }

	public function quizzesToArray( &$quizzes, $apiVersion )
	{
		$result = array();
		foreach($quizzes as &$quiz)
		{
		    $result[] = $this->quizToArray( $quiz, $apiVersion );
		}
		return $result;
	}

	public function quizToArray( &$quiz, $apiVersion )
	{
	    if( $quiz == null ) {
	        return array();
        }
	    if( $quiz->published == 0 ) {
            return array(
                "number" => intval( $quiz->number ),
                "version" => intval( $quiz->version ),
                "published" => intval( $quiz->published ),
                "lastUpdate" => $quiz->last_update
            );
        } else {
            $result = array(
                "number" => intval($quiz->number),
                "location" => $quiz->location,
                "quizDate" => $quiz->quiz_date,
                "latitude" => floatval($quiz->latitude),
                "longitude" => floatval($quiz->longitude),
                "version" => intval($quiz->version),
                "published" => intval($quiz->published),
                "lastUpdate" => $quiz->last_update
            );
            if( count( $quiz->address ) > 0 ) {
                $result["address"] = $quiz->address;
            }
            if( $quiz->quiz_master_id > 0 ) {
                $result["quizMaster"] = $this->getQuizzerForQuiz($quiz->quiz_master_id, $apiVersion);
            }
            if( $quiz->winner_id > 0 ) {
                $result["winner"] = $this->getQuizzerForQuiz($quiz->winner_id, $apiVersion);
            }
            return $result;
        }
    }

	public function questionsToArray( &$questions )
	{
		$result = array();
		foreach($questions as &$question)
		{
		    $result[] = $this->questionToArray( $question );
		}
		return $result;
	}

	public function questionToArray( &$question )
	{
	    if( $question == null ) {
            return array();
        }

        if( $question->published == 0 )
        {
            return array(
                "number" => intval($question->number),
                "published" => intval($question->published),
                "version" => intval($question->version),
                "lastUpdate" => $question->last_update
            );
        }
        else
        {
            $result = array(
                "number" => intval($question->number),
                "question" => $question->question,
                "answer" => $question->answer,
                "published" => intval($question->published),
                "version" => intval($question->version),
                "lastUpdate" => $question->last_update
            );
            if( count( $question->image ) > 0 ) {
                $image = JURI::root() . $question->image;
                $result["image_url"] = $image;
            }
            return $result;
        }
	}

    public function addReferences(&$quizModel, $apiVersion)
    {
        $result = array();
        $row = $this->quizToArray( $quizModel, $apiVersion );
        if( $quizModel != null && $quizModel->published == 1 ) {
            $row["questions"] = $this->getQuestionsForQuiz($quizModel->id);
        }
        if( count( $row ) > 0 ) {
            $result[] = $row;
        }
        return $result;
    }

    public function getQuizzerForQuiz($quizzerId, $apiVersion)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select('id, number, name, image, version, last_update' )
            ->from('#__dkq_quizzers' )
            ->where('id=' . $quizzerId );
        $db->setQuery($query);
        $data= $db->LoadObject();
        return $this->quizzerToArray( $data, $apiVersion );
    }

    public function quizzerToArray($quizzerModel, $apiVersion)
    {
        if( $quizzerModel == null )
        {
            return null;
        }

        if( $apiVersion < 3 )
        {
            return $quizzerModel->name;
        }

        if( strlen( $quizzerModel->image ) > 0 )
        {
            $image = JURI::root() . $quizzerModel->image;
            return array(
                "number" => intval( $quizzerModel->number ),
                "name" => $quizzerModel->name,
                "image" => $image,
                "version" => intval($quizzerModel->version),
                "lastUpdate" => $quizzerModel->last_update
            );
        }
        else
        {
            return array(
                "number" => intval( $quizzerModel->number ),
                "name" => $quizzerModel->name,
                "version" => intval($quizzerModel->version),
                "lastUpdate" => $quizzerModel->last_update
            );
        }
    }

	public function addQuestions(&$quiz, $apiVersion)
	{
		$result = array();
        $row = $this->quizToArray( $quiz, $apiVersion );
        if( $quiz != null && $quiz->published == 1 ) {
            $row["questions"] = $this->getQuestionsForQuiz($quiz->id);
        }
        if( count( $row ) > 0 ) {
            $result[] = $row;
        }
		return $result;
	}

    public function getQuestionsForQuizNumber($quizNumber)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select('q.id, q.number, q.question, q.answer, q.image, q.version, q.last_update, q.published' )
            ->from('#__questions as q' )
            ->leftJoin('#__quizzes as x ON x.id = q.quiz_id' )
            ->where('x.number=' . $quizNumber )
            ->order('q.number ASC' );
        $db->setQuery($query);
        $data= $db->LoadObjectList();
        return $this->questionsToArray( $data );
    }

    public function getQuestionsForQuiz($quizId)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'number', 'question', 'image', 'answer', 'version', 'last_update', 'published')))
            ->from($db->quoteName('#__questions'))
            ->where($db->quoteName('quiz_id') . '=' . $quizId )
            ->order('number ASC');
        $db->setQuery($query);
        $data= $db->LoadObjectList();
        return $this->questionsToArray( $data );
    }

    public function getQuestion($quizNumber, $questionNumber)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select('q.id, q.number, q.question, q.answer, q.image, q.version, q.last_update, q.published')
            ->from('#__questions as q')
            ->leftJoin('#__quizzes as x ON x.id = q.quiz_id' )
            ->where('x.number =' . $quizNumber . ' AND q.number =' . $questionNumber );
        $db->setQuery($query);
        $data= $db->LoadObject();
        return $this->questionToArray( $data );
    }

    public function getQuiz($number)
    {
	    $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'number', 'location', 'address', 'quiz_date', 'quiz_master_id', 'winner_id', 'latitude', 'longitude', 'version', 'last_update', 'published')))
            ->from($db->quoteName('#__quizzes'))
            ->where($db->quoteName('number') . '=' . $number );
        $db->setQuery($query);
	    $data = $db->LoadObject();
        return $data;
    }

    public function getQuizzes($apiVersion)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'number', 'location', 'address', 'quiz_date', 'quiz_master_id', 'winner_id', 'latitude', 'longitude', 'version', 'last_update', 'published')))
            ->from($db->quoteName('#__quizzes'))
            ->order('number ASC');
        $db->setQuery($query);
        $data = $db->LoadObjectList();
        return $this->quizzesToArray( $data, $apiVersion );
    }
}
