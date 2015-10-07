# hirest
Lightning fast RESTful API php-framework

Designed for easy scalability and highloads.

### Features
* Lightweight
* One file framework
* In route validation
* Routes must call: functions, closures, static and non-static methods
* Work in console too
* Change output format by one string

### TODO

- [x] Filtering middleware
- [x] Cache __(use responseHandlers and middleware for you own cache methods)__

### Usage
All usage examples included in repo. It is pretty easy.

```php
include APP_PATH.'hirest.php';

hirest()

        // yourdomain.com/hello will display 'hello'
        ->route('hello', function(){ return 'hello'; } )

        // call to $api->helloName('John') for yourdomain.com/hello/John
        ->route('hello/(?<name>[a-z\s]+)', ['api','helloName'] )

        // call to static api::md5($string, $times)
        ->route('md5/(?<string>.*)/(?<times>[0-9]+)', 'api::md5')

        // call to time() php function only if HTTP method is in GET or POST
        ->route('time','time', ['GET', 'POST']);


hirest()->run();
```
