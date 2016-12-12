<?php
namespace Tv\Db;

use Doctrine\DBAL\DriverManager;
use Interop\Config\ConfigurationTrait;
use Interop\Config\RequiresConfigId;
use Interop\Config\RequiresMandatoryOptions;
use Interop\Container\ContainerInterface;

/**
 * Class DoctrineDbalConnectionFactory
 *
 * @package src\Infrastructure\Container
 */
final class DoctrineDbalConnectionFactory implements RequiresConfigId, RequiresMandatoryOptions
{
    use ConfigurationTrait;

    /**
     * @param ContainerInterface $container
     *
     * @return \Doctrine\DBAL\Connection
     */
    public function __invoke(ContainerInterface $container)
    {
        $options = $this->options($container->get('config'), 'default');

        return DriverManager::getConnection($options);
    }

    /**
     * Returns the vendor name
     *
     * @return string
     */
    public function dimensions()
    {
        return ['doctrine', 'connection'];
    }

    /**
     * Returns a list of mandatory options which must be available
     *
     * @return string[] List with mandatory options
     */
    public function mandatoryOptions()
    {
        return ['driverClass'];
    }
}
