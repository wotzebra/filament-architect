<?php

namespace Wotz\FilamentArchitect\Tests\Fixtures\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\View\View;
use Livewire\Component;
use Wotz\FilamentArchitect\Filament\Fields\PageArchitectInput;

/**
 * The architect inside a layout component, whose key becomes part of the field's
 * schema component key (form.content.body) but not of its state path (data.body).
 */
class ArchitectInputInSectionComponent extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount(array $body = []): void
    {
        $this->form->fill(['body' => $body]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Content')
                    ->key('content')
                    ->schema([
                        PageArchitectInput::make('body'),
                    ]),
            ])
            ->statePath('data');
    }

    public function render(): View
    {
        return view('fixtures.architect-input-in-section-component');
    }
}
