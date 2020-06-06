<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\HttpFoundation\Response;


class AbstractController extends SymfonyController
{
    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $locales = [
            'en' => ['icon' => 'gb', 'name' => 'English'],
            'jp' => ['icon' => 'jp', 'name' => '日本語'],
            'ru' => ['icon' => 'ru', 'name' => 'Русский'],
        ];
        $parameters['locales'] = $locales;
        $parameters['current_locale'] = $request->getLocale();

        return parent::render($view, $parameters, $response);
    }
}
