<?php

namespace Codedor\FilamentArchitect\Tests\Fixtures\Blocks;

use Codedor\FilamentArchitect\Filament\Architect\BaseBlock;
use Filament\Forms\Components\TextInput;

class TextBlock extends BaseBlock
{
    public function schema(): array
    {
        return [
            TextInput::make('text'),
        ];
    }
}
