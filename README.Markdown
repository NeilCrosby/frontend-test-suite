# Frontend Test Suite

Automated testing of Frontend Web Systems is a task that's rarely implemented, and when it is it's generally a just case of "Lets write some Selenium tests" and that will be the end of things.

I believe that starting to test Frontend Web Systems using the JavaScript layer within the browser is starting too far down the chain.  As developers we will all sporadically test for HTML and CSS validity, we will look for errors cropping up in our JavaScript, and we'll try and make sure that our pages contain no XSS holes.

The problem with this is that this testing only tends to happen when we remember about it.  Easy bugs to fix can go unnoticed for months, and others can appear which take hours to fix purely because we do not notice that a span tag has been left unclosed.

By automatically and continuously running a suite of frontend tests a greater level of confidence in the quality of code can be attained.  By notifying developers of issues with their commited code fixes can be pushed within minutes, rather than hours.  By running the tests as pre-commit hooks, bad code can be stopped from even being allowed into the system.

## Phase 1

   * HTML Validation
       * Page level (Complete)
       * Module level (Complete)
       * Ability to validate using a different doctype to the one given on the page to allow for well documented exceptions.
   * CSS Validation
       * Ability to allow through certain known hacks.
       * Ability to allow the YUI's CSS to pass, even after allowing for those known hacks.
   * Javascript linting
       * Ability to pass through a known configuration for linting against.
   * Documentation to make it easy for others to use the framework.
   
## Phase 2

   * "Whitelisting" sections of known bad code - eg external adverts pulled into a page.
   * HTML well-formedness testing.  Whitelisted sections of code should still be well formed.
   * Basic accessibility rules checking.

## Tools required

Given the number of tests that will generally be being run per hour, it would be rude to rely on free external services that others provide.  Instead, you should install your own local versions of these services so as not to put unnecessary strain on the public versions.

   * HTML Validator
   * CSS Validator
   * JSLint
