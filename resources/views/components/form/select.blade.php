@use(Tallboy\View\Data\Options\OptGroupData)
<x-form.label
  :attributes="attrs($label)->class(['w-full' => $fullWidth, 'flex-col' => $stacked, 'items-stretch' => $fullWidth && $stacked])">
  @hasSlot($label)
  {{ $label }}
  @else
    {{ $label() }}
    @endHasSlot
    <div @class(['flex flex-col gap-0.5', 'w-full grow' => $fullWidth])>
      <select {{ $attributes->class(['font-medium rounded invalid:border-red-500 disabled:opacity-50', 'w-full' => $fullWidth, 'multiple' => $multiple]) }}>
        {{ $slot }}
        @foreach($selectOptions as $option)
          @if($option instanceof OptGroupData)
            <x-form.opt-group :group="$option"/>
          @else
            <x-form.option :option="$option"/>
          @endif
        @endforeach
      </select>
      @hasSlot($after)
      {{ $after }}
      @endHasSlot
      @foreach($getHints() as $hint)
        <x-form.field-hint>{{ $hint }}</x-form.field-hint>
      @endforeach
      @if($showErrors && ($errors->hasAny($getErrorBags()) || $messages))
        <x-form.input-errors :messages="$messages" :fields="$getErrorBags()"/>
      @endif
    </div>
</x-form.label>
