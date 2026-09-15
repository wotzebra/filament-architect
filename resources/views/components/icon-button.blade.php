@php
    use Filament\Support\Enums\Size;
    use Filament\Support\Enums\IconSize;
@endphp

@props([
    'action',
    'statePath',
    'arguments' => [],
    'color' => 'gray',
    'label' => null,
    'class' => null,
    'tooltip' => null,
])

@php
    $wireClickActionArguments = \Illuminate\Support\Js::from($arguments);
    $wireClickActionMeta = \Illuminate\Support\Js::from(['schemaComponent' => str_replace('data.', 'form.', $statePath)]);
    $wireClickAction = "mountAction('{$action->getName()}', {$wireClickActionArguments}, {$wireClickActionMeta})";

    $isTextButton = filled($label);

    // Icon-only buttons have no text for a screen reader to read, so fall back to the
    // tooltip (and then the action's own label) for the `aria-label`.
    $accessibleLabel = $label ?: ($tooltip ?: $action->getLabel());
@endphp

<x-dynamic-component
    :component="$isTextButton ? 'filament::button' : 'filament::icon-button'"
    @class([
        'bg-white shadow-sm ring-1 ring-gray-950/10 dark:bg-white/10 dark:ring-white/20 m-0' => ! $isTextButton,
        $class,
    ])
    :color="$color"
    :wire:click="$wireClickAction"
    :icon="$action->getIcon()"
    :size="Size::Small"
    :icon-size="IconSize::Small"
    :label="$accessibleLabel"
    :$tooltip
>
    {{ $label }}
</x-dynamic-component>
