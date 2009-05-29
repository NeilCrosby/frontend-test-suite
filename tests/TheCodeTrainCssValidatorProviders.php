<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainCssValidatorProviders {
    
    //const DEFAULT_VALIDATOR_URL = "http://jigsaw.w3.org/css-validator/validator";
    const DEFAULT_VALIDATOR_URL = "http://127.0.0.1:8080/css-validator/validator";
    
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
            array("p { display: blah;}"),
            array("p { *display: blah;}"),
            array("#bd,.yui-g,.yui-gb,.yui-gc,.yui-gd,.yui-ge,.yui-gf{zoom:1;}"),
            array("#hd,#bd,#ft,.yui-g,.yui-gb,.yui-gc,.yui-gd,.yui-ge,.yui-gf{zoom:1;}"),
            array("table{font-size:inherit;font:100%;}"),
        );
    }
    
    public static function validCssWithExceptionsProvider() {
        return array(
            array(array('p {display: block; *display: inline;}', array('star_prop'=>TheCodeTrainCssValidator::ALLOW))),
            array(array('p {*display: inline;display: block;}', array('star_prop'=>TheCodeTrainCssValidator::ALLOW))),
            array(array('p { display: block; _display: inline}', array('underscore_prop'=>TheCodeTrainCssValidator::ALLOW))),
            array(array('p {_display: inline;display: block }', array('underscore_prop'=>TheCodeTrainCssValidator::ALLOW))),
            array(array("p{display:block;}#bd,.yui-g,.yui-gb,.yui-gc,.yui-gd,.yui-ge,.yui-gf{zoom:1;}li{display:block;}", array('yui_hacks'=>TheCodeTrainCssValidator::ALLOW))),
            array(array("p{display:block;}#hd,#bd,#ft,.yui-g,.yui-gb,.yui-gc,.yui-gd,.yui-ge,.yui-gf{zoom:1;}li{display:block;}", array('yui_hacks'=>TheCodeTrainCssValidator::ALLOW))),
            array(array("table{font-size:inherit;font:100%;}", array('yui_hacks'=>TheCodeTrainCssValidator::ALLOW))),
            array(array("file://assets/css/yui-reset-fonts-grids.css", array('yui_hacks'=>TheCodeTrainCssValidator::ALLOW, 'star_prop'=>TheCodeTrainCssValidator::ALLOW, 'underscore_prop'=>TheCodeTrainCssValidator::ALLOW))),
        );
    }

    public static function invalidCssWithExceptionsProvider() {
        return array(
            array(array('<p>Some text</pee>', array('star_prop'=>TheCodeTrainCssValidator::ALLOW))),
            array(array('itvehrb jgskhg; fstoiaeoyufsfgoi', array('star_prop'=>TheCodeTrainCssValidator::ALLOW))),
            array(array("p { bllllllllah;", array('star_prop'=>TheCodeTrainCssValidator::ALLOW))),
            array(array("p { display: blah; *display: inline;}", array('star_prop'=>TheCodeTrainCssValidator::ALLOW))),
            array(array("p { *display: blah;}", array('underscore_prop'=>TheCodeTrainCssValidator::ALLOW))),
            array(array("file://assets/css/yui-reset-fonts-grids.css", array('yui_hacks'=>TheCodeTrainCssValidator::ALLOW, 'star_prop'=>TheCodeTrainCssValidator::ALLOW))),
            array(array("file://assets/css/yui-reset-fonts-grids.css", array('yui_hacks'=>TheCodeTrainCssValidator::ALLOW, 'underscore_prop'=>TheCodeTrainCssValidator::ALLOW))),
            array(array("file://assets/css/yui-reset-fonts-grids.css", array('star_prop'=>TheCodeTrainCssValidator::ALLOW, 'underscore_prop'=>TheCodeTrainCssValidator::ALLOW))),
        );
    }
    
    public static function validValidatorUrlProvider() {
        $validator_url = getenv( 'FETS_TEST_CSS_VALIDATOR_URL' );
        if ( empty( $validator_url ) ) {
            $validator_url = self::DEFAULT_VALIDATOR_URL;
        }
        return array(
            array( $validator_url )
        );
    }
    
    public static function invalidValidatorUrlProvider() {
        return array(
            array('http://thisdefinitelydoesntexist.thecodetrain.co.uk/'),
        );
    }
    
}

?>