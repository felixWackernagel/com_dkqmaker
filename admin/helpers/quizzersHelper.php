<?php

defined('_JEXEC') or die;

JLoader::register('JsonHelper', JPATH_ADMINISTRATOR . '/components/com_dkqmaker/helpers/jsonHelper.php');

class QuizzersHelper extends JsonHelper
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

    protected function loadFromDB( $quizzerNumber )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'number', 'name', 'image', 'version', 'last_update')))
            ->from($db->quoteName('#__dkq_quizzers'))
            ->order( 'number ASC');

        if( $quizzerNumber > 0 )
        {
            $query->where( 'number =' . $quizzerNumber );
        }

        $db->setQuery($query);
        return $db->LoadObjectList();
    }

    protected function modelToArray( $quizzer )
    {
        if( $quizzer == null ) {
            return null;
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