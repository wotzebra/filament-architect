<?php

namespace App\Architect;

use Illuminate\View\View;
use Wotz\FilamentArchitect\Filament\Architect\BaseBlock;

class TestBlock extends BaseBlock
{
    protected ?string $name = 'Test Block';

    public function render(array $data): ?View
    {
        return view('architect.test-block', [
            'data' => $data,
        ]);
    }

    public function schema(): array
    {
        return [

        ];
    }
}
