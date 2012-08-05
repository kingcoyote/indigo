<?php

// initialize folders
define('INDIGO_DIR', dirname(__FILE__) . '/');
define('VENDOR_DIR', INDIGO_DIR. 'vendor' . '/');

try {
    // include composer's autoload
    if (!file_exists(VENDOR_DIR . 'autoload.php')) {
        throw new Exception('Composer autoload not found.');
    }
    
    require_once(VENDOR_DIR . 'autoload.php');

    // find out the site directory to work with
    $site = Indigo\Site::fetch();    

    // initialize the core of the system based on that site's config
    $config = Indigo\Config::factory($site);

    // initialize MySQL in index. This will probably eventually go into a module
    Indigo\Db::register_engine('mysql', '\\Indigo\\Db\\Mysql');

    Indigo\Db::init($config);
    Indigo\File::init($site);
    Indigo\Event::init();

    // earliest possible event
    Indigo\Event::trigger('indigo start');

    // parse request
    $request = Indigo\Router::parseRequest();

    // allow modules to modify request
    $request = Indigo\Event::trigger('indigo request', $request);

    $response = array(
        'http_code' => '200 OK',
        'headers'   => array(),
    );

    try {
        // tell router to dispatch to the controller
        $page = Indigo\Router::dispatch($request);
    } catch (Indigo\Exception\Auth $e) {
        $response['http_code'] = '403 Forbidden';    
    } catch (Indigo\Exception\Router $e) {
        $response['http_code'] = '404 Not Found';
    }

    $response['content'] = $page;

    // send out headers
    $response = Indigo\Event::trigger('indigo response', $response);
    header('HTTP/1.0 ' . $response['http_code']);
    foreach ($response['headers'] as $name => $value) {
        header(sprintf(
            '%s: %s',
            $name,
            $value
        ));
    }
    // send out content
    echo $response['content'];

    // latest possible event
    Indigo\Event::trigger('indigo end');
    
} catch (Exception $e) {
    // any exception that makes it to here is potentially so critical
    // that no aspects of Indigo can be relied upon to work properly
    header('HTTP/1.0 500 Internal Server Error');
    header('Content-type: text/plain; charset=utf-8');

    echo 'A non recoverable fatal error has been encountered.' . PHP_EOL;
    echo str_pad(null, 80, '=') . PHP_EOL;
    echo get_class($e) . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    echo str_replace(dirname(__FILE__), null, $e->getFile()) . ':' . $e->getLine() . PHP_EOL;
    echo str_pad(null, 80, '=') . PHP_EOL;
    foreach ($e->getTrace() as $trace) {
        echo str_replace(dirname(__FILE__), null, $trace['file']) . ':' . $trace['line'] . PHP_EOL;
    }
    die;
}

