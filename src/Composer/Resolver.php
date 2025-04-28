<?php

namespace OtherSoftware\Resolver\Composer;


use Composer\Composer;
use Composer\EventDispatcher\Event;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PluginInterface;
use OtherSoftware\Resolver\Composer\Capability\ResolverCommandProvider;
use OtherSoftware\Resolver\Listeners\OnInitEventListener;


final class Resolver implements PluginInterface, EventSubscriberInterface, Capable
{
    private Composer $composer;


    private IOInterface $io;


    public static function getSubscribedEvents(): array
    {
        return [
            PluginEvents::INIT => ['onInit', 50000],
        ];
    }


    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }


    public function deactivate(Composer $composer, IOInterface $io)
    {
        //
    }


    public function getCapabilities(): array
    {
        return [
            CommandProvider::class => ResolverCommandProvider::class,
        ];
    }


    public function onInit(Event $event): void
    {
        (new OnInitEventListener($this->composer, $this->io))->handle();
    }


    public function uninstall(Composer $composer, IOInterface $io)
    {
        //
    }
}
