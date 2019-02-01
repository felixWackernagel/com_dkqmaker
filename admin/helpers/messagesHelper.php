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
    protected function loadFromDB( $messageNumber )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'number', 'title', 'content', 'image', 'online_date', 'offline_date', 'version', 'last_update')))
            ->from($db->quoteName('#__dkq_messages'))
            ->where( 'DATEDIFF( online_date, NOW() ) <= 0 AND (DATEDIFF( offline_date, NOW() ) IS NULL OR DATEDIFF( offline_date, NOW() ) > 0)')
            ->order( 'number ASC');

        if( $messageNumber > 0 )
        {
            $query->where( 'number =' . $messageNumber );
        }

        $db->setQuery($query);
        return $db->LoadObjectList();
    }

    protected function modelToArray( $message )
    {
        if( $message == null )
        {
            return null;
        }

        $json = array(
            "number" => intval( $message->number ),
            "title" => $message->title,
            "content" => $message->content,
            "version" => intval($message->version),
            "lastUpdate" => $message->last_update
        );

        if( strlen( $message->image ) > 0 )
        {
            $imageUrl = JURI::root() . $message->image;
            $json["image"] = $imageUrl;
        }

        return $json;
    }
}