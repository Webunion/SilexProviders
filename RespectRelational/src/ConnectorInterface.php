<?php namespace Webunion\Providers\Silex\RespectRelational;

interface ConnectorInterface
{
    /**
     *
     * @param array $params
     *
     * @return \PDO
     */
    public function connect(array $config);
}