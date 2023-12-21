@extends('pelanggan.layout.index')

@section('conten')
    <div class="container mt-5 mb-5">
        <center>
            <h1>Edit Profile</h1>
        </center>
        <form action="{{ route('updateDataUser', $data->id) }}" enctype="multipart/form-data" method="POST">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-5 col-form-label">Nama :</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" autocomplete="off" value="{{ $data->name }}">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-5 col-form-label">Email :</label>
                    <div class="col-sm-7">
                        <input type="email" class="form-control" id="email" name="email" autocomplete="off"
                            value="{{ $data->email }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="alamat" class="col-sm-5 col-form-label">Alamat :</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="alamat" name="alamat"
                            value="{{ $data->alamat }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tlp" class="col-sm-5 col-form-label">Telphone :</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="tlp" name="tlp"
                            value="{{ $data->tlp }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tglLahir" class="col-sm-5 col-form-label">Tanggal lahir</label>
                    <div class="col-sm-7">
                        <input type="date" required title="('Kolom ini harus diisi')" class="form-control" id="tglLahir"
                            name="tglLahir" value="{{ $data->tglLahir }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="foto" class="col-sm-5 col-form-label">Foto Profil</label>
                    <div class="col-sm-7">
                        <input type="hidden" name="foto">
                        <img class="mb-2 preview" style="width: 100px;" src="{{ asset('storage/user/' . $data->foto) }}">
                        <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="inputFoto" name="foto"
                            onchange="previewImg()">
                    </div>
                </div>
            </div>

            <div class="modal-footer gap-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
    <script>
        function previewImg() {
            const fotoIn = document.querySelector('#inputFoto');
            const preview = document.querySelector('.preview');

            preview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(fotoIn.files[0]);

            oFReader.onload = function(oFREvent) {
                preview.src = oFREvent.target.result;
            }
        }
    </script>
    </div>
@endsection
