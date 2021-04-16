<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Route;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouteCollection;

class ControllerLoader extends Loader
{
    private const FILE_ENDING = '*Controller.php';

    public function __construct(private KernelInterface $kernel) {}

    public function load($resource, string $type = null)
    {
        $locate = (new Finder())->in(sprintf("%s/src", $this->kernel->getProjectDir()))->name(self::FILE_ENDING);

        $routes = new RouteCollection();

        foreach($locate AS $file){
            /**@var SplFileInfo $file*/
            $annotation = $this->resolver->resolve($file->getRealPath(), "annotation");

            if($routesFound = $annotation->load($file->getRealPath())){
                $routes->addCollection($routesFound);
            }
        }
        return $routes;
    }

    public function supports($resource, string $type = null)
    {
        return "controller-loader" === $type;
    }
}
