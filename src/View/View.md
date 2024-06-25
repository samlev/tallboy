View Helpers
============
Tallboy provides a number of helpers to make working with blade components and views easier.

## Slots
For some components Tallboy uses slots to allow you to pass in content, but also provides the ability to pass the
content in as a parameter. This is useful for slots that typically just display text, but might occasionally need a more
complex display:
```bladehtml
<x-alert title="This is an alert">
  This is the content of the alert.
</x-alert>

<x-alert>
    <x-slot:title>
      <div class="flex justify-between items-center">
        This is a title with extra content.
        <x-icon name="loading" class="animate-spin" />
      </div>
    </x-slot:title>
    This is the content of the alert.
</x-alert>
```
### Conditionally rendering slot content with `@isSlot` and `@hasSlot`
If you are creating a component and want to treat the content differently if a variable is a slot or a string, you can
use the `@isSlot`/`@elseIsSlot`/`@unlessIsSlot`/`@endIsSlot` helpers to test if the content was passed as a slot.
Additionally, you can use the `@hasSlot`/`@elseHasSlot`/`@unlessHasSlot`/`@endHasSlot` helpers to check if the variable
is a slot and is also not empty.
```bladehtml
{{-- resources/views/components/card.blade.php --}}
@props(['title' = 'Some title'])
<section>
    @unlessIsSlot($title)
      <header>{{ $title }}</header>
    @elseHasSlot($title)
      {{ $title }}
    @endIsSlot
    
    {{ $slot }}
    
    @hasSlot($footer)
      {{ $footer }}
    @else
      <footer>
        This is the default footer.
      </footer>
    @endHasSlot
</section>

{{-- usage --}}
<x-card title="This is a custom title."  footer="This will never be rendered">
  This is the content of the card.
</x-card>

<x-card>
  <x-slot:title><em>This</em> is a custom title as a slot.</x-slot:title>
  This is the content of the card.
  <x-slot:footer>This is a custom footer as a slot.</x-slot:footer>
</x-card>
```
### Passing through component and slot attributes with `attrs()`
When you are using components to alter the behaviour of other components, you occasionally want to expose the slots and
pass through attributes. You can use the `attrs()` helper to resolve a component attribute bag from the variable,
whether it is a slot, a string, or anything else. This allows you to simplify your views, and still pass down attributes
to the slot:
```bladehtml
{{-- resources/views/components/loading-alert.blade.php --}}
@props(['title' = 'Loading...'])
<x-alert>
    @slot('title', attributes: [...attrs($title)->class(['flex justify-between items-center'])])
      {{ $title }}
      <x-icon name="loading" class="animate-spin" />
    @endslot
    {{ $slot }}
</x-alert>

{{-- usage --}}
<x-loading-alert title="This is a custom title.">
  This is the content of the alert.
</x-loading-alert>

<x-loading-alert>
  <x-slot:title class="text-red-500">This is a custom title with attributes.</x-slot:title>
  This is the content of the alert.
</x-loading-alert>
```
