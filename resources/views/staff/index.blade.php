@extends('layouts.master')
@extends('components.sidebar')

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="row">
                    <h1 class="mt-4">Data Staff Tata Usaha</h1>
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
                            <a href="{{ route('staff.create') }}" class="btn btn-primary">Tambah Data</a>
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1 @endphp
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>
                                                <button class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $user->id }}">Edit
                                                </button>
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $user->id }}">Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        {{ $users->links() }}
                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah user</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('staff.storeStaff') }}" method="POST">
                                        @csrf
                                        <div class="form-floating">
                                            <input type="text" name="name" class="form-control mt-2" id="name"
                                                placeholder="Masukkan Nama" autofocus>
                                            <label for="user">Masukkan Nama</label>
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-floating">
                                            <input type="text" name="email" class="form-control mt-2" id="email"
                                                placeholder="Masukkan Email" autofocus>
                                            <label for="user">Masukkan Email</label>
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="role" value="guru">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Tambah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach ($users as $user)
                        <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form action="{{ route('staff.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-floating">
                                                <input type="text" name="name" class="form-control mt-2"
                                                    id="name" value="{{ $user->name }}" required>
                                                <label for="name">Nama</label>
                                            </div>
                                            <div class="form-floating">
                                                <input type="text" name="email" class="form-control mt-2"
                                                    id="email" value="{{ $user->email }}" required>
                                                <label for="email">Email</label>
                                            </div>
                                            <div class="form-floating">
                                                <input type="password" name="password" class="form-control mt-2"
                                                    id="password">
                                                <label for="password">Password</label>
                                            </div>
                                            <input type="hidden" name="role" value="staff">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus data ini?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('staff.delete', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <footer class="py-4 bg-light mt-auto">
                        <div class="container-fluid px-4">
                            <div class="d-flex align-items-center justify-content-between small">
                                <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            </div>
                        </div>
                    </footer>
        </main>
    </div>
@endsection
