<?php
/**
 * Database
 *
 * @copyright Copyright (c)  Gjero Krsteski (http://krsteski.de)
 * @license   http://opensource.org/licenses/MIT MIT License
 */
namespace Webunion\Providers\Silex\RespectRelational;
/**
 * Connection management to SQLite.
 *
 * @package Database
 * @author  Gjero Krsteski <gjero@krsteski.de>
 */
class SqliteConnector extends Connector
{
  /**
   * @param array $config
   *
   * @return \PDO
   */
  public function connect(array $config)
  {
    $options = $this->options($config);
    // SQLite provides supported for "in-memory" databases, which exist only for
    // lifetime of the request. These are mainly for tests.
    if ($config['database'] == ':memory:') {
      return new \PDO('sqlite::memory:', null, null, $options);
    }
    return new \PDO('sqlite:' . $config['database'], null, null, $options);
  }
}