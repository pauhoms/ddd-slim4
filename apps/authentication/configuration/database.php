<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Tools\Setup;

return function (): EntityManager {
    $settings = require __DIR__ . '/settings.php';
    $config = Setup::createAnnotationMetadataConfiguration(
        $settings['Authentication-mysql']['metadata_dirs']
    );

    $driver = new XmlDriver($settings['Authentication-mysql']['metadata_dirs']);
    $config->setMetadataDriverImpl($driver);

    return EntityManager::create(
        $settings['Authentication-mysql']['connection'],
        $config
    );
};