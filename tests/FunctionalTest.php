<?php

namespace KnpU\LoremIpsumBundle\Tests;

use KnpU\LoremIpsumBundle\KnpUIpsum;
use KnpU\LoremIpsumBundle\KnpULoremIpsumBundle;
use KnpU\LoremIpsumBundle\WordProviderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

class FunctionalTest extends TestCase
{
    public function testServiceWiring()
    {
        $kernel = new KnpULoremIpsumTestingKernel();
        $kernel->boot();

        $container = $kernel->getContainer();
        /** @var KnpUIpsum $ipsum */
        $ipsum = $container->get('knpu_lorem_ipsum.knp_uipsum');

        $this->assertInstanceOf(KnpUIpsum::class, $ipsum);
        $this->assertIsString($ipsum->getParagraphs());
    }

    public function testServiceWiringWithConfiguration()
    {
        $kernel = new KnpULoremIpsumTestingKernel([
            'word_provider' => 'stub_word_list'
        ]);
        $kernel->boot();

        $container = $kernel->getContainer();
        /** @var KnpUIpsum $ipsum */
        $ipsum = $container->get('knpu_lorem_ipsum.knp_uipsum');
        $this->assertStringContainsString('stub', $ipsum->getWords(2));
    }
}

class StubWordList implements WordProviderInterface
{
    public function getWordList(): array
    {
        return [
            'stub',
            'stub2',
        ];
    }
}

class KnpULoremIpsumTestingKernel extends Kernel {
    /**
     * @var array
     */
    private $knpUIpsumConfig;

    public function __construct(array $knpUIpsumConfig = [])
    {
        $this->knpUIpsumConfig = $knpUIpsumConfig;
        parent::__construct('test', true);
    }


    public function registerBundles()
    {
        return [
            new KnpULoremIpsumBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        // it responsible for passing the yaml fields
        $loader->load(function(ContainerBuilder $container) {
            $container->register('stub_word_list', StubWordList::class);

            $container->loadFromExtension('knpu_lorem_ipsum', $this->knpUIpsumConfig);
        });
    }

    public function getCacheDir()
    {
        return __DIR__ . '/cache/' . spl_object_hash($this);
    }
}