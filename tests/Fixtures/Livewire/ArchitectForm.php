<?php

namespace Codedor\FilamentArchitect\Tests\Fixtures\Livewire;

use Codedor\FilamentArchitect\Filament\Fields\PageArchitectInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class ArchitectForm extends Component implements HasForms
{
    use InteractsWithForms;

    /**
     * @var array<string, mixed>
     */
    public array $data = [];

    public function mount(array $body = []): void
    {
        $this->form->fill(['body' => $body]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                PageArchitectInput::make('body'),
            ])
            ->statePath('data');
    }

    public function render(): string
    {
        return <<<'BLADE'
            <div>
                {{ $this->form }}

                <x-filament-actions::modals />
            </div>
        BLADE;
    }
}
