<optgroup label="{{ $group?->label ?? $label }}">
  @foreach($group?->options ?? [] as $option)
    <x-form.option :option="$option" />
  @endforeach
  {{ $slot }}
</optgroup>