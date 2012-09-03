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
    Indigo\File::init($site);

    $loader = new \Composer\Autoload\ClassLoader();
    $loader->add($site, 'sites/');
    $loader->register();
    
    // initialize the core of the system based on that site's config
    $config = Indigo\Config::factory($site);

    foreach ($config->get('modules') as $module) {
        $loader->add($module, Indigo\File::factory()->getDirs('modules'));

        $init = $module . "\\Init";

        if (class_exists($init)) {
            $init::init();
        } 
    }

    Indigo\Db::init($config->get('db')['engine'], $config);
    Indigo\Db::factory('default')->connect();

    Indigo\Template::init($config->get('template'), $config);

    Indigo\Event::init();

    // earliest possible event
    Indigo\Event::trigger('indigo start');

    $response = new Indigo\Response();

    try {
        // parse request
        $request = Indigo\Router::parseRequest($config);

        // allow modules to modify request
        $request = Indigo\Event::trigger('indigo request', $request);

        // tell router to dispatch to the controller
        $response = Indigo\Router::dispatch($request, $response, $config);
    } catch (Indigo\Exception\Auth $e) {
        $response->set('http_code', '403 Forbidden');    
    } catch (Indigo\Exception\Router $e) {
        $response->set('http_code', '404 Not Found');
    }

    // send out headers
    $response = Indigo\Event::trigger('indigo response', $response);

    header('HTTP/1.0 ' . $response->get('http_code'));
    foreach ($response->getHeaders() as $name => $value) {
        header(sprintf(
            '%s: %s',
            $name,
            $value
        ));
    }

    // send out content
    echo $response->get('content');

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

