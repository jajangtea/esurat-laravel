<div class="card my-2 shadow-sm border-0">
    <div class="card-body">
      <a href="{{ route('disposition.showtype', ['id' => $id,'type' => $type]) }}"><p class="m-0">{{ $title }}</p></a>
      <hr>
      {{ $slot }}
    </div>
  </div>