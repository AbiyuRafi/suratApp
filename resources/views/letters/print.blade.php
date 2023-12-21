<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #letter-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1,
        h3,
        h5,
        h6 {
            text-align: center;
            padding-right: 200px;
        }

        .text-header {
            float: left;
            margin-left: 20px;
            /* Adjust the margin as needed */
        }

        .row {
            margin-top: 20px;
        }

        .kecLogo {
            margin-left: 20px;
            font-size: 15px;
        }

        .kablogo {
            margin-right: 20px;
            font-size: 2vw;
        }

        .alamatlogo {
            font-size: 1.5vw;
        }

        .kodeposlogo {
            font-size: 1.7vw;
        }

        #tls {
            text-align: right;
        }

        .alamat-tujuan {
            margin-left: 60%;
        }

        .garis1 {
            border-top: 3px solid black;
            height: 2px;
            border-bottom: 1px solid black;
            margin-top: 20px;
        }

        #logo {
            margin: auto;
            display: block;
            margin-bottom: 20px;
        }

        #tempat-tgl {
            margin-left: 20px;
        }

        #camat {
            text-align: center;
        }

        #nama-camat {
            margin-top: 20px;
            text-align: center;
        }

        #img {
            float: left;
        }
    </style>
</head>

<body>
    <a href="{{ route('letters.download', $letters['id']) }}" class="btn-print">Cetak (.pdf)</a>
    <div id="letter-container">
        <header>
            <div class="row">
                <div id="img" class="col-md-3">
                    <img id="logo" src="{{ asset('assets/img/logo.png') }}" width="110" height="110" />
                </div>
                <div id="text-header" class="col-md-9">
                    <h3 class="kablogo">SMK Wikrama Bogor</h3>
                    <p class="kecLogo">Manajemen dan bisnis <br>
                        Teknik Informasi dan Komunikasi <br>Pemasaran</p>
                    <h6 class="alamatlogo">Jl. Soekarno-Hatta, No. 68, Telepon/Faximile (0298) 523024</h6>
                    <h5 class="kodeposlogo"><strong>BERGAS 50552</strong></h5>
                </div>
            </div>
        </header>
        <div class="container">
            <hr class="garis1" />
            <div id="alamat" class="row">
                <div id="lampiran" class="col-md-6">
                    Nomor : {{ $letters->letter_types ? $letters->letter_types->letter_code : '-' }}/SMK Wikrama/XII/2023 <br />
                    Perihal : {{ $letters->letter_perihal ?? '-' }}                    
                </div>
                <div id="tgl-srt" class="col-md-6">
                    <p id="tls">Bergas, 30 April 2018</p>

                    <p class="alamat-tujuan">Kepada <br>Yth. Bapak/Ibu Terlampir<br />
                    </p>
                    <p class="alamat-tujuan">Ditempat
                    </p>
                </div>
            </div>
            
        <div id="pembuka" class="row">&emsp; &emsp; &emsp; {!! $letters['content'] !!}</div>
            <div id="ttd" class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <p id="camat"><strong> Hormat kami</strong></p>
                    <div id="nama-camat"><strong><u>Kepala SMK Wikrama</u></strong><br />
                        <br />
                        <br>
                        <br>
                        <br>
                    (........)    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
