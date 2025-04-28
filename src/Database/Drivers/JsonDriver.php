<?php

namespace OtherSoftware\Resolver\Database\Drivers;


use OtherSoftware\Resolver\Models\Repository;
use OtherSoftware\Resolver\Models\RepositoryCollection;


final class JsonDriver
{
    private string $path;


    private RepositoryCollection $repositories;


    public function __construct(string $path, RepositoryCollection $repositories)
    {
        $this->path = $path;
        $this->repositories = $repositories;
    }


    public function read(): void
    {
        if (file_exists($this->path)) {
            foreach (json_decode(file_get_contents($this->path), true) as $repository) {
                $this->repositories->add(Repository::hydrate($repository));
            }
        }
    }


    public function write(): void
    {
        $handle = fopen($this->path, 'w');

        fwrite($handle, json_encode($this->repositories->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        fclose($handle);
    }
}
