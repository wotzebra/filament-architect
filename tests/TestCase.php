<?php

namespace Codedor\FilamentArchitect\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Codedor\FilamentArchitect\Providers\FilamentArchitectServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use FilamentTiptapEditor\Actions\LinkAction;
use FilamentTiptapEditor\Enums\TiptapOutput;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

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
            fn (string $modelName) => 'Codedor\\FilamentArchitect\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
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

        config()->set('filament-tiptap-editor.output', TiptapOutput::Html);
        config()->set('filament-tiptap-editor.link_action', LinkAction::class);

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
            LivewireServiceProvider::class,
            SupportServiceProvider::class,
            ActionsServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            NotificationsServiceProvider::class,
            FilamentArchitectServiceProvider::class,
        ];
    }
}
