<?php
/*
 * This file is a service provider for the Silex framework of the Respect/Relational Project.
 *
 * @author Willian C. Carminato <williancarminato@gmail.com>
 *
 */
namespace Webunion\Providers\Silex;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Respect\Relational\Mapper;
/**
 * RespectRelationalServiceProvider
 */
class RespectRelationalServiceProvider implements ServiceProviderInterface
{
 /**
     * @inheritDoc
     */
    public function register(Application $app)
    {
        $app['respect.pdo.all'] = $app->share(function ($app) {
            if (empty($app['respect.pdo.dsn'])) {
                throw new \LengthException('No \PDO instance found', 666);
            }
            return $app['respect.pdo.dsn'];
        });
        $app['respect.mapper'] = $app->share(function ($app) {
            $dbs = $app['respect.pdo.all'];
            $defaultDb = array_shift($dbs);
            return new Mapper( new \PDO( $defaultDb,null,null ));
        });
        $app['respect.mappers'] = $app->share(function ($app) {
            $dbs = $app['respect.pdo.all'];
            $mappers = new \Pimple();
            foreach ($dbs as $name => $pdoDb) {
                $mappers[$name] = $mappers->share(function ($mappers) use ($pdoDb) {
					try{
						$pdo = new \PDO( $pdoDb[0], $pdoDb[1], $pdoDb[2] );
					}
					Catch(\PDOException $e) {  
						return false;
					}
                    return new Mapper( $pdo );
                });
            }
            return $mappers;
        });
    }
    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function boot(Application $app)
    {
    }
}