<?php
namespace App\DependencyInjection;

use App\Entity\MemberCollection;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class AppExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // Kernel::configureContainerに以下行を追加する必要がある
        //   $container->registerExtension(new DependencyInjection\AppExtension());

        $loader = new YamlFileLoader($container,
            new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.yaml');

        $config = $this->processConfiguration(new Configuration(), $configs);

        $this->buildMemberCollectionDefinition($container, $config['members']);
    }

    private function buildMemberCollectionDefinition(ContainerBuilder $container, $memberList)
    {
        $collectionDefinition = $container->register('app.member_collection',
            MemberCollection::class);
        $collectionDefinition->setPrivate(false);

        foreach ($memberList as $name => $memberInfo) {
            $collectionDefinition->addMethodCall('addMember', [
                $name, $memberInfo['part'], $memberInfo['joinedDate']
            ]);
        }
    }

    public function getAlias()
    {
        return 'app';
    }
}