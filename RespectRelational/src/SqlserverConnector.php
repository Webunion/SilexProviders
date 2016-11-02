<?php
/**
 * Database
 *
 * @copyright Copyright (c)  Gjero Krsteski (http://krsteski.de)
 * @license   http://opensource.org/licenses/MIT MIT License
 */
namespace Webunion\Providers\Silex\RespectRelational;
/**
 * Connection management to SQL Server
 *
 * @package Database
 * @author  Gjero Krsteski <gjero@krsteski.de>
 */
class SqlserverConnector extends Connector
{
  protected $options = array(
      \PDO::ATTR_CASE              => \PDO::CASE_NATURAL,
      \PDO::ATTR_ERRMODE           => \PDO::ERRMODE_EXCEPTION,
      \PDO::ATTR_ORACLE_NULLS      => \PDO::NULL_NATURAL,
      \PDO::ATTR_STRINGIFY_FETCHES => false,
    );
  /**
   * @param array $config
   *
   * @return \PDO
   */
  public function connect(array $config)
  {
    // This connection string format can also be used to connect
    // to Azure SQL Server databases.
    $port = (isset($config['port'])) ? ',' . $config['port'] : '';

    if (isset($config['dsn_type']) && !empty($config['dsn_type']) && $config['dsn_type'] == 'dblib') {
		$dsn = "dblib:host={$config['host']}{$port};dbname={$config['database']}";
    } 
	elseif($config['dsn_type'] == 'odbc'){
		$dsn = "odbc:DRIVER={SQL SERVER};SERVER={$config['host']}{$port};DATABASE={$config['database']}";
	}
	else {
		$dsn = "sqlsrv:Server={$config['host']}{$port};Database={$config['database']}";
    }
	
	if (isset($config['charset'])) {
      $dsn .= ";charset={$config['charset']}";
    }
	
    return new \PDO($dsn, $config['username'], $config['password'], $this->options($config));
  }
}