<?php

namespace Core\Http;

use Core\Application;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class Response extends HttpFoundationResponse 
{

    public function render($template, $variables)
    {
        $app = Application::getInstance();

        $twig = $app->make('twig');

        $this->setContent($twig->render($template, $variables));

        return $this;
    }
}