# hirest
Lightning fast RESTful API php-framework

Designed for easy scalability.

## Usage
All usage examples including in repo. It is pretty easy.

```
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
```

