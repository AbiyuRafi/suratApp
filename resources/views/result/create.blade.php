@extends('layouts.master')
@extends('components.sidebar')

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4" style="margin-top: 100px">
                <div class="row">
                    @if (Session::get('success'))
                        <div class="alert alert-primary" role="alert">{{ Session::get('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="card-body">
                                <form action="{{ route('result.store') }}" method="POST">
                                    @csrf
                                    {{-- Add a hidden input for ID Surat --}}
                                    <input type="hidden" name="letter_id" value="{{ $letters->first()->id }}">

                                    <div class="h6">Peserta Yang Hadir</div>
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Kehadiran</th>
                                        </tr>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $item->id }}" id="flexCheckChecked"
                                                            name="presence_recipients[]">
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
