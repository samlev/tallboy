@if($allErrors($errors) || $slot->isNotEmpty())
  <ul {{ $attributes->merge(['class' => 'text-xs text-red-600 space-y-1 list-none list-inside peer-disabled:hidden']) }}>
    @foreach ($allErrors($errors) as $message)
      <x-form.field-error>{{ $message }}</x-form.field-error>
    @endforeach
    {{ $slot }}
  </ul>
@endif