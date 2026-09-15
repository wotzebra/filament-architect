<?php

use Codedor\FilamentArchitect\Tests\Fixtures\Blocks\TextBlock;
use Codedor\FilamentArchitect\Tests\Fixtures\Livewire\ArchitectForm;
use Livewire\Livewire;

beforeEach(function () {
    config(['filament-architect.default-blocks' => [TextBlock::class]]);

    $this->body = [[
        'the-uuid' => [
            'type' => 'TextBlock',
            'width' => null,
            'data' => ['working_title' => 'a block', 'text' => 'hello'],
        ],
    ]];

    $this->arguments = [
        'uuid' => 'the-uuid',
        'row' => 0,
        'block' => $this->body[0]['the-uuid'],
        'blockClassName' => TextBlock::class,
        'locales' => [],
    ];
});

it('mounts the edit block action with the block schema', function () {
    $component = Livewire::test(ArchitectForm::class, ['body' => $this->body])
        ->call('mountFormComponentAction', 'data.body', 'editBlock', $this->arguments)
        ->assertSet('mountedFormComponentActions', ['editBlock'])
        ->assertSuccessful();

    expect($component->instance()->getMountedFormComponentAction())->not->toBeNull();

    $component
        ->assertFormFieldExists('working_title', 'mountedFormComponentActionForm0')
        ->assertFormFieldExists('text', 'mountedFormComponentActionForm0');
});

it('fills the modal form with the block data', function () {
    Livewire::test(ArchitectForm::class, ['body' => $this->body])
        ->call('mountFormComponentAction', 'data.body', 'editBlock', $this->arguments)
        ->assertSet('mountedFormComponentActionsData.0.working_title', 'a block')
        ->assertSet('mountedFormComponentActionsData.0.text', 'hello');
});

it('writes the submitted data back into the field state', function () {
    Livewire::test(ArchitectForm::class, ['body' => $this->body])
        ->call('mountFormComponentAction', 'data.body', 'editBlock', $this->arguments)
        ->set('mountedFormComponentActionsData.0.working_title', 'renamed')
        ->set('mountedFormComponentActionsData.0.text', 'goodbye')
        ->call('callMountedFormComponentAction')
        ->assertHasNoFormErrors()
        ->assertSet('mountedFormComponentActions', [])
        ->assertSet('data.body.0.the-uuid.data.working_title', 'renamed')
        ->assertSet('data.body.0.the-uuid.data.text', 'goodbye');
});

it('keeps the block type and width when saving', function () {
    Livewire::test(ArchitectForm::class, ['body' => $this->body])
        ->call('mountFormComponentAction', 'data.body', 'editBlock', $this->arguments)
        ->call('callMountedFormComponentAction')
        ->assertSet('data.body.0.the-uuid.type', 'TextBlock');
});

it('renders the edit block modal inside the same livewire component', function () {
    // Regression: the block editor used to be a nested Livewire component with
    // its own <x-filament-actions::modals />. Stacking a second Filament modal
    // stack inside the first one made nested actions - such as the Tiptap link
    // picker - open and close at random.
    Livewire::test(ArchitectForm::class, ['body' => $this->body])
        ->call('mountFormComponentAction', 'data.body', 'editBlock', $this->arguments)
        ->assertDontSee('filament-architect-edit-modal')
        ->assertSee('mountedFormComponentActionsData.0.working_title');
});
