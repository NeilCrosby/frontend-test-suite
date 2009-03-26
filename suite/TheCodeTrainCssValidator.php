<?php

/**
 * Validates CSS against the CSS 2.1 standard.
 *
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainCssValidator extends TheCodeTrainBaseValidator {
    
    const ALLOW = 1;
    const DISALLOW = 0;
    public $errorPointer = array('envBody', 'mcssvalidationresponse', 'mresult', 'merrors');

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
        } else if ( self::HTTP_IDENTIFIER == mb_substr( $css, 0, mb_strlen(self::HTTP_IDENTIFIER)) ) {
            // load from http instead of just using the given string
            $css = file_get_contents($css);
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
}