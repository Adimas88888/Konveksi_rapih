@extends('pelanggan.layout.index')

@section('conten')
<div class="container mt-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="content-text">
                <p>Konveksi Rapih adalah perusahaan yang mendefinisikan kualitas dan ketelitian dalam pembuatan pakaian. Dengan perpaduan antara kreativitas desain dan ketepatan dalam setiap jahitan, kami menghasilkan produk-produk fashion yang tidak hanya memukau secara visual, tetapi juga memberikan kenyamanan maksimal kepada pelanggan. Setiap potongan kain dan detail dirancang dan diproduksi dengan penuh perhatian, menjadikan setiap pakaian dari Konveksi Rapih sebagai simbol keanggunan, keindahan, dan kepercayaan diri.</p>
            </div>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('asset/img/sp.png') }}" alt="baju 1" style="width: 100%;">
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex flex-column">
                    <div class="mb-2"><i class="fa-solid fa-envelope"></i> koveksi_rapih@gmail.com</div>
                    <div class="mb-2"><i class="fa-brands fa-square-whatsapp"></i> 081337750165</div>
                    <div><i class="fa-brands fa-square-instagram"></i> @konveksirapih</div>
                </div>
            </div>
        </div>
    </div>
    

@endsection
