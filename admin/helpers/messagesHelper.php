<?php

defined('_JEXEC') or die;

JLoader::register('JsonHelper', JPATH_ADMINISTRATOR . '/components/com_dkqmaker/helpers/jsonHelper.php');

class MessagesHelper extends JsonHelper
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

    /*
    * Loads one or all messages.
    * A message musst be a online_date of today or older.
    * The offline_date can be null or lies in the future.
    */
    protected function loadFromDB( $messageNumber, $parent = null )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(
                array('m.id','m.number','q.number','m.title','m.content','m.image','m.online_date','m.offline_date', 'm.version', 'm.last_update'),
                array(null,null,'quizNumber',null,null,null,null,null,null,null)))
            ->from('#__dkq_messages AS m' )
            ->leftJoin('#__quizzes AS q ON q.id = m.quiz_id' )
            ->where( 'DATEDIFF( m.online_date, NOW() ) <= 0 AND (DATEDIFF( m.offline_date, NOW() ) IS NULL OR DATEDIFF( m.offline_date, NOW() ) > 0)')
            ->order( 'm.number ASC');

        if( $messageNumber != -1 )
        {
            $query->where( 'm.number =' . $messageNumber );
        }

        $db->setQuery($query);
        return $db->LoadObjectList();
    }

    protected function modelToArray( $message, $singleModel )
    {
        if( is_null( $message ) ) {
            return null;
        }

        // Foreign key value 0 throws error but null is valid on SQLITE.
        $quizNumber = intval( $message->quizNumber );
        if( $quizNumber == 0 ) {
            $quizNumber = null;
        }

        $json = array(
            "number" => intval( $message->number ),
            "title" => $message->title,
            "content" => $message->content,
            "quizNumber" => $quizNumber,
            "version" => intval($message->version),
            "lastUpdate" => $message->last_update
        );

        if( strlen( $message->image ) > 0 ) {
            $imageUrl = JURI::root() . $message->image;
            $json["image"] = $imageUrl;
        }

        return $json;
    }
}