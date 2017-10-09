<?php
// Routing example
use Hirest\Core\Route;

	// yourdomain.com/hello?api-key=1 will display 'hello'
	hirest()->route('/hello', function(){ return 'hello'; } );

	// call to $example->helloName('John') for yourdomain.com/hello/John
	hirest()->route('/hello/(?<name>[a-z\s]+)', ['App\Example\Controller','helloName'] );

	// call to static example::md5($string, $times)
	hirest()->route('/md5/(?<string>.*)/(?<times>[0-9]+)', 'App\Example\Controller::md5');

	// call to time() php function only if HTTP method is in GET or POST
	hirest()->get('/time')
	->action('time');

	Route::group(['prefix' => 'admin/'], function(){
		Route::group(['prefix' => 'user/'], function(){
			Route::get('(?<name>.*)', function($name){
				return $name;
			} );
		});

	});