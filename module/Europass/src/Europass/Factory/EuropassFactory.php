<?php
namespace Europass\Factory;

use Europass\Service\EuropassService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EuropassFactory implements FactoryInterface
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
        return new EuropassService($serviceLocator->get('Europass\Model\Personaldata'));
    }
}