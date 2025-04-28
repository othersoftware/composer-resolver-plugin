<?php

namespace OtherSoftware\Resolver\Models;


final class Repository
{
    public readonly string $name;


    public readonly string $path;


    public static function hydrate(array $data): self
    {
        return new self($data['name'], $data['path']);
    }


    public function __construct(string $name, string $path)
    {
        $this->name = $name;
        $this->path = $path;
    }


    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
        ];
    }


    public function toComposerRepositoryConfig(): array
    {
        return [
            'type' => 'path',
            'url' => $this->path,
        ];
    }
}
