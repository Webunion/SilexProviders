<?php namespace Webunion\Providers\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;
use \Webunion\View\View;

class ViewServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
		$app['view'] = $app->share(function ($app) {		
            return new View( $app['view.path'] );
        });
    }
	
    public function boot(Application $app)
    {
    }
}