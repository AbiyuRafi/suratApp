@extends('layouts.master')
@extends('components.sidebar')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulir Surat</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@2/dist/tinymce-jquery.min.js"></script>
    </head>

    <body>
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
                                    <div class="card-body">
                                        <form action="{{ route('letters.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="letter_perihal" class="form-label">Perihal</label>
                                                <input type="text" class="form-control" name="letter_perihal">
                                            </div>
                                            <div class="mb-3">
                                                <label for="klasifikasi" class="form-label">Klasifikasi</label>
                                                <select class="form-select" name="letter_type_id" id="klasifikasi">
                                                    @foreach ($types as $letterType)
                                                        <option value="{{ $letterType->id }}">{{ $letterType->name_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="content" class="form-label">Isi Surat</label>
                                                <textarea class="form-control editor" name="content"></textarea>
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
                                                                    name="recipients[]">
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
                                                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-info text-white">Tambah</button>
                                        </form>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        tinymce.init({
                                            selector: '.editor',
                                            height: 150,
                                            menubar: false,
                                            plugins: [
                                                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                                                'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
                                                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
                                            ],
                                            toolbar: 'undo redo | blocks | bold italic backcolor | ' +
                                                'alignleft aligncenter alignright alignjustify | ' +
                                                'bullist numlist outdent indent | removeformat | help'
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>

    </html>
