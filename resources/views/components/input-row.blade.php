@php
    use Filament\Support\Enums\Size;
    use Filament\Support\Enums\IconSize;

    $blockClassName = get_architect_block($blocks, $block['type']);
    $blockName = $blockClassName::make()->getName();
    $shown = (! $hasShownButton) || ($block['shown'] ?? true);
@endphp

<div
    :key="$uuid"
    class="w-full flex gap-2 items-center"
    x-sortable-item="{{ $uuid }}"
    style="grid-column: span {{ $block['width'] ?? 12 }};"
>
    <div @class([
        'relative grow bg-gray-50 dark:bg-white/5 p-2 rounded-lg
            ring-1 ring-gray-950/5 dark:ring-white/10 justify-between flex gap-2
            group @sm:p-4',
        'bg-gray-50/50 dark:bg-white/[0.03] ring-gray-950/[0.03]
            dark:ring-white/5' => ! $shown
    ])>
        <div @class([
            'flex flex-col text-sm',
            'text-gray-950/50 dark:text-white/40' => ! $shown
        ])>
            <div class="flex gap-1">
                <strong>
                    {{ $block['data']['working_title'] ?? $blockName }}
                </strong>

                @if (! $shown)
                    <span>
                        (hidden)
                    </span>
                @endif

                @foreach ($locales as $locale)
                    <x-filament-architect::locale-indicator
                        :online="$block['data'][$locale]['online'] ?? false"
                        :locale="$locale"
                    />
                @endforeach
            </div>

            <span class="text-xs">
                {{ $blockName }}
            </span>
        </div>

        <div class="
            absolute top-2 right-2 flex gap-1
            opacity-0 group-hover:opacity-100 focus-within:opacity-100
        ">
            @if (count($row) > 1)
                <x-filament::icon-button
                    color="gray"
                    :icon="\Filament\Support\Icons\Heroicon::OutlinedArrowsRightLeft"
                    :label="__('filament-architect::admin.reorder block')"
                    :tooltip="__('filament-architect::admin.reorder block')"
                    class="bg-white shadow-sm ring-1 ring-gray-950/10 dark:bg-white/10 dark:ring-white/20 cursor-move m-0"
                    :size="Size::Small"
                    :icon-size="IconSize::Small"
                    x-sortable-handle
                />
            @endif

            @if ($hasDuplicateAction)
                <x-filament-architect::icon-button
                    :action="$getAction('duplicateBlock')"
                    :state-path="$statePath"
                    :arguments="[
                        'uuid' => $uuid,
                        'row' => $rowKey,
                    ]"
                    :tooltip="__('filament-architect::admin.duplicate block')"
                />
            @endif

            @if ($hasShownButton)
                <x-filament-architect::icon-button
                    :action="$getAction($shown ? 'enableBlock': 'disableBlock')"
                    :state-path="$statePath"
                    :arguments="[
                        'uuid' => $uuid,
                        'row' => $rowKey,
                    ]"
                    tooltip="{{ $shown ? __('filament-architect::admin.hide block') : __('filament-architect::admin.show block') }}"
                />
            @endif

            <x-filament-architect::icon-button
                :action="$getAction('editBlock')"
                :state-path="$statePath"
                :arguments="[
                    'uuid' => $uuid,
                    'row' => $rowKey,
                    'block' => $block,
                    'blockClassName' => $blockClassName,
                    'locales' => $locales,
                ]"
                :tooltip="__('filament-architect::admin.edit block')"
            />

            <x-filament-architect::icon-button
                color="danger"
                :action="$getAction('deleteBlock')"
                :state-path="$statePath"
                :arguments="[
                    'uuid' => $uuid,
                    'row' => $rowKey,
                ]"
                :tooltip="__('filament-architect::admin.delete block')"
            />
        </div>
    </div>

    @if ($canAddFields)
        <div class="flex flex-col gap-2">
            <x-filament-architect::icon-button
                :action="$getAction('addBlockBetween')"
                :state-path="$statePath"
                :arguments="['row' => $rowKey, 'insertAfter' => $uuid]"
                :tooltip="__('filament-architect::admin.add block between')"
            />
        </div>
    @endif
</div>
