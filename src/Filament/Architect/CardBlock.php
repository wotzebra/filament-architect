<?php

namespace Wotz\FilamentArchitect\Filament\Architect;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Illuminate\View\View;
use Wotz\FilamentArchitect\ArchitectFormats;
use Wotz\FilamentArchitect\Filament\Components\ButtonComponent;
use Wotz\MediaLibrary\Filament\AttachmentInput;
use Wotz\MediaLibrary\Support\Config;

class CardBlock extends BaseBlock
{
    public function render(array $data): ?View
    {
        return view('filament-architect::architect.cards-block', [
            'cards' => collect($data['cards'])->map(function (array $block) {
                $block['image'] = Config::attachmentModel()::find($block['image'] ?? null);

                return $block;
            }),
        ]);
    }

    public function schema(): array
    {
        return [
            Repeater::make('cards')
                ->collapsible()
                ->reorderable()
                ->minItems(1)
                ->schema([
                    TextInput::make('title')
                        ->required(),

                    RichEditor::make('description'),

                    AttachmentInput::make('image')
                        ->allowedFormats(ArchitectFormats::get()),

                    ButtonComponent::make('button'),
                ]),
        ];
    }
}
