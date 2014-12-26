<?php

/**
 * The main class of the bundle.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage WebServicesClientBundle
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use AMF\WebServicesClientBundle\DependencyInjection\Compiler\RegisterSoapWebServicesPass;
use AMF\WebServicesClientBundle\DependencyInjection\Compiler\RegisterRestWebServicesPass;

/**
 * The main class of the bundle.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage WebServicesClientBundle
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class AMFWebServicesClientBundle extends Bundle
{

    /**
     * Builds the container.
     * 
     * @param ContainerBuilder $container The container.
     * 
     * @return void
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        
        $container->addCompilerPass(new RegisterSoapWebServicesPass());
        $container->addCompilerPass(new RegisterRestWebServicesPass());
    }

}
