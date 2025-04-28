<?php

namespace OtherSoftware\Resolver\Models;


final class RepositoryCollection implements \Countable
{
    /**
     * @var Repository[]
     */
    private array $items = [];


    public function add(Repository $repository): self
    {
        $this->items[$repository->name] = $repository;

        return $this;
    }


    /**
     * @return Repository[]
     */
    public function all(): array
    {
        return array_values($this->items);
    }


    public function count(): int
    {
        return count($this->items);
    }


    public function toArray(): array
    {
        return array_map(fn(Repository $repository) => $repository->toArray(), array_values($this->items));
    }
}
