<?php
  /* Run this example as: `phpunit ExampleTestSuite` */
  
  require_once( '../suite/TheCodeTrainEasyFrontendTestSuite.php' );
  
  class ExampleTestSuite extends TheCodeTrainEasyFrontendTestSuite {
    public static function suite() {
      return parent::suite( array(
        'html'  =>  array(
          'validator' => 'http://validator.w3.org/check',
          // 'doctype_override' => '<!DOCTYPE HTML SYSTEM "http://site/doctype.dtd">',
          // 'document_section' =>  TheCodeTrainHtmlValidator::HTML_CHUNK, 
          // 'document_section_position' =>  TheCodeTrainHtmlValidator::POSITION_HEAD
          'tests'     => array(
            'http://yahoo.com/'
          )
        )
      ) );
    }
  }
  
?>