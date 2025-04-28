<?php

namespace OtherSoftware\Resolver\Composer\Capability;


use Composer\Plugin\Capability\CommandProvider;
use OtherSoftware\Resolver\Commands\AddRepository;


final class ResolverCommandProvider implements CommandProvider
{
    public function getCommands(): array
    {
        return [
            new AddRepository(),
        ];
    }
}
