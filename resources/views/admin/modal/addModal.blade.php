<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addData') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="SKU" class="col-sm-5 col-form-label">SKU</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control-plaintext" id="SKU" name="sku"
                                value="{{ $sku }}" readonly required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nameProduct" class="col-sm-5 col-form-label">Nama Product</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="namaProduct" name="nama_product"required
                            oninvalid="this.setCustomValidity('Mohon masukkan Nama Product')" 
                                oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="type" class="col-sm-5 col-form-label">Tipe Product</label>
                        <div class="col-sm-7">
                            <select type="text" class="form-control" id="type" name="type" required
                            oninvalid="this.setCustomValidity('Mohon masukkan Tipe Product')" 
                            oninput="setCustomValidity('')">
                                <option value="">pilih Type</option>
                                <option value="celana">Celana</option>
                                <option value="baju">Baju</option>
                                <option value="aksesoris">Aksesoris</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="kategori" class="col-sm-5 col-form-label">Kategori </label>
                        <div class="col-sm-7">
                            <select type="text" class="form-control" id="kategori" name="kategory" required
                            oninvalid="this.setCustomValidity('Mohon masukkan Nama kategori')" 
                            oninput="setCustomValidity('')">
                                <option value="">pilih kategori</option>
                                <option value="pria">Pria</option>
                                <option value="Wanita">Wanita</option>
                                <option value="Anak-anak">Anak-anak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="harga" class="col-sm-5 col-form-label">Harga Product</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="harga" name="harga" value="" required
                            oninvalid="this.setCustomValidity('Mohon masukkan Harga Product')" 
                            oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="quantity" class="col-sm-5 col-form-label">quantity</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="quantity" name="quantity" value="" required
                            oninvalid="this.setCustomValidity('Mohon masukkan Jumlah Quantity')" 
                            oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-5 col-form-label">Foto Product</label>
                        <div class="col-sm-7">
                            <input type="hidden" name="foto">
                            <img id="preview" class="mb-2"
                                alt="" style="width: 100px;">
                            <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="foto"
                                name="foto" onchange="previuwImg()" required
                                oninvalid="this.setCustomValidity('Mohon masukkan Foto')" 
                                oninput="setCustomValidity('')">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
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