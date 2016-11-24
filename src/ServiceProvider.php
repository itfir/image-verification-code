<?php
namespace Fir\ImageVerificationCode;

use Illuminate\Routing\Router;

class ServiceProvider extends \Illuminate\Support\ServiceProvider{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(){

        $routeConfig = [
            'namespace' => 'Fir\ImageVerificationCode\Controllers',
            'prefix' => '/ImageVerificationCode',
            'middleware' => ['web'],
        ];
        $this->getRouter()->group($routeConfig, function($router) {
            $router->get('/Generate.html', ['as' => 'ImageVerificationCode.Generate', 'uses' => 'ImageVerificationCodeController@Generate',]);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(){
        return ['Fir\ImageVerificationCode'];
    }

    /**
     * Get the active router.
     * @return Router
     */
    protected function getRouter(){
        return $this->app['router'];
    }

}
