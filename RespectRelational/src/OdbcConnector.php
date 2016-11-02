<?php
namespace Webunion\Providers\Silex\RespectRelational;

class OdbcConnector extends Connector
{
	protected $options = [
		\PDO::ATTR_CASE              => \PDO::CASE_NATURAL,
		\PDO::ATTR_ERRMODE           => \PDO::ERRMODE_EXCEPTION,
		\PDO::ATTR_STRINGIFY_FETCHES => false,
		\PDO::ATTR_TIMEOUT 			 => 30,	
    ];

   /**
   * @param array $config
   *
   * @return \PDO
   */
   public function connect(array $config)
   {
    $port = (isset($config['port'])) ? ',' . $config['port'] : '';
	$dsn = 'odbc:DRIVER={'.$config['dsn_type'].'};SERVER='.$config['host'].''.$port.';DATABASE='.$config['database'].'';
	
	if (isset($config['charset'])) {
      $dsn .= ';charset='.$config['charset'].'';
    }
	
    return new \PDO($dsn, $config['username'], $config['password'], $this->options($config));
  }
}