@extends('layouts.master')
@extends('components.sidebar')

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4" style="margin-top: 100px">
                <div class="row">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="card-body">
                                <div class="card-body">
                                    <form action="{{ route('letters.update', $letter->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-3">
                                            <label for="letter_perihal" class="form-label">Perihal</label>
                                            <input type="text" class="form-control" name="letter_perihal"
                                                value="{{ $letter->letter_perihal }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="klasifikasi" class="form-label">Klasifikasi</label>
                                            <select class="form-select" name="letter_type_id" id="klasifikasi">
                                                @foreach ($types as $letterType)
                                                    <option value="{{ $letterType->id }}"
                                                        {{ $letter->letter_type_id == $letterType->id ? 'selected' : '' }}>
                                                        {{ $letterType->name_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Isi Surat</label>
                                            <textarea class="form-control editor" name="content">
                                                {{ $letter->content }}
                                            </textarea>
                                        </div>
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <th>Nama</th>
                                                <th>Peserta(Ceklis jika ya)</th>
                                            </tr>
                                            @foreach ($gurus as $item)
                                                <tr>
                                                    <td>{{ $item->name }}</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="{{ $item->name }}" id="flexCheckChecked"
                                                                name="recipients[]"
                                                                {{ in_array($item->name, $letter->recipients) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Lampiran</label>
                                            <input class="form-control" type="file" id="formFile" name="attachment">
                                        </div>
                                        <div class="mb-3">
                                            <label for="klasifikasi" class="form-label">Notulis</label>
                                            <select class="form-select" name="notulis" id="klasifikasi">
                                                @foreach ($gurus as $i)
                                                    <option value="{{ $i->id }}"
                                                        {{ $letter->notulis == $i->id ? 'selected' : '' }}>
                                                        {{ $i->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-info text-white">Update</button>
                                    </form>
                                    <a href="{{ route('letters.index') }}" class="btn btn-danger">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
