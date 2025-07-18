<?php

namespace OtherSoftware\Resolver\Database;


use OtherSoftware\Resolver\Database\Drivers\JsonDriver;
use OtherSoftware\Resolver\Models\Repository;
use OtherSoftware\Resolver\Models\RepositoryCollection;
use OtherSoftware\Resolver\Utilities;


final class Repositories
{
    private static Repositories $instance;


    private JsonDriver $driver;


    private RepositoryCollection $repositories;


    public function __construct()
    {
        $path = Utilities::base('database/repositories.json');

        $this->repositories = new RepositoryCollection();
        $this->driver = new JsonDriver($path, $this->repositories);

        $this->driver->read();
    }


    public function __destruct()
    {
        $this->driver->write();
    }


    public static function getInstance(): Repositories
    {
        if (! isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * @param Repository $repository
     *
     * @return $this
     */
    public function add(Repository $repository): Repositories
    {
        $this->repositories->add($repository);

        return $this;
    }


    public function removeByPath(Repository $repository): Repositories
    {
        $this->repositories->removeByPath($repository);

        return $this;
    }


    /**
     * @return Repository[]
     */
    public function all(): array
    {
        return $this->repositories->all();
    }
}
