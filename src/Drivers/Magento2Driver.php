<?php

namespace SourceBroker\DeployerExtendedMagento2\Drivers;

/**
 * Class Magento2Driver
 * @package SourceBroker\DeployerExtendedMagento2\Drivers
 */
class Magento2Driver
{
    /**
     * @param null $absolutePathWithConfig
     * @return array
     * @throws \Exception
     * @internal param null $params
     */
    public function getDatabaseConfig($absolutePathWithConfig = null)
    {
        if(null === $absolutePathWithConfig) {
            $absolutePathWithConfig = getcwd() . '/app/etc/env.php';
        }
        if (file_exists($absolutePathWithConfig)) {
            /** @noinspection PhpIncludeInspection */
            $config = include $absolutePathWithConfig;
            $connectionDefault = $config['db']['connection']['default'];
            $dbSettings = [];
            $dbSettings['user'] = $connectionDefault['username'];
            $dbSettings['password'] = $connectionDefault['password'];
            $dbSettings['dbname'] = $connectionDefault['dbname'];
            $dbSettings['host'] = $connectionDefault['host'];
            if (isset($connectionDefault['port'])) {
                $dbSettings['port'] = $connectionDefault['port'];
            }
        } else {
            throw new \Exception('Missing file with database parameters. Looking for file: "' . $absolutePathWithConfig . '"');
        }
        return $dbSettings;
    }

    /**
     * @param null $absolutePathWithConfig
     * @return string
     * @throws \Exception
     * @internal param null $params
     */
    public function getInstanceName($absolutePathWithConfig = null)
    {
        if(null === $absolutePathWithConfig) {
            $absolutePathWithConfig = getcwd() . '/app/etc/env.php';
        }
        if (file_exists($absolutePathWithConfig)) {
            /** @noinspection PhpIncludeInspection */
            $config = include $absolutePathWithConfig;
            $instanceName = null;
            if (isset($config['instance'])) {
                $instanceName = $config['instance'];
            }
            if ($instanceName) {
                return strtolower($instanceName);
            } else {
                throw new \Exception("Missing instance name in app/etc/env.php file. Instance key=>value should be on root level of array.");
            }
        } else {
            throw new \Exception('Missing file with instance name. Looking for file: "' . $absolutePathWithConfig . '"');
        }
    }

}
