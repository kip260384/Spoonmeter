<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;

class LocaleController extends SymfonyController
{
    public function detectLocale(Request $request, ParameterBagInterface $params)
    {
        $browserLocale = null;
        $langHeader = $request->headers->get('accept-language');
        if ($langHeader && 1 < strlen($langHeader)) {
            $supported = $params->get('app.supported_locales');
            $locale = substr($langHeader, 0, 2);
            if (!in_array($locale, $supported)) {
                $locale = $params->get('app.default_locale');
            }
        } else {
            $locale = $params->get('app.default_locale');
        }

        $request->getSession()->set('_locale', $locale);
        $request->setLocale($locale);

        return $this->redirectToRoute('meter_home', ['_locale' => $locale]);
    }
}
