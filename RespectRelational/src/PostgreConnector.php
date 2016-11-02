<?php
/**
 * Database
 *
 * @copyright Copyright (c)  Gjero Krsteski (http://krsteski.de)
 * @license   http://opensource.org/licenses/MIT MIT License
 */
namespace Webunion\Providers\Silex\RespectRelational;
/**
 * Connection management to PostgreSQL
 *
 * @package Database
 * @author  Gjero Krsteski <gjero@krsteski.de>
 */
class PostgreConnector extends Connector
{
  protected $options = [
      \PDO::ATTR_CASE              => \PDO::CASE_LOWER,
      \PDO::ATTR_ERRMODE           => \PDO::ERRMODE_EXCEPTION,
      \PDO::ATTR_ORACLE_NULLS      => \PDO::NULL_NATURAL,
      \PDO::ATTR_STRINGIFY_FETCHES => false,
    ];
  /**
   * @param array $config
   *
   * @return \PDO
   */
  public function connect(array $config)
  {
    $dsn = "pgsql:host={$config['host']};dbname={$config['database']}";
    if (isset($config['port'])) {
      $dsn .= ";port={$config['port']}";
    }
    $connection = new \PDO($dsn, $config['username'], $config['password'], $this->options($config));
    // set to UTF-8 which should be fine for most scenarios.
    if (isset($config['charset'])) {
      $connection->prepare("SET NAMES '{$config['charset']}'")->execute();
    }
    // If a schema has been specified
    if (isset($config['schema'])) {
      $connection->prepare("SET search_path TO '{$config['schema']}'")->execute();
    }
    return $connection;
  }
}