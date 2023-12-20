@extends('layouts.master')
@extends('components.sidebar')

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Klasifikasi Surat</h1>
                <div class="row">
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
                            <div class="table-responsive">
                                <a href="{{ route('klasifikasi.export') }}" class="btn btn-success">Export to Excel</a>
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#tambahModal" style="float: right; margin-left: 10px;">
                                    Tambah Data
                                </button>
                                <table id="datatablesSimple" class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Surat</th>
                                            <th>Klasifikasi Surat</th>
                                            <th>Surat Tertaut</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($letters as $let)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $let['letter_code'] }}</td>
                                                <td>{{ $let['name_type'] }}</td>
                                                <td>{{ App\Models\Letter::where('letter_type_id', $let->id)->count() }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#showModal{{ $let['id'] }}">Lihat</button>
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $let['id'] }}">Edit</button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $let['id'] }}">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    @if ($letters->count())
                                        {{ $letters->links() }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah klasifikasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('klasifikasi.store') }}" method="POST">
                        @csrf
                        <div class="form-floating">
                            <input type="text" name="letter_code" class="form-control">
                            <label for="user">Masukkan Kode Surat</label>
                            @error('letter_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <input type="text" name="name_type" class="form-control">
                            <label for="user">Masukkan Klasifikasi Surat</label>
                            @error('name_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <input type="hidden" name="role" value="guru">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($letters as $let)
        <div class="modal fade" id="editModal{{ $let['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit user</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('klasifikasi.update', $let['id']) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="letter_code" class="form-label">Kode Surat</label>
                                <input type="text" name="letter_code" class="form-control"
                                    value="{{ $let->letter_code }}">
                                @error('letter_code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name_type" class="form-label">Klasifikasi Surat</label>
                                <input type="text" name="name_type" class="form-control"
                                    value="{{ $let['name_type'] }}">
                                @error('name_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <input type="hidden" name="role" value="guru">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="showModal{{ $let['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <a href="{{ route('klasifikasi.print', $let['id']) }}" style="float: right;">
                            <i class='bx bxs-download'></i>
                        </a>
                        @if ($let->created_at)
                            @php
                                \Carbon\Carbon::setLocale('id_ID');
                            @endphp
                            {{ \Carbon\Carbon::parse($let->created_at)->translatedFormat('d F Y') }}
                            <br>
                        @endif
                        <p>Kode Surat: {{ $let['letter_code'] }}</p>
                        <p>Klasifikasi Surat: {{ $let['name_type'] }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="deleteModal{{ $let['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus data ini?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('klasifikasi.delete', $let['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
