<?php

defined('_JEXEC') or die;

abstract class JsonHelper
{
    protected $apiVersion;

    // constructor
    public function __construct( $apiVersion )
    {
        $this->apiVersion = $apiVersion;
    }

    public function buildJsonData( $number )
    {
        $singleModel = $number > 0;
        $modelsList = $this->loadFromDB( $number );

        if( count( $modelsList ) == 0 )
        {
            if( $singleModel )
            {
                if( $this->apiVersion >= 4 )
                {
                    throw new Exception("no model found", 404);
                }
                return json_decode("{}");
            }
            else
            {
                return json_decode("[]");
            }
        }

        $modelsJsonData = $this->modelsToArray( $modelsList );

        if( count( $modelsJsonData ) == 1 && $singleModel )
        {
            return $modelsJsonData[0];
        }
        else
        {
            return $modelsJsonData;
        }
    }

    abstract protected function loadFromDB( $number );

    private function modelsToArray( $models )
    {
        $result = array();
        foreach($models as &$model)
        {
            $converted = $this->modelToArray( $model );
            if( $converted != null )
            {
                $result[] = $converted;
            }
        }
        return $result;
    }

    abstract protected function modelToArray( $model );
}