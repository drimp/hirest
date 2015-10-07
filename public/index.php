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

// Middelware example.
// Middleware is a callable function executed before route handling
// If middleware return false route will not be handled
hirest()->addMiddleware(function(){
    // Require api-key for /hello only
    if(hirest()->request['URI'] == '/hello'){
        if(isset($_GET['api-key']) && $_GET['api-key']){
            return true;
        }
        echo json_encode([
            'status' => 'error',
            'message' => 'API-key is required. Try to open /hello?api-key=1'
            ]);
        return false;
    }
    // Pass the midlleware for others routes
    return true;
});

// Routing example
hirest()

        // yourdomain.com/hello?api-key=1 will display 'hello'
        ->route('/hello', function(){ return 'hello'; } )

        // call to $example->helloName('John') for yourdomain.com/hello/John
        ->route('/hello/(?<name>[a-z\s]+)', ['example','helloName'] )

        // call to static example::md5($string, $times)
        ->route('/md5/(?<string>.*)/(?<times>[0-9]+)', 'example::md5')

        // call to time() php function only if HTTP method is in GET or POST
        ->route('/time','time', ['GET', 'POST']);


hirest()->run();