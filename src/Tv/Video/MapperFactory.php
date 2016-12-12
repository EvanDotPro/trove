<?php
namespace Tv\Video;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use PDO;

class MapperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $pdo = $container->get(PDO::class);

        return new Mapper($pdo);
    }
}
