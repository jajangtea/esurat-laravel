@extends('layouts.dashboard')

@section('title', 'Disposisi : ' . $disposition->reference_number)

@section('content')
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('disposition.' . $type) }}">Kembali</a></li>
    </ol>
    @component('components.card')
        @slot('title', $disposition->reference_number)
        <h5 class=" m-0"><span class="badge badge-primary badge-lg">{{ $disposition->dispositionRelation->from_user()->first()->name }}</span>
          <i class="fa fa-angle-right fa-md"></i>
        <span class="badge badge-success badge-lg">{{ $disposition->dispositionRelation->to_user()->first()->name }}</span>
        {{ $disposition->letter_type }}
        </h5>
        <h4 class="text-muted m-0">{{ $disposition->letterType()->get()->first()->name }}</h4>
        <p class="text-justify m-0">{{ $disposition->description }}</p>
        <hr>
        <label for="" class="control-label my-2">Pesan Disposisi dari {{ $disposition->dispositionRelation->disposition_message->user()->get()->first()->name }}</label>
        <textarea class="form-control" style="resize: none" readonly>{{ $disposition->dispositionRelation->disposition_message->message }}</textarea>
        <hr>
        <p class="small text-muted m-0">Lampiran</p>
        @if (sizeof($disposition->letterFiles()->get()) === 0)
            <h5 class="my-2 d-inline-block"><span class="badge rounded-pill badge-dark p-2">Tidak ada lampiran</span></h5>
        @endif
        <div class="row">
          @foreach ($disposition->letterFiles()->get() as $file)
              <div class="col-md-2">
                <div class="card border-0 shadow-sm">
                  <img src="{{ Storage::url('attachments/' . $file->file) }}" class="card-img-top" alt="">
                  @if ($file->name !== '')
                    <div class="card-body p-1">{{ $file->name }}</div>
                  @endif
                </div>
              </div>
          @endforeach
        </div>
    @endcomponent
    @if (Auth::user()->department->permissions['forward.' . $type])
    @component('components.card')
        @slot('title', 'Kirim Disposisi Ke')
        <div class="row">
          <div class="col-md-6">
            <form action="{{ route('disposition.forward', ['type' => $type, 'id' => $disposition->id]) }}" method="POST" class="form-group">
                @csrf
                <select name="to_user" id="" class="form-control">
                    <option value="">-- Pilih pengguna --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->department->name }}</option>
                    @endforeach
                </select>
                <label for="" class="control-label my-2">Pesan Tambahan</label>
                <input type="hidden" value="{{ $disposition->id }}" name="disposition_id">
                <textarea name="message" id="" rows="7" class="form-control" placeholder="Pesan Disposisi"></textarea>
                <hr>
                <button class="btn btn-outline-success">Kirim</button>
            </form>
          </div>
        </div>
    @endcomponent
    @endif
@endsection