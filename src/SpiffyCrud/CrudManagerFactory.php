<?php

namespace SpiffyCrud;

use Zend\ServiceManager\Config;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CrudManagerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CrudManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \SpiffyCrud\ModuleOptions $options */
        $options = $serviceLocator->get('SpiffyCrud\ModuleOptions');
        $adapter = $this->get($options->getAdapter(), $serviceLocator);
        $manager = new CrudManager($adapter, new Config($options->getModels()));
        $manager->setDefaultHydrator($options->getDefaultHydrator());
        $manager->setHydratorManager($serviceLocator->get('HydratorManager'));
        $manager->setFormBuilder($this->get($options->getFormBuilder(), $serviceLocator));
        $manager->setFormElementManager($serviceLocator->get('FormElementManager'));

        return $manager;
    }

    /**
     * Generic method for getting from service locator, or creating a class.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $input
     * @throws \RuntimeException if the resource could not be found
     * @return mixed
     */
    protected function get($input, ServiceLocatorInterface $serviceLocator)
    {
        if (is_string($input) && $serviceLocator->has($input)) {
            return $serviceLocator->get($input);
        } else if (class_exists($input)) {
            return new $input;
        }

        throw new \RuntimeException(sprintf(
            'Service "%s" could not be found',
            $input
        ));
    }
}
