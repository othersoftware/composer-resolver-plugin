<?php

namespace OtherSoftware\Resolver\Commands;


use Composer\Command\BaseCommand;
use Composer\Json\JsonFile;
use OtherSoftware\Resolver\Database\Repositories;
use OtherSoftware\Resolver\Models\Repository;
use OtherSoftware\Resolver\Utilities;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;


final class AddRepository extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('add-repository');
        $this->setDescription('Adds local repository to registry to be resolved in your local projects.');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $currentWorkingDirectory = getcwd();
        $composerJsonFile = Utilities::join($currentWorkingDirectory, 'composer.json');

        if (! file_exists($composerJsonFile)) {
            $output->writeln('No composer.json found in current working directory.');
            return 1;
        }

        $json = new JsonFile($composerJsonFile);

        try {
            $json->validateSchema(JsonFile::LAX_SCHEMA);
            $composer = $json->read();
        } catch (Throwable $e) {
            $output->writeln('Unable to read composer.json file: ' . $e->getMessage());
            return 2;
        }

        $registry = Repositories::getInstance();
        $name = $composer['name'];

        $registry->add(new Repository($name, $currentWorkingDirectory));

        $output->writeln('Added repository for package "' . $name . '" to registry.');

        return 0;
    }
}
