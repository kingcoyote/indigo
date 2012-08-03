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

    // initialize the core of the system
    Indigo\Config::Init();
    Indigo\Db::Init();
    Indigo\Event::Init();
    Indigo\File::init();

    // earliest possible event
    Indigo\Event::Trigger('indigo start');

    // parse request
    $request = Indigo\Router::ParseRequest();

    // allow modules to modify request
    $request = Indigo\Event::Trigger('indigo request', $request);

    $headers = array(
        'http_code' => '200 OK',
        'headers'   => array(),
    );

    try {
        // tell router to dispatch to the controller
        $page = Indigo\Router::Dispatch($request);
    } catch (Indigo\Exception\Auth $e) {
        $headers['http_code'] = '403 Forbidden';    
    } catch (Indigo\Exception\Router $e) {
        $headers['http_code'] = '404 Not Found';
    }

    // initialize theme
    $theme = Indigo\View::factory(
        Indigo\Config::Get('theme')
    );
    
    // inject controller into the theme
    $theme->page = $page;

    // send out headers
    $headers = Indigo\Event::Trigger('indigo headers', $headers);
    header('HTTP/1.0 ' . $headers['http_code']);
    foreach ($headers['headers'] as $name => $value) {
        header(sprintf(
            '%s: %s',
            $name,
            $value
        ));
    }

    // send out content
    $content = $theme->render();
    echo Indigo\Event::Trigger('indigo content', $content);

    Indigo\Event::Trigger('indigo end');
    
} catch (Exception $e) {
    // any exception that makes it to here is potentially so critical
    // that no aspects of Indigo can be relied upon to work properly
    header('HTTP/1.0 500 Internal Server Error');
    header('Content-type: text/plain; charset=utf-8');

    echo 'A non recoverable fatal error has been encountered:' . PHP_EOL;
    echo '    ' . $e->getMessage() . PHP_EOL;
    echo '    ' . $e->getFile() . ':' . $e->getLine();
    
    die;
}

