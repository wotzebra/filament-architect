<?php

use Illuminate\Support\Js;
use Livewire\Livewire;
use Wotz\FilamentArchitect\Tests\Fixtures\Blocks\TestBlock;
use Wotz\FilamentArchitect\Tests\Fixtures\Livewire\ArchitectInputInSectionComponent;

beforeEach(function () {
    config(['filament-architect.default-blocks' => [TestBlock::class]]);
});

$body = [
    [
        'first' => ['type' => 'TestBlock', 'width' => 12, 'data' => []],
        'second' => ['type' => 'TestBlock', 'width' => 12, 'data' => []],
    ],
];

it('points the block actions at the field, not at its state path', function () use ($body) {
    // The buttons' wire:click carries the key as Js::from() renders it
    $html = Livewire::test(ArchitectInputInSectionComponent::class, ['body' => $body])->html();

    expect($html)
        ->toContain(Js::from(['schemaComponent' => 'form.content.body'])->toHtml())
        ->not->toContain(Js::from(['schemaComponent' => 'form.body'])->toHtml());
});

it('reorders the blocks in a row', function () use ($body) {
    $component = Livewire::test(ArchitectInputInSectionComponent::class, ['body' => $body])
        ->assertSeeHtml("'reorderColumn'")
        ->call('callSchemaComponentMethod', 'form.content.body', 'reorderColumn', [
            'newKeys' => ['second', 'first'],
            'row' => '0',
        ]);

    expect(array_keys($component->get('data.body')[0]))->toBe(['second', 'first']);
});

it('keys every block, so a re-render after reordering keeps the page where it was', function () use ($body) {
    $html = Livewire::test(ArchitectInputInSectionComponent::class, ['body' => $body])->html();

    expect($html)
        ->toContain('wire:key="data.body.first"')
        ->toContain('wire:key="data.body.second"');
});
