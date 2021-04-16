<?php
declare(strict_types=1);

namespace App\Common\Infrastructure;

use App\Common\Infrastructure\Route\ControllerLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CommonBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(ControllerLoader::class)->addTag("routing.loader");

        parent::build($container);
    }
}
