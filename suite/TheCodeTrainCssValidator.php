<?php

/**
 * Validates CSS against the CSS 2.1 standard.
 *
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainCssValidator {
    
    const NO_VALIDATOR_RESPONSE = -1;
    const NO_ERROR = false;
    const ALLOW = 1;
    const DISALLOW = 0;

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
    
    protected function commentOutCss($css, $regex) {
        return preg_replace($regex, '/* $1 */', $css);
    }
    
    protected function getCssWithExceptionsApplied($css, $e) {
        if ( isset($e['star_prop']) && self::ALLOW === $e['star_prop'] ) {
            $css = $this->commentOutCss($css, '/([*][-a-zA-Z0-9]+:[^;}]*;?)/');
        }
        
        if ( isset($e['underscore_prop']) && self::ALLOW === $e['underscore_prop'] ) {
            $css = $this->commentOutCss($css, '/([_][-a-zA-Z0-9]+:[^;}]*;?)/');
        }
        
        if ( isset($e['yui_hacks']) && self::ALLOW === $e['yui_hacks'] ) {
            $css = $this->commentOutCss($css, '/(font:100%;)/');
            // 2.6.x
            $css = $this->commentOutCss($css, '/(#bd,.yui-g,.yui-gb,.yui-gc,.yui-gd,.yui-ge,.yui-gf{zoom:1;})/');
            // 2.7.0
            $css = $this->commentOutCss($css, '/(#hd,#bd,#ft,.yui-g,.yui-gb,.yui-gc,.yui-gd,.yui-ge,.yui-gf{zoom:1;})/');            
        }
        
        return $css;
    }
    
    /**
     * Validates a CSS document.
     *
     * @param css Some CSS to validate.
     *
     * @return boolean, or NO_VALIDATOR_RESPONSE if the chosen validator was
     *         not able to be reached.
     **/
    public function isValid($css, $aOptions = array()) {
        if ( self::FILE_IDENTIFIER == mb_substr( $css, 0, mb_strlen(self::FILE_IDENTIFIER)) ) {
            // load from file instead of just using the given string
            $file = mb_substr( $css, mb_strlen(self::FILE_IDENTIFIER));
            $css = file_get_contents($file);
        }
        
        if ( isset($aOptions['exceptions']) && is_array($aOptions['exceptions']) ) {
            $css = $this->getCssWithExceptionsApplied($css, $aOptions['exceptions']);
        }
        
        $result = $this->getCurlResponse(
            $this->validationUrl,
            array('post'=>array("text"=>$css,"output"=>"soap12"))
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
        
        // turns pesky colon namespaced element anems into simple ones, just
        // by getting rid of the colons
        $result = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $this->lastResult);
        
        $result = simplexml_load_string($result);

        if ( 1 == $result->envBody->mcssvalidationresponse->mresult->merrors->merrorcount ) {
            $error = $result->envBody->mcssvalidationresponse->mresult->merrors->merrorlist->merror; 
            return array("Line {$error->mline}: {$error->mmessage}");
        }


        $errors = array();
        foreach ($result->envBody->mcssvalidationresponse->mresult->merrors->merrorlist->merror as $error) {
            array_push($errors, "Line {$error->mline}: {$error->mmessage}");
        }
        
        return $errors;
    }
    
}