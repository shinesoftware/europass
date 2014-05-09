<?php
namespace Europass\Factory;

use Europass\Controller\EuropassController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EuropassControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $europassService = $realServiceLocator->get('Europass\Service\EuropassServiceInterface');

        return new EuropassController($europassService);
    }
}