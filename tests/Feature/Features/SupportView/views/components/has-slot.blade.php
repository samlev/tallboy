@use(Illuminate\View\ComponentSlot)
@hasSlot($foo)
  has slot
@else
  @if(isset($foo) && $foo instanceof ComponentSlot)
    is empty slot
  @else
    is not slot
  @endif
@endHasSlot