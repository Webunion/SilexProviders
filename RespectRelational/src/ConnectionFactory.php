<?php
/**
 * Database
 *
 * @copyright Copyright (c)  Gjero Krsteski (http://krsteski.de)
 * @license   http://opensource.org/licenses/MIT MIT License
 */
namespace Webunion\Providers\Silex\RespectRelational;
/**
 * Creates a PDO connection from the farm of connectors.
 *
 * @package Database
 * @author  Gjero Krsteski <gjero@krsteski.de>
 */
class ConnectionFactory
{
	public static $availableDrivers = ['sqlite', 'mysql', 'sqlserver', 'postgre', 'odbc'];
	
  /**
   * @param array $config
   *
   * @return \Pimf\Database
   * @throws \RuntimeException If no driver specified or no PDO installed.
   * @throws \UnexpectedValueException
   */
  public static function get(array $config)
  {
    if (!isset($config['driver']) || !$config['driver']) {
      throw new \RuntimeException('no driver specified');
    }
    
	$driver = strtolower($config['driver']);
	
    if (!in_array($driver, self::$availableDrivers, true)) {
      throw new \UnexpectedValueException('PDO driver "' . $driver . '" not supported.');
    }
	
    /*if (!extension_loaded('pdo') || !extension_loaded('pdo_' . $driver)) {
      throw new \RuntimeException('Please navigate to "http://php.net/manual/pdo.installation.php" '
        . ' to find out how to install "PDO" with "pdo_' . $driver . '" on your system!');
    }*/
	
    $driver = '\\'.__NAMESPACE__.'\\'. ucfirst($driver).'Connector';
    return ( new $driver() )->connect($config);
  }
}