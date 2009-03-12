<?php

/**
 * Validates HTML.  Full HTML documents are validated against whatever
 * doctype they are sent with, whereas HTML chunks are validated against
 * HTML 4.01 Strict.
 *
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainHtmlValidator {
    
    const FILE_NOT_FOUND = -2;
    const NO_VALIDATOR_RESPONSE = -1;
    const NO_ERROR = false;

    const HTML_DOCUMENT = 5;
    const HTML_CHUNK    = 10;
    
    const POSITION_BODY = 0;
    const POSITION_HEAD = 1;
    
    const FILE_IDENTIFIER = 'file://';
    
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
    
    /**
     * Validates an HTML chunk or full document.
     *
     * @param html Some HTML to validate.
     * @param type Either HTML_DOCUMENT or HTML_CHUNK
     *
     * @return boolean, or NO_VALIDATOR_RESPONSE if the chosen validator was
     *         not able to be reached.
     **/
    public function isValid($html, $aOptions = array()) {
        $type     = isset($aOptions['document_section']) ? $aOptions['document_section'] : null;
        $position = isset($aOptions['document_section_position']) ? $aOptions['document_section_position'] : TheCodeTrainHtmlValidator::POSITION_BODY;

        if ( self::FILE_IDENTIFIER == mb_substr( $html, 0, mb_strlen(self::FILE_IDENTIFIER)) ) {
            // load from file instead of just using the given string
            $file = mb_substr( $html, mb_strlen(self::FILE_IDENTIFIER));
            $html = file_get_contents($file);
        }
        
        if ( TheCodeTrainHtmlValidator::HTML_CHUNK == $type ) {
            if ( TheCodeTrainHtmlValidator::POSITION_HEAD == $position ) {
                $html = <<< HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
$html
</head>
<body>
<p>Empty body</p>
</body></html>
HTML;
            } else {
                $html = <<< HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title>title</title></head>
<body>
$html
</body></html>
HTML;
            }
        }
        
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