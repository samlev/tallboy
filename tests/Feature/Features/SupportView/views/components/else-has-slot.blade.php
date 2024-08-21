@use(Illuminate\View\ComponentSlot)
@if(false)
  False is true
@elseHasSlot($foo)
  has slot
@else
  @if(isset($foo) && $foo instanceof ComponentSlot)
    is empty slot
  @else
    is not slot
  @endif
@endif