<?php
/**
 * Database
 *
 * @copyright Copyright (c)  Gjero Krsteski (http://krsteski.de)
 * @license   http://opensource.org/licenses/MIT MIT License
 */
namespace Webunion\Providers\Silex\RespectRelational;
/**
 * Connection management to MySQL.
 *
 * @package Database
 * @author  Gjero Krsteski <gjero@krsteski.de>
 */
class MysqlConnector extends Connector
{
  /**
   * @param array $config
   *
   * @return \PDO
   */
  public function connect(array $config)
  {
    $dsn = 'mysql:host='.$config['host'].';dbname='.$config['database'].'';
    if (isset($config['port'])) {
      $dsn .= ';port='.$config['port'].'';
    }
    if (isset($config['unix_socket'])) {
      $dsn .= ';unix_socket='.$config['unix_socket'].'';
    }
    if (isset($config['charset'])) {
      $dsn .= ';charset='.$config['charset'].'';
    }
    return new \PDO($dsn, $config['username'], $config['password'], $this->options($config));
  }
}