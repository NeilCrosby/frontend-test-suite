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

## Setting up Local Validators

The following instructions all assume you're running these validators on a Mac.  If you're using something else, then may the gods be with you.  Seriously though, you should be able to get all these set up on any of the major systems without many problems.

### HTML Validator

Full instructions for setting up the W3C HTML Validator can be found at:

    http://validator.w3.org/docs/install.html
    
### CSS Validator

Full instructions for setting up the W3C CSS Validator on the Mac can be found at:

    http://thecodetrain.co.uk/2009/03/getting-the-css-validator-running-as-a-website/
    
For all other systems, take a look at:

    http://jigsaw.w3.org/css-validator/DOWNLOAD.html
    
### JSLint

Full instructions for setting up JSLint on the Mac can be found at :

    http://www.phpied.com/jslint-on-mac-textmate/
    
For all other systems, look at:

    http://www.jslint.com/lint.html
