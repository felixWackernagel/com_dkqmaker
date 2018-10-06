<?php
/**
* @package Joomla.Administrator
* @subpackage com_helloworld
*
* @copyright Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
*/
 
// No direct access to this file
defined('_JEXEC') or die;
 
// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * Class DKQMakerController
 *
 * App Workflow:
 * search local for quiz by number
 * if quiz not found
 *  then insert
 * else if online quiz version > local quiz version
 *  then update
 * else
 *  do nothing
 *
 */
class DKQMakerController extends JControllerLegacy
{
    private $latestVersion = 1;

	public function show()
	{
		// read url parameter
        $view = JRequest::getVar('view', 'quizzes');
        $id = intval(JRequest::getVar('id',0));
        $quizNumber = intval(JRequest::getVar('quiz',0));
        $questionNumber = intval(JRequest::getVar('question',0));
        $apiVersion = intval(JRequest::getVar('v',$this->latestVersion));
        $lastUpdate = JRequest::getVar('lastUpdate','0000-00-00 00:00:00');

        // fetch data
		$data = array();
		if( $view == 'quizzes' )
		{
			if( $quizNumber > 0 )
            {
                // single quiz with questions
                $data = $this->addQuestions( $this->getQuiz( $quizNumber ) );
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
                $data = $this->getQuizzes();
            }
		}
		else if( $view == 'questions' )
		{
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
		}
        else if( $view == 'messages' )
        {
            $data = $this->getMessages( $id );
        }
        else if( $view == 'quizzers' )
        {
            $data = $this->getQuizzers( $id );
        }
        else if( $view == 'versions' )
        {
            $data = $this->checkVersion( $id );
        }

		// set headers for pretty print
		header('content-type: application/json; charset=utf-8');
		
		// write response
		echo json_encode($data,JSON_PRETTY_PRINT);
		
		// don't print template
		$app = JFactory::getApplication('site');
		$app->close();
	}

	public function quizzesToArray( &$quizzes )
	{
		$result = array();
		foreach($quizzes as &$quiz)
		{
		    $result[] = $this->quizToArray( $quiz );
		}
		return $result;
	}

	public function quizToArray( &$quiz )
	{
	    if( $quiz == null ) {
	        return array();
        }
	    if( $quiz->published == 0 ) {
            return array(
                //"id" => intval( $quiz->id ),
                "number" => intval( $quiz->number ),
                "version" => intval( $quiz->version ),
                "published" => intval( $quiz->published ),
                "lastUpdate" => $quiz->last_update
            );
        } else {
            return array(
                //"id" => intval($quiz->id),
                "number" => intval($quiz->number),
                "location" => $quiz->location,
                "address" => $quiz->address,
                "quizDate" => $quiz->quiz_date,
                "quizMaster" => $quiz->quiz_master,
                "latitude" => floatval($quiz->latitude),
                "longitude" => floatval($quiz->longitude),
                "version" => intval($quiz->version),
                "published" => intval($quiz->published),
                "lastUpdate" => $quiz->last_update
            );
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
                //"id" => intval($question->id),
                "number" => intval($question->number),
                "published" => intval($question->published),
                "version" => intval($question->version),
                "lastUpdate" => $question->last_update
            );
        }
        else
        {
            return array(
                //"id" => intval($question->id),
                "number" => intval($question->number),
                "question" => $question->question,
                "answer" => $question->answer,
                "published" => intval($question->published),
                "version" => intval($question->version),
                "lastUpdate" => $question->last_update
            );
        }
	}

	public function addQuestions(&$quiz)
	{
		$result = array();
        $row = $this->quizToArray( $quiz );
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
            ->select('q.id, q.number, q.question, q.answer, q.version, q.last_update, q.published' )
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
            ->select($db->quoteName(array('id', 'number', 'question', 'answer', 'version', 'last_update', 'published')))
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
            ->select('q.id, q.number, q.question, q.answer, q.version, q.last_update, q.published')
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
            ->select($db->quoteName(array('id', 'number', 'location', 'address', 'quiz_date', 'quiz_master', 'latitude', 'longitude', 'version', 'last_update', 'published')))
            ->from($db->quoteName('#__quizzes'))
            ->where($db->quoteName('number') . '=' . $number );
        $db->setQuery($query);
	    $data = $db->LoadObject();
        return $data;
    }

    public function getQuizzes()
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'number', 'location', 'address', 'quiz_date', 'quiz_master', 'latitude', 'longitude', 'version', 'last_update', 'published')))
            ->from($db->quoteName('#__quizzes'))
            ->order('number ASC');
        $db->setQuery($query);
        $data = $db->LoadObjectList();
        return $this->quizzesToArray( $data );
    }

    /*
     * Loads one or all messages.
     * A message musst be a online_date of today or older.
     * The offline_date can be null or lies in the future.
     */
    public function getMessages( $number )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'number', 'title', 'content', 'image', 'online_date', 'offline_date', 'version', 'last_update')))
            ->from($db->quoteName('#__dkq_messages'))
            ->where( 'DATEDIFF( online_date, NOW() ) <= 0 AND (DATEDIFF( offline_date, NOW() ) IS NULL OR DATEDIFF( offline_date, NOW() ) > 0)')
            ->order( 'number ASC');

        if( $number > 0 )
        {
            $query->where( 'number =' . $number );
        }

        $db->setQuery($query);
        return $this->messagesToArray( $db->LoadObjectList(), $number > 0 );
    }

    public function messagesToArray( &$messages, $singleItem )
    {
        $result = array();
        foreach($messages as &$message)
        {
            $converted = $this->messageToArray( $message );
            if( $converted != null )
            {
                $result[] = $converted;
            }
        }
        if( count( $result ) == 1 && $singleItem )
        {
            $result = $result[0];
        }
        else if( count( $result ) == 0 )
        {
            if( $singleItem )
            {
                $result = json_decode("{}");
            }
            else
            {
                $result = json_decode("[]");
            }
        }
        return $result;
    }

    public function messageToArray( &$message )
    {
        if( $message == null )
        {
            return null;
        }

        if( strlen( $message->image ) > 0 )
        {
            $image = JURI::root() . $message->image;
            return array(
                "number" => intval( $message->number ),
                "title" => $message->title,
                "content" => $message->content,
                "image" => $image,
                "version" => intval($message->version),
                "lastUpdate" => $message->last_update
            );
        }
        else
        {
            return array(
                "number" => intval( $message->number ),
                "title" => $message->title,
                "content" => $message->content,
                "version" => intval($message->version),
                "lastUpdate" => $message->last_update
            );
        }
    }

    public function checkVersion( $versionCode )
    {
        $app = JFactory::getApplication();
        $params = $app->getParams('com_dkqmaker');
        $appVersion = $params->get('play_store_app_version');

        return array(
            "validVersion" => ($appVersion == $versionCode ? 1 : 0 )
        );
    }

    /*
     * Loads one or all quizzers.
     */
    public function getQuizzers( $number )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'number', 'name', 'image', 'version', 'last_update')))
            ->from($db->quoteName('#__dkq_quizzers'))
            ->order( 'number ASC');

        if( $number > 0 )
        {
            $query->where( 'number =' . $number );
        }

        $db->setQuery($query);
        return $this->quizzersToArray( $db->LoadObjectList(), $number > 0  );
    }

    public function quizzersToArray( &$quizzers, $singleItem )
    {
        $result = array();
        foreach($quizzers as &$quizzer)
        {
            $converted = $this->quizzerToArray( $quizzer );
            if( $converted != null )
            {
                $result[] = $converted;
            }
        }
        if( count( $result ) == 1 && $singleItem )
        {
            $result = $result[0];
        }
        else if( count( $result ) == 0 )
        {
            $result = json_decode("{}");
        }
        return $result;
    }

    public function quizzerToArray( &$quizzer )
    {
        if( $quizzer == null ) {
            return null;
        }

        $image = '';
        if( count( $quizzer->image ) > 0 ) {
            $image = JURI::root() . $quizzer->image;
        }

        return array(
            "number" => intval( $quizzer->number ),
            "name" => $quizzer->name,
            "image" => $image,
            "version" => intval($quizzer->version),
            "lastUpdate" => $quizzer->last_update
        );
    }
}
