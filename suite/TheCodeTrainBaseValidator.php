<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
abstract class TheCodeTrainBaseValidator {
    
    const FILE_NOT_FOUND = -2;
    const NO_VALIDATOR_RESPONSE = -1;
    const NO_ERROR = false;

    const FILE_IDENTIFIER = 'file://';
    const HTTP_IDENTIFIER = 'http://';
    
    protected $errorPointer = array('envBody', 'mmarkupvalidationresponse', 'mresult', 'merrors');
    
    public function __construct($validationUrl=null) {
        if ( !$validationUrl ) {
            throw new Exception('No validation URL given.');
            return false;
        }
        // TODO validate the validation URL
        $this->validationUrl = $validationUrl;
    }
    
    protected function getCurlResponse( $url, $aOptions = array() ) {

        $session = curl_init();
        curl_setopt( $session, CURLOPT_URL, $url );
        
        $showHeader = ( isset($aOptions['headers']) && $aOptions['headers'] ) ? true : false;
        
        curl_setopt( $session, CURLOPT_HEADER, $showHeader );
        curl_setopt( $session, CURLOPT_RETURNTRANSFER, 1 );
        
        if ( isset($aOptions['post']) ) {
            curl_setopt( $session, CURLOPT_POST, 1 );
            curl_setopt( $session, CURLOPT_POSTFIELDS, $aOptions['post'] );
        }

        $result = curl_exec( $session );

        curl_close( $session );
        
        return $result;
    }
    
    protected function getSanitisedSimpleXml($xmlString) {
        // turns pesky colon namespaced element anems into simple ones, just
        // by getting rid of the colons
        $result = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xmlString);
        
        return simplexml_load_string($result);
    }
    
    public function getErrors() {
        if ( !isset($this->lastResult) || !$this->lastResult ) {
            return self::NO_VALIDATOR_RESPONSE;
        }
        
        if (strpos( $this->lastResult, "<m:validity>true</m:validity>" )) {
            return self::NO_ERROR;
        }
        
        $result = $this->getSanitisedSimpleXml($this->lastResult);
        
        foreach ( $this->errorPointer as $item ) {
            foreach ( $result->children() as $child ) {
                if ( $child->getName() == $item ) {
                    $result = $child;
                    break;
                }
            } 
        }
        
        if ( 1 == $result->merrorcount ) {
            $error = $result->merrorlist->merror;
            $orig = $error->mcontext;
            if ( $error->msource ) {
                $orig = $error->msource;
                $orig = str_replace('<strong title="Position where error was detected.">', '', $orig);
                $orig = str_replace('</strong>', '', $orig);
                $orig = html_entity_decode($orig);
            }
            return array(array(
                'line' => (string)$error->mline,
                'errortype' => (string)$error->merrortype,
                'error' => trim((string)$error->mmessage),
                'original_line' => (string)$orig,
            ));
        }

        $errors = array();
        foreach ($result->merrorlist->merror as $error) {
            $orig = $error->mcontext;
            if ( $error->msource ) {
                $orig = $error->msource;
                $orig = str_replace('<strong title="Position where error was detected.">', '', $orig);
                $orig = str_replace('</strong>', '', $orig);
                $orig = html_entity_decode($orig);
            }
            array_push($errors, array(
                'line' => (string)$error->mline,
                'errortype' => (string)$error->merrortype,
                'error' => trim((string)$error->mmessage),
                'original_line' => (string)$orig,
            ));
        }
        
        return $errors;
    }
    
    abstract public function isValid($html, $aOptions = array());
    
}