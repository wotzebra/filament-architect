<?php

namespace Wotz\FilamentArchitect\Filament\Architect;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Illuminate\View\View;
use Wotz\FilamentArchitect\ArchitectFormats;
use Wotz\MediaLibrary\Filament\AttachmentInput;
use Wotz\MediaLibrary\Support\Config;

class MediaTextBlock extends BaseBlock
{
    protected ?string $name = 'Media & Text Block';

    public function render(array $data): ?View
    {
        return view('filament-architect::architect.media-text-block', [
            'alignment' => $data['alignment'] ?? '',
            'image' => Config::attachmentModel()::find($data['image'] ?? null),
            'description' => $data['description'] ?? '',
        ]);
    }

    public function schema(): array
    {
        return [
            Radio::make('alignment')
                ->default('left')
                ->options([
                    'left' => 'Left',
                    'right' => 'Right',
                ]),

            AttachmentInput::make('image')
                ->allowedFormats(ArchitectFormats::get())
                ->required(),

            RichEditor::make('description')
                ->label('Text to display'),
        ];
    }
}
