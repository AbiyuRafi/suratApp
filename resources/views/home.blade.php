@extends('layouts.master')
@extends('components.sidebar')

@section('content')
    <style>
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            margin-bottom: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #003049;
            color: #ffffff;
            padding: 15px;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .card-text {
            color: #555555;
        }
    </style>

    <div id="layoutSidenav_content">
        <main>
            <h1 class="mt-4">Dashboard</h1>
            @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        @if (Session::get('isLogin'))
            <div class="alert alert-danger">
                {{ session::get('isLogin') }}
            </div>
        @endif
            <div class="row">
            </div>
            @if (Auth::check())
                @if (Auth::user()->role == 'staff')
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-envelope-open-text me-1"></i>
                                        Surat Keluar
                                    </div>
                                    <div class="card-body">
                                        <center>
                                            <h4>{{ $letters }}</h4>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-users me-1"></i>
                                        Staff Tata Usaha
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ $staff }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-users me-1"></i>
                                        Guru
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ $guru }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-file-alt me-1"></i>
                                        Klasifikasi Surat
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ $letterTypes }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-3">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-file-alt me-1"></i>
                                Surat Masuk
                            </div>
                            <div class="card-body">
                                <h4>{{ $notulis}}</h4>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </main>
    </div>
@endsection
