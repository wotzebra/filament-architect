<?php

namespace Codedor\FilamentArchitect\Providers;

use Codedor\FilamentArchitect\ArchitectConfig;
use Codedor\FilamentArchitect\Commands\BlockMakeCommand;
use Codedor\FilamentArchitect\Livewire\ArchitectPreview;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentArchitectServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-architect')
            ->setBasePath(__DIR__ . '/../')
            ->hasConfigFile()
            ->hasMigration('create_architect_templates_table')
            ->runsMigrations()
            ->hasTranslations()
            ->hasCommand(BlockMakeCommand::class)
            ->hasViews()
            ->hasRoute('web');
    }

    public function registeringPackage(): void
    {
        $this->app->bind(ArchitectConfig::class, function () {
            return (new ArchitectConfig())->fromConfig();
        });
    }

    public function bootingPackage()
    {
        Livewire::component('filament-architect-preview', ArchitectPreview::class);
    }
}
