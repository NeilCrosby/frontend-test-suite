<?php

/**
 * Validates HTML.  A work in progress hampered by me not having set up a
 * local copy of the w3c's HTML Validator on my MacBook.
 *
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainHtmlValidator {
    
    const NO_VALIDATOR_RESPONSE = -1;
    const NO_ERROR = false;
    
    public function __construct($validationUrl=null, $exceptions = array()) {
        if ( !$validationUrl ) {
            throw new Exception('No validation URL given.');
            return false;
        }
        // TODO validate the validation URL
        $this->validationUrl = $validationUrl;

        if ( !is_array($exceptions) ) {
            $exceptions = array($exceptions);
        }
        $this->exceptions = $exceptions;
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
    
    public function isValid($html) {
        $html = urlencode($html);

        $result = $this->getCurlResponse(
            $this->validationUrl,
            array('post'=>"fragment=$html&output=soap12")
        );

        $this->lastResult = $result;

        if ( !$result ) {
            return self::NO_VALIDATOR_RESPONSE;
        }
        
        if (strpos( $result, "<m:validity>true</m:validity>" )) {
            return true;
        }
        
        return false;

    }
    
    public function getErrors() {
        if ( !isset($this->lastResult) || !$this->lastResult ) {
            return self::NO_VALIDATOR_RESPONSE;
        }
        
        if (strpos( $this->lastResult, "<m:validity>true</m:validity>" )) {
            return self::NO_ERROR;
        }
        
        $result = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $this->lastResult);
        $result = simplexml_load_string($result);

        if ( 1 == $result->envBody->mmarkupvalidationresponse->merrors->merrorcount ) {
            $error = $result->envBody->mmarkupvalidationresponse->merrors->merrorlist->merror; 
            return array("Line {$error->mline}: {$error->mmessage}");
        }


        $errors = array();
        foreach ($result->envBody->mmarkupvalidationresponse->merrors->merrorlist->merror as $error) {
            array_push($errors, "Line {$error->mline}: {$error->mmessage}");
        }
        
        return $errors;
    }
    
}