<?php

namespace Avro\TranslatorBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;

/*
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class AvroTranslatorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->process($configuration->getConfigTree(), $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if ($config['provider'] == 'azure') {
            $loader->load('azure.yml');
        }

        $container->setParameter('azure_client_id', $config['azure']['client_id']);
        $container->setParameter('azure_client_secret', $config['azure']['client_secret']);
    }
}

