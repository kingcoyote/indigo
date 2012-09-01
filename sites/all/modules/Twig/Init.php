<?php

namespace Twig;

use Indigo\Template;

class Init
{
    public static function init()
    {
        Template::registerEngine('twig', 'Twig\\Engine');
    }
}

