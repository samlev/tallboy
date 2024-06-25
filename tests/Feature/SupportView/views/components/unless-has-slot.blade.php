@use(Illuminate\View\ComponentSlot)
@unlessHasSlot($foo)
  @if(isset($foo) && $foo instanceof ComponentSlot)
    is empty slot
  @else
    is not slot
  @endif
@else
  has slot
@endHasSlot