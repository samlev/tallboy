@props(['title' => 'Parent Title'])
<x-test::child {{ $attributes->merge(['bing' => 'bang']) }}>
  @slot('title', attributes: [... attrs($title)->merge(['baz' => 'quo'])])
    {{ $title }}
  @endslot
  {{ $slot }}
</x-test::child>