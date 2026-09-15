<?php

namespace Wotz\FilamentArchitect\Filament\Architect;

use Filament\Forms\Components\Repeater;
use Illuminate\View\View;
use Wotz\FilamentArchitect\ArchitectFormats;
use Wotz\MediaLibrary\Filament\AttachmentInput;
use Wotz\MediaLibrary\Support\Config;

class SliderBlock extends BaseBlock
{
    public function render(array $data): ?View
    {
        $images = collect($data['slider'] ?? [])->pluck('image')->filter();

        return view('filament-architect::architect.slider-block', [
            'images' => Config::attachmentModel()::find($images)->filter(),
        ]);
    }

    public function schema(): array
    {
        return [
            Repeater::make('slider')
                ->schema([
                    AttachmentInput::make('image')
                        ->allowedFormats(ArchitectFormats::get()),
                ])
                ->minItems(1)
                ->grid(3),
        ];
    }
}
