<?php

use App\Controller\ApiController;
use App\Controller\MeterController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('meter_home', '/')
        ->controller([MeterController::class, 'index'])
    ;

    $routes->add('meter', '/meter')
        // the controller value has the format [controller_class, method_name]
        ->controller([MeterController::class, 'index'])

        // if the action is implemented as the __invoke() method of the
        // controller class, you can skip the 'method_name' part:
        // ->controller(BlogController::class)
    ;

    $routes->add('meter', '/meter/{substance}/{amount}/{from}/{to}')
        ->controller([MeterController::class, 'convert'])
    ;

    $routes->add('ajax', '/api/v1/convert')
        ->controller([ApiController::class, 'convert'])
    ;
};