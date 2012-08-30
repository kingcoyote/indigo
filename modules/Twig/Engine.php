<?php

namespace Twig;

use Indigo\Template\EngineInterface;
use Indigo\Config;
use Indigo\File;

class Engine implements EngineInterface
{
    public function __construct(Config $config)
    {
        $this->loader = new \Twig_Loader_Filesystem(
             File::factory()->getDirs('templates')
        );
        $this->environment = new \Twig_Environment(
            $this->loader,
            [
                'compilation_cache' => INDIGO_DIR . 'cache/'
            ]
        );
    }

    public function factory($name)
    {
        $view = new View($name);
        $view->setEnvironment($this->environment);
        return $view;
    }

    public function setGlobal($name, $value)
    {

    }
}

