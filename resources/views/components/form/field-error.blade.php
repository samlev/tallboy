<li {{ $attributes->merge(['class' => 'text-xs text-red-600 italic fle gap-x-1 items-center']) }}>
  <x-icon name="error" class="h-4"/>
  {{ $slot }}
</li>
