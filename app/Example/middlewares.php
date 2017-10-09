<?php
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