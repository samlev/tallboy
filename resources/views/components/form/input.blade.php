<x-form.label :attributes="attrs($label)->class(['w-full' => $fullWidth, 'flex-col' => $stacked, 'items-stretch' => $fullWidth && $stacked])">
  @hasSlot($label)
    {{ $label }}
  @else
    {{ $guessLabel($attributes) }}
  @endHasSlot
  <div @class(['flex flex-col gap-0.5', 'w-full grow' => $fullWidth])>
    <input {{ $attributes->class([
          'rounded font-medium invalid:border-red-500 disabled:opacity-50 peer',
          'w-full' => $fullWidth,
        ])->merge([
          'type' => 'text',
        ])
    }} />
    {{ $slot }}
    @foreach($hints as $hint)
      <x-form.field-hint>{{ $hint }}</x-form.field-hint>
    @endforeach
    @unless($shouldHideErrors($attributes))
      <x-form.input-errors :messages="$messages" :fields="$getErrorBags($attributes)"/>
    @endunless
  </div>
</x-form.label>
