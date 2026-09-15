<?php

namespace Wotz\FilamentArchitect\Filament\Architect;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Get;
use Illuminate\View\View;
use Wotz\FilamentArchitect\ArchitectFormats;
use Wotz\FilamentArchitect\Facades\ArchitectConfig;
use Wotz\MediaLibrary\Filament\AttachmentInput;
use Wotz\MediaLibrary\Support\Config;

class MediaBlock extends BaseBlock
{
    public function render(array $data): ?View
    {
        return view('filament-architect::architect.media-block', [
            'width' => $data['width'] ?? null,
            'images' => collect($data['images'] ?? [])->map(function (array $image) {
                return Config::attachmentModel()::find($image['image'] ?? null);
            })->filter(),
        ]);
    }

    public function schema(): array
    {
        return [
            Radio::make('width')
                ->visible((bool) ArchitectConfig::getWidthOptionsEnum())
                ->required()
                ->options(function (\Filament\Schemas\Components\Utilities\Get $get) {
                    $enum = ArchitectConfig::getWidthOptionsEnum();

                    if (! $enum) {
                        return [];
                    }

                    if (is_array($get('images')) && count($get('images')) > 2) {
                        return $enum::toSelectForMaxImages();
                    }

                    return $enum::toSelect();
                }),

            Repeater::make('images')
                ->schema([
                    AttachmentInput::make('image')
                        ->allowedFormats(ArchitectFormats::get()),
                ])
                ->minItems(1)
                ->maxItems(3)
                ->reactive()
                ->grid(3),
        ];
    }
}
