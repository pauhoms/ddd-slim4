<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Tools\Setup;
use Doctrine\DBAL\Types\Type;

return function (): EntityManager {
    $settings = require __DIR__ . '/settings.php';
    $config = Setup::createXMLMetadataConfiguration(
        $settings['Authentication-mysql']['metadata_dirs'],
        true
    );

    $driver = new XmlDriver($settings['Authentication-mysql']['metadata_dirs']);
    $config->setMetadataDriverImpl($driver);

    foreach ($settings['Authentication-mysql']['custom-type'] as $type) {
        if (!Type::hasType($type[0])) {
            Type::addType($type[0], $type[1]);
        }
    }

    return EntityManager::create(
        $settings['Authentication-mysql']['connection'],
        $config
    );
};