<div>
  @isset($title)
  <header {{ $title->attributes->merge(['foo' => 'bar']) }}>
    {{ $title }}
  </header>
  @else
    <header>
      Child Title
    </header>
  @endisset
  <main {{ $attributes->merge(['fizz' => 'buzz']) }}>
    {{ $slot }}
  </main>
</div>