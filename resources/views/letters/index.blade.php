@extends('layouts.master')
@extends('components.sidebar')

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="row">
                    <h1 class="mt-4">Data Surat</h1>
                    @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('deleted'))
                        <div class="alert alert-warning" role="alert">{{ Session::get('deleted') }}</div>
                    @endif
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Total Data
                        </div>
                        <div class="card-body">
                            @if (Auth::check())
                                @if (Auth::user()->role == 'guru')
                                    <a href="{{ route('result.export') }}" class="btn btn-success">Export</a>
                                @endif
                            @endif
                            @if (Auth::check())
                                @if (Auth::user()->role == 'staff')
                                    <a href="{{ route('letters.export') }}" class="btn btn-success">Export</a>
                                    <a href="{{ route('letters.create') }}" class="btn btn-primary">Tambah Data</a>
                                @endif
                            @endif
                            <table class="table">
                                <thead>
                                    <th>No</th>
                                    <th>No Surat</th>
                                    <th>Perihal</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Penerima Surat</th>
                                    <th>Notulis</th>
                                    <th>Hasil Rapat</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($letters as $key => $letter)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ $letter->letter_types ? $letter->letter_types->letter_code : '-' }}/000{{ $letter->id }}/SMK
                                                Wikrama/{{ romawi($letter->created_at->format('m')) }}I/{{ $letter->created_at->format('Y') }}

                                            </td>
                                            <td>{{ $letter->letter_perihal }}</td>
                                            <td>
                                                @php
                                                    \Carbon\Carbon::setLocale('id_ID');
                                                @endphp
                                                {{ \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{ implode(', ', $letter->recipients) }}</td>
                                            <td>{{ $letter['user']['name'] }}</td>
                                            <td>
                                                @if (Auth::check())
                                                    @if (App\Models\Result::where('letter_id', $letter->id)->exists())
                                                        <span class="text-success">Sudah dibuat</span>
                                                    @else
                                                        <span class="text-danger">Belum dibuat</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if (Auth::check())
                                                    @if (Auth::user()->role == 'staff')
                                                        <a href="{{ route('letters.edit', $letter['id']) }}"
                                                            class="btn btn-primary">Edit</a>
                                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal-{{ $letter->id }}">Delete</button>
                                                        @if (App\Models\Result::where('letter_id', $letter->id)->exists())
                                                            <a href="{{ route('letters.print', $letter['id']) }}"
                                                                class="btn btn-info text-white">Lihat Hasil Rapat</a>
                                                        @endif
                                                    @elseif (Auth::user()->role == 'guru')
                                                        @if (App\Models\Result::where('letter_id', $letter->id)->exists())
                                                            <a href="{{ route('result.print', $letter['id']) }}"
                                                                class="btn btn-success">Lihat Hasil Rapat</a>
                                                        @else
                                                            <a href="{{ route('result.create', $letter->id) }}"
                                                                class="btn btn-success">Buat Hasil Rapat</a>
                                                        @endif
                                                    @else
                                                        <span class="text-info">Hanya melihat</span>
                                                    @endif
                                                @endif
                                            </td>

                                            </td>
                                            <td>
                                                <div class="modal fade" id="deleteModal-{{ $letter->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                    Konfirmasi
                                                                    Hapus</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah Anda yakin ingin menghapus data ini?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <form action="{{ route('letters.delete', $letter->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{ $letters->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
