<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainCssValidatorProviders {
    
    public static function validCssProvider() {
        return array(
            array('p {display: block;}'),
            array('p{display: block;}'),
            array('p { display: block}'),
            array('p { display: block }'),
        );
    }

    public static function invalidCssProvider() {
        return array(
            array('<p>Some text</pee>'),
            array('itvehrb jgskhg; fstoiaeoyufsfgoi'),
            array("p { bllllllllah;"),
        );
    }

    public static function validValidatorUrlProvider() {
        return array(
            //array('http://jigsaw.w3.org/css-validator/validator'),
            array('http://127.0.0.1:8080/css-validator/validator'),
        );
    }
    
    public static function invalidValidatorUrlProvider() {
        return array(
            array('http://thisdefinitelydoesntexist.thecodetrain.co.uk/'),
        );
    }
    
}

?>