# Setting up the Frontend Test Suite

## Things You'll Need

### Absolutely Required

   * PHP (with PEAR)
   * PHPUnit
   * Frontend Test Suite

### Optional, but Recommended

You will want to install the following because if you set up the Test Suite to keep hitting the public versions of these services you'll end up getting banned.  All three of these services are free and open source, and easily installable on your systems.  You really should install local copies.

   * Local W3C HTML Validator installation
   * Local W3C CSS Validator installation
   * Local JSLint installation

## Setting up the Test Suite

    1.  Make sure you've got PHP installed, and it's available from the commandline.  If you haven't got it installed yet, go to <http://www.php.net/downloads.php> and install it.
    
    2.  PEAR should have been installed when you installed PHP, and should be available by running `pear` on the commandline. If not, you will need to get it from <http://pear.php.net/PEAR>
    
    3.  To install PHPUnit, do the following on the commandline:
    
            pear channel-discover pear.phpunit.de
            pear install phpunit/PHPUnit
            
    4.  To install the Frontend Test Suite, download it from <http://github.com/NeilCrosby/frontend-test-suite/tree/master> or pull it down to your server using git:
    
            git clone git://github.com/NeilCrosby/frontend-test-suite.git 
            
    5.  To test the test suite works, do the following:
    
            cd frontend-test-suite/examples
            phpunit ExampleTestSuite
            
    6.  The suite should test yahoo.com and throw a load of errors relating to the page.  Hooray - you're in business!