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

    public function buildJsonData( $number, $parent = null )
    {
        $singleModel = ( is_null( $parent ) && $this->apiVersion >= 4 ) ? $number != -1 : $parent != -1;

        if( !is_null( $parent ) && $this->apiVersion >= 4 ) {
            if( !$this->existDependentModel( $number ) ) {
                throw new Exception("no parent model found", 404);
            }
        }

        $modelsList = $this->loadFromDB( $number, $parent );

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

        $jsonDataList = $this->modelsToArray( $modelsList, $singleModel );

        if( count( $jsonDataList ) == 0 && $singleModel )
        {
            // unpublished single model
            if( $this->apiVersion >= 4 )
            {
                throw new Exception("no model found", 404);
            }
            return json_decode("{}");
        }
        else if( count( $jsonDataList ) == 1 && $singleModel )
        {
            return $jsonDataList[0];
        }
        else
        {
            return $jsonDataList;
        }
    }

    protected function existDependentModel( $dependency )
    {
        return true;
    }

    abstract protected function loadFromDB( $number, $parent = null );

    private function modelsToArray( $models, $singleModel )
    {
        $result = array();
        foreach( $models as &$model )
        {
            $converted = $this->modelToArray( $model, $singleModel );
            if( !is_null( $converted ) )
            {
                $result[] = $converted;
            }
        }
        return $result;
    }

    abstract protected function modelToArray( $model, $singleModel );
}