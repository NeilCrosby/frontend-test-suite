<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainHtmlValidatorProviders {
    
    public static function validHtmlChunkProvider() {
        return array(
            array('<p>Some text</p>'),
        );
    }

    public static function invalidHtmlChunkProvider() {
        return array(
            array('<p>Some text</pee>'),
        );
    }

    public static function invalidValidatorUrlProvider() {
        return array(
            array('http://thisdefinitelydoesntexist.thecodetrain.co.uk/'),
        );
    }
    
}

?>