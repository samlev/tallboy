<div {{ $attributes->merge(['class' => 'text-xs text-gray-500 italic fle gap-x-1 items-center']) }}>
  <x-icon name="info" class="h-4"/>
  {{ $slot }}
</div>
