<?php
namespace Common\Db\Connection;

use Doctrine\DBAL\Connections\MasterSlaveConnection;
use Doctrine\DBAL\Driver;
use Exception;

class FailSafeMasterSlaveConnection extends MasterSlaveConnection
{
	/**
	 * @param string $connectionName
	 * @return Driver
	 * @throws Exception if no host to connect found
	 */
	protected function connectTo($connectionName)
	{
		$params = $this->getParams();

		if ($connectionName === 'master')
		{
			return parent::connectTo($connectionName);
		}

		$hosts   = $params['slaves'];
		$hosts[] = $params['master'];

		foreach ($hosts as $dbConfig)
		{
			try
			{
				return $this->_driver->connect(
					$dbConfig,
					$dbConfig['user'],
					$dbConfig['password'],
					$params['driverOptions'] ?? []
				);
			}
			catch (Exception $exception)
			{
				error_log($exception->getMessage());
			}
		}

		throw new Exception('Could not connect to any slave or master');
	}
}
