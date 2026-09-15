# Upgrading

## From v2.4 to v2.5

The block editor is no longer a nested Livewire component. `editBlock` is now a
regular Filament action with its own `fillForm()` / `form()` / `action()`, so the
modal is rendered by the Livewire component that owns the `ArchitectInput`
instead of by a second, nested one.

Removed:

- `Codedor\FilamentArchitect\Livewire\EditModal`
- the `filament-architect-edit-modal` Livewire component
- the `filament-architect::edit-modal` and `filament-architect::livewire.edit-modal` views
- the `filament-architect::editedBlock` form event

Nothing changes for blocks themselves: `BaseBlock::schema()` is used exactly as
before and the stored block data keeps the same shape. If you published one of
the removed views, delete your copy - it is no longer rendered.

## From vx to vy
