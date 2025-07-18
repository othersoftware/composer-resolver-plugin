<?php

namespace OtherSoftware\Resolver\Listeners;


use Composer\Composer;
use Composer\Config;
use Composer\IO\IOInterface;
use Composer\Repository\RepositoryFactory;
use Composer\Repository\RepositoryInterface;
use Composer\Repository\RepositoryManager;
use OtherSoftware\Resolver\Database\Repositories;
use OtherSoftware\Resolver\Models\Repository;


final class OnInitEventListener
{
    private Config $config;


    private IOInterface $io;


    private RepositoryManager $manager;


    private Repositories $repositories;


    public function __construct(Composer $composer, IOInterface $io)
    {
        $this->io = $io;
        $this->config = $composer->getConfig();
        $this->manager = $composer->getRepositoryManager();
        $this->repositories = Repositories::getInstance();
    }


    public function handle(): void
    {
        foreach ($this->repositories->all() as $local) {
            if (! file_exists($local->path) || ! is_dir($local->path)) {
                $this->repositories->removeByPath($local);
                continue;
            }

            $this->manager->prependRepository($this->createRepository($local));
        }
    }


    private function createRepository(Repository $repository): RepositoryInterface
    {
        return RepositoryFactory::createRepo($this->io, $this->config, $repository->toComposerRepositoryConfig(), $this->manager);
    }
}
