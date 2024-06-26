<option {{ $attributes->merge($option?->attributes()?->all() ?? ['value' => ($value !== $label ? $value : false)]) }}>
  {{ $option?->label ?? $option?->value ?? $label ?? $value ?? $slot }}
</option>