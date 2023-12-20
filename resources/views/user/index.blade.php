@extends('layouts.master')
@extends('components.sidebar')

@section('content')
        <div class="mb-3 h3 mb-4">Hasil Rapat</div>
        <div class="card">
            <div class="card-body">

                <form action="{{ route('result.store') }}" method="POST">
                    @csrf
                    <div class="h5 mb-3">Hasil Rapat Perihal: {{ $letters->letter_perihal }}</div>

                    ID Surat<input type="text" class="form-control w-25 mb-3" value="{{ $letters->id }}"
                        name="letter_id">
                    <div class="h6">Peserta Yang Hadir</div>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Nama</th>
                            <th>Kehadiran</th>
                        </tr>
                        @foreach ($user as $item)
                            <tr>
                                <td>{{ $item->name }}</td>

                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $item->id }}"
                                            id="flexCheckChecked" name="presence_recipients[]">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="h6">Ringkasan Rapat:</div>
                    <div class="mb-3">
                        <textarea class="form-control" name="notes"></textarea>
                    </div>
                    <button type="submit" class="btn btn-info text-white">Tambah Hasil</button>
            </div>
        </div>
    </div>
    </form>
@endsection
