<?php
// Define APP_PATH is not required, but it can be useful
// if you will decide move you api files to other dir.
// Or if you want to change source dir quickly. e.g. For different versions
define('APP_PATH', dirname(__DIR__).DIRECTORY_SEPARATOR);

include APP_PATH.'hirest.php';

// Default function for handling result request.
// Accept any callabe function.
// In this case just encode all data to json.
hirest()->addResponseHandler('json_encode');

// Routing example
hirest()

        // yourdomain.com/hello will display 'hello'
        ->route('hello', function(){ return 'hello'; } )

        // call to $example->helloName('John') for yourdomain.com/hello/John
        ->route('hello/(?<name>[a-z\s]+)', ['example','helloName'] )

        // call to static example::md5($string, $times)
        ->route('md5/(?<string>.*)/(?<times>[0-9]+)', 'example::md5')

        // call to time() php function only if HTTP method is in GET or POST
        ->route('time','time', ['GET', 'POST']);


hirest()->run();