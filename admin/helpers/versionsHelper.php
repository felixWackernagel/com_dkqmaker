<?php

defined('_JEXEC') or die;

class VersionsHelper
{
    protected $apiVersion;

    // constructor
    public function __construct( $apiVersion )
    {
        $this->apiVersion = $apiVersion;
    }

    // chainable instance call
    public static function instance( $apiVersion )
    {
        return new self( $apiVersion );
    }

    public function buildJsonData( $version )
    {
        $singleVersion = $version > 0;

        if( $singleVersion )
        {
            $app = JFactory::getApplication();
            $params = $app->getParams('com_dkqmaker');
            $appVersion = $params->get('play_store_app_version');

            return array(
                "validVersion" => ($appVersion == $version)
            );
        }
        else
        {
            if( $this->apiVersion >= 4 )
            {
                throw new Exception("no model found", 404);
            }
            return json_decode("[]");
        }
    }
}