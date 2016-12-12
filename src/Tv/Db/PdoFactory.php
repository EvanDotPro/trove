<?php
namespace Tv\Db;

use Interop\Container\ContainerInterface;
use PDO;

class PdoFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $config = $config['db'];
        $pdo = new PDO($config['dsn'], $config['user'], $config['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}
