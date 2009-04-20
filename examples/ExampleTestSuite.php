<?php
  /* Run this example as: `phpunit ExampleTestSuite` */
  
  require_once( '../suite/TheCodeTrainEasyFrontendTestSuite.php' );
  
  class ExampleTestSuite extends TheCodeTrainEasyFrontendTestSuite {
    public static function suite() {
      return parent::suite( array(
        'html'  =>  array(
          'validator' => 'http://validator.w3.org/check',
          'tests'     => array(
            'http://yahoo.com/'
          )
        )
      ) );
    }
  }
  
?>