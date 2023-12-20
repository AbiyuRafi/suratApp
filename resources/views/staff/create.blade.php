@extends('layouts.master')
@extends('components.sidebar')

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4"style="margin-top: 100px">
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
                                <form method="POST" action="{{ route('staff.storeStaff') }}" class="card p-5">
                                    <div class="mb-3 row">
                                        <h2>Buat Akun</h2>
                                        @csrf
                                        <label for="name" class="col-sm-2 col-form-label">Nama :</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" class="form-control" id="name"
                                                placeholder="Masukkan Nama" autofocus>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="email" class="col-sm-2 col-form-label">Email :</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="email" class="form-control" id="email"
                                                placeholder="Masukkan Email" autofocus>
                                        </div>
                                    </div>
                                    <input type="hidden" name="role" value="guru">
                                    <button type="submit" class="btn btn-secondary">Buat Akun</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
