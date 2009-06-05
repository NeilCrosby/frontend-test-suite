# Development Notes

This document contains details for developers who are adding to or modifying the [Frontend Test Suite][fts].

[fts]: http://github.com/NeilCrosby/frontend-test-suite/tree


## Running the tests

As you'd expect, the Front-End Test Suite comes with a complete set of unit tests that exercise the Front-End Test Suite code. To run these tests, =cd= to the directory where your copy of the Front-End Test Suite lives and run the following command.

    phpunit tests

PHPUnit will then run through the entire Front-End Test Suite test suite and report any issues. If you see a bunch of skipped tests (marked with an `S`) then it's probably because you need to specify the validators that should be used to run the tests.

### Specifying alternative validators / linters

The test classes for the Front-End Test Suite currently default to using validators as they are set up in our development environment. There is an [Open Issue][gh-2] to make them use the public W3C validators by default, and in the meantime you can override the default values using environment variables.

[gh-2]: http://github.com/NeilCrosby/frontend-test-suite/issues/#issue/2

The `FETS_TEST_HTML_VALIDATOR_URL` and `FETS_TEST_CSS_VALIDATOR_URL` environment variables should point to URLs for the W3C Markup Validator and W3C CSS Validator web service endpoints respectively. So, for example, if you wanted to run the test suite against the public W3C validators, you'd use the following command:

    FETS_TEST_HTML_VALIDATOR_URL=http://validator.w3.org/validator \
    FETS_TEST_CSS_VALIDATOR_URL=http://jigsaw.w3.org/check \
    phpunit tests

The `FETS_TEST_JS_LINT_COMMAND` specifies the command that should be used to invoke JSLint, and defaults to:

    java org.mozilla.javascript.tools.shell.Main ~/Library/JSLint/jslint.js

This assumes that [Rhino][rhino] is installed somewhere in your Java `CLASSPATH` and that the [Rhino-compatible version of jslint][jslint-rhino] is installed at `~/Library/JSLint/jslint.js`. You can override this default command in the same way as the HTML and CSS validator URLs, although you'll need to use quotation marks around the command as it contains spaces:

[rhino]: http://www.mozilla.org/rhino/
[jslint-rhino]: http://www.jslint.com/rhino/index.html

    FETS_TEST_HTML_VALIDATOR_URL=http://validator.w3.org/validator \
    FETS_TEST_CSS_VALIDATOR_URL=http://jigsaw.w3.org/check \
    FETS_TEST_JS_LINT_COMMAND="java org.mozilla.javascript.tools.shell.Main /opt/jslint/jslint.js" \
    phpunit tests

If you don't want to have to specify the custom values every time, you can set these up as permanent environment variables. For Mac OS X simply add the following lines to your `~/.bash_profile` file (changing the values as appropriate for your setup) and restart Terminal:

    export FETS_TEST_HTML_VALIDATOR_URL=http://validator.w3.org/validator
    export FETS_TEST_CSS_VALIDATOR_URL=http://jigsaw.w3.org/check
    export FETS_TEST_JS_LINT_COMMAND="java org.mozilla.javascript.tools.shell.Main /opt/jslint/jslint.js"
    
### Specifying assets directory location

Some of the tests require that the files from the `tests/assets` directory (as well as the `dtd`) directory be available on a web server via HTTP. Again, the default uses a location that is very specific to our primary development environment, but you can override this using the `FETS_TEST_ASSETS_BASE_URL` environment variable.

    FETS_TEST_HTML_VALIDATOR_URL=http://validator.w3.org/validator \
    FETS_TEST_CSS_VALIDATOR_URL=http://jigsaw.w3.org/check \
    FETS_TEST_JS_LINT_COMMAND="java org.mozilla.javascript.tools.shell.Main /opt/jslint/jslint.js" \
    FETS_TEST_ASSETS_BASE_URL=http://your.development.server/path/to/assets \
    phpunit tests

You'll need to upload the contents of the `tests/assets` directory, as well as the `dtd` directory itself, to the URL you've specified. The directory structure should look like this:

- `assets`
   - `css`
   - `dtd`
   - `html`
   - `js`