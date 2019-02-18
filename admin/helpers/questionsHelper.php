<?php

defined('_JEXEC') or die;

JLoader::register('JsonHelper', JPATH_ADMINISTRATOR . '/components/com_dkqmaker/helpers/jsonHelper.php');

class QuestionsHelper extends JsonHelper
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

    protected function loadFromDB( $quizNumber, $questionNumber = null )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select('q.id, q.number, q.question, q.answer, q.image, q.version, q.last_update, q.published')
            ->from('#__questions as q')
            ->leftJoin('#__quizzes as x ON x.id = q.quiz_id' )
            ->where('x.number =' . $quizNumber )
            ->order('q.number ASC' );

        if( !is_null( $questionNumber ) && $questionNumber != -1 )
        {
            $query->where( 'q.number =' . $questionNumber );
        }

        $db->setQuery($query);
        return $db->LoadObjectList();
    }

    protected function modelToArray( $question, $singleModel )
    {
        if( is_null( $question ) ) {
            return null;
        }

        if( $question->published == 0 )
        {
            if( $this->apiVersion >= 4 ) {
                // empty array raised on a single model request a 404
                return null;
            }

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
}