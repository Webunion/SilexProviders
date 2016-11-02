<?php namespace Webunion\Providers\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;
use \Webunion\Config\Config;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
		$app['config'] = $app->share(function ($app) {		
            return new Config( $app['config.file'] );
        });
    }
	
    public function boot(Application $app)
    {
    }
}