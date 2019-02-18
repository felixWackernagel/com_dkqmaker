<?php

defined('_JEXEC') or die;

JLoader::register('JsonHelper', JPATH_ADMINISTRATOR . '/components/com_dkqmaker/helpers/jsonHelper.php');

class QuizzesHelper extends JsonHelper
{
    // constructor
    public function __construct( $apiVersion )
    {
        parent::__construct( $apiVersion );
    }

    // chainable instance call
    public static function instance( $apiVersion )
    {
        return new self( $apiVersion );
    }

    protected function loadFromDB( $quizNumber, $parent = null )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'number', 'location', 'address', 'quiz_date', 'quiz_master_id', 'winner_id', 'latitude', 'longitude', 'version', 'last_update', 'published')))
            ->from($db->quoteName('#__quizzes'))
            ->order( 'number ASC');

        if( $quizNumber != -1 )
        {
            $query->where( 'number =' . $quizNumber );
        }

        $db->setQuery($query);
        return $db->LoadObjectList();
    }

    protected function modelToArray( $quiz, $singleModel )
    {
        if( is_null( $quiz ) )
        {
            return null;
        }

        if( $quiz->published == 0 )
        {
            if( $this->apiVersion >= 4 )
            {
                // empty array raised on a single model request a 404
                return null;
            }

            return array(
                "number" => intval( $quiz->number ),
                "version" => intval( $quiz->version ),
                "published" => intval( $quiz->published ),
                "lastUpdate" => $quiz->last_update
            );
        }

        $json = array(
            "number" => intval($quiz->number),
            "location" => $quiz->location,
            "quizDate" => $quiz->quiz_date,
            "latitude" => floatval($quiz->latitude),
            "longitude" => floatval($quiz->longitude),
            "version" => intval($quiz->version),
            "published" => intval($quiz->published),
            "lastUpdate" => $quiz->last_update
        );

        if( strlen( $quiz->address ) > 0 ) {
            $json["address"] = $quiz->address;
        }

        if( $quiz->quiz_master_id > 0 ) {
            $json["quizMaster"] = $this->getQuizzer( $quiz->quiz_master_id );
        }

        if( $quiz->winner_id > 0 ) {
            $json["winner"] = $this->getQuizzer( $quiz->winner_id );
        }

        if( $singleModel ) {
            $json["questions"] = $this->getQuestions( $quiz->id );
        }

        return $json;
    }

    private function getQuestions( $quizId )
    {
        $questions = $this->loadQuestionsFromDB( $quizId );
        return $this->questionsModelToArray( $questions );
    }

    private function loadQuestionsFromDB( $quizId )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'number', 'question', 'image', 'answer', 'version', 'last_update', 'published')))
            ->from($db->quoteName('#__questions'))
            ->where($db->quoteName('quiz_id') . '=' . $quizId )
            ->order('number ASC');
        $db->setQuery($query);
        return $db->LoadObjectList();
    }

    private function questionsModelToArray( $questions )
    {
        $result = array();
        foreach($questions as $question)
        {
            $converted = $this->questionModelToArray( $question );
            if( !is_null( $converted ) )
            {
                $result[] = $converted;
            }
        }
        return $result;
    }

    private function questionModelToArray( $question )
    {
        if( is_null( $question ) ) {
            return null;
        }

        if( $question->published == 0 ) {
            return array(
                "number" => intval($question->number),
                "published" => intval($question->published),
                "version" => intval($question->version),
                "lastUpdate" => $question->last_update
            );
        }

        $json = array(
            "number" => intval($question->number),
            "question" => $question->question,
            "answer" => $question->answer,
            "published" => intval($question->published),
            "version" => intval($question->version),
            "lastUpdate" => $question->last_update
        );

        if( strlen( $question->image ) > 0 ) {
            $imageUrl = JURI::root() . $question->image;
            $json["image_url"] = $imageUrl;
        }
        return $json;
    }

    private function getQuizzer( $quizzerId )
    {
        $quizzer = $this->loadQuizzerFromDB( $quizzerId );
        return $this->quizzerModelToArray( $quizzer );
    }

    private function loadQuizzerFromDB( $quizzerId )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select('id, number, name, image, version, last_update' )
            ->from('#__dkq_quizzers' )
            ->where('id=' . $quizzerId );
        $db->setQuery($query);
        return $db->LoadObject();
    }

    private function quizzerModelToArray( $quizzer )
    {
        if( is_null( $quizzer ) )
        {
            return null;
        }

        if( $this->apiVersion < 3 )
        {
            return $quizzer->name;
        }

        $json = array(
            "number" => intval( $quizzer->number ),
            "name" => $quizzer->name,
            "version" => intval($quizzer->version),
            "lastUpdate" => $quizzer->last_update
        );

        if( strlen( $quizzer->image ) > 0 ) {
            $imageUrl = JURI::root() . $quizzer->image;
            $json["image"] = $imageUrl;
        }

        return $json;
    }
}