<?php

/**
 * TestCase class to inherit from to allow Unit Testing based checking of
 * HTML validity.  Right now, this is only set up to test modules, not full 
 * pages.  I'll fix this to do anything and everything soon.
 *
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
abstract class TheCodeTrainBaseValidatorTestCase extends PHPUnit_Framework_TestCase {
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
   
    /* Hmmm, I seem to be missing some code here... */
    protected function getValidationError($htmlChunk) {
		$html = <<< HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title>title</title></head>
<body>
$htmlChunk
</body></html>
HTML;

        $validator = new TheCodeTrainHtmlValidator('http://blah.com');
        $isValid = $validator->isValid($html);
        
        if ( $validator::NO_VALIDATOR_RESPONSE == $isValid ) {
            $this->markTestSkipped('No validator');
            return false;
        } else if ( $isValid ) {
            return false;
        }
        
        $result = $validator->getErrors();
        
        return $result[0];
    }
    
}
?>