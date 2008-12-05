<?php

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