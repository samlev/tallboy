<x-form.label :attributes="attrs($label)->class(['w-full' => $fullWidth, 'flex-col' => $stacked, 'items-stretch' => $fullWidth && $stacked])">
  @hasSlot($label)
    {{ $label }}
  @else
    {{ $guessLabel() }}
  @endHasSlot
  <div @class(['flex flex-col gap-0.5', 'w-full grow' => $fullWidth])>
    <input {{ $attributes->class(['rounded font-medium invalid:border-red-500 disabled:opacity-50 peer', 'w-full' => $fullWidth])->merge(['type' => $type, 'placeholder' => $placeholder]) }}/>
    {{ $slot }}
    @foreach($getHints() as $hint)
      <x-form.field-hint>{{ $hint }}</x-form.field-hint>
    @endforeach
    @if($showErrors)
      <x-form.input-errors :messages="$messages" :fields="$getErrorBags()"/>
    @endif
  </div>
</x-form.label>
