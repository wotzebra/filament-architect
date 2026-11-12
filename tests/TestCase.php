<?php

namespace Wotz\FilamentArchitect\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Wotz\FilamentArchitect\Providers\FilamentArchitectServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        $this->afterApplicationCreated(function () {
            $this->makeACleanSlate();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->makeACleanSlate();
        });

        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Wotz\\FilamentArchitect\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    public function makeACleanSlate(): void
    {
        File::deleteDirectory($this->architectClassPath());
        File::deleteDirectory($this->architectViewPath());
        File::deleteDirectory(base_path('stubs'));
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        config()->set('view.paths', [
            resource_path('views'),
            __DIR__ . '/views',
            __DIR__ . '/../resources/views',
        ]);
    }

    public function architectClassPath($path = ''): string
    {
        return app_path('Architect' . ($path ? '/' . $path : ''));
    }

    public function architectViewPath($path = ''): string
    {
        return resource_path('views') . '/architect' . ($path ? '/' . $path : '');
    }

    protected function getPackageProviders($app)
    {
        return [
            BladeIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            SupportServiceProvider::class,
            ActionsServiceProvider::class,
            FormsServiceProvider::class,
            SchemasServiceProvider::class,
            InfolistsServiceProvider::class,
            FilamentArchitectServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }
}
