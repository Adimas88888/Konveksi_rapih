<div class="modal fade" id="userTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addDataUser') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="nik" class="col-sm-5 col-form-label">NIK</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control-plaintext" id="nik" name="nik"
                                value="{{ $nik }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-5 col-form-label">Nama</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="nama" name="nama" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-5 col-form-label">Email</label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control" id="email" name="email" autocomplete="off" 
                                required oninvalid="this.setCustomValidity('Mohon masukkan alamat email')" 
                                oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-5 col-form-label">Password</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="password" name="password" autocomplete="off" required
                            oninvalid="this.setCustomValidity('Mohon masukkan password')" 
                            oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-5 col-form-label">Alamat</label>
                        <div class="col-sm-7">
                            <input type="alamat" class="form-control" id="alamat" name="alamat" required
                            oninvalid="this.setCustomValidity('Mohon masukkan alamat ')" 
                                oninput="setCustomValidity('')">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="tlp" class="col-sm-5 col-form-label">No HP</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="tlp" name="tlp" required
                            oninvalid="this.setCustomValidity('Mohon masukkan no hp')" 
                                oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="role" class="col-sm-5 col-form-label">Jabatan</label>
                        <div class="col-sm-7">
                            <select type="text" class="form-control" id="role" name="role" required
                            oninvalid="this.setCustomValidity('Mohon masukkan jabatan')" 
                                oninput="setCustomValidity('')">
                                <option value="">pilih Role</option>
                                <option value="1">Admin</option>
                                <option value="2">Member</option>
                            </select>
                            
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="foto" class="col-sm-5 col-form-label">Foto </label>
                        <div class="col-sm-7">
                            <input type="hidden" name="foto">
                            <img id="preview" class="mb-2" alt="" style="width: 100px;">
                            <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="foto"
                                name="foto" onchange="previuwImg()" required
                                oninvalid="this.setCustomValidity('Mohon masukkan foto')" 
                                oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
            </div>  
        </div>
    </div>
        <script>
            function previuwImg() {
                const foto = document.querySelector('#foto');
                const preview = document.querySelector('#preview');

                preview.style.display = 'block';

                const oFReader = new FileReader();
                oFReader.readAsDataURL(foto.files[0]);

                oFReader.onload = function(oFREven) {
                    preview.src = oFREven.target.result;
                }

            }
        </script>
