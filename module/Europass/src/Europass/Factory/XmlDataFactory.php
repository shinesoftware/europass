<?php
namespace Europass\Factory;

use Europass\Model\XmlData;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class XmlDataFactory implements FactoryInterface
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
        return new XmlData('<?xml version=\'1.0\' encoding=\'utf-8\'?><SkillsPassport xmlns="http://europass.cedefop.europa.eu/Europass" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://europass.cedefop.europa.eu/xml/v3.1.0/EuropassSchema.xsd" />');
    }
}