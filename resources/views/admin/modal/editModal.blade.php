<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('updateData', $data->id)}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="SKU" class="col-sm-5 col-form-label">SKU</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control-plaintext" id="SKU" name="sku"
                            value=" {{ $data->sku }}" readonly>

                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nameProduct" class="col-sm-5 col-form-label">Nama Product</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="namaProduct" name="nama_product"
                            value="{{ $data->nama_product }}">

                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="type" class="col-sm-5 col-form-label">Tipe Product</label>
                    <div class="col-sm-7">
                        <select type="text" class="form-control" id="type" name="type">
                            <option value="">pilih Type</option>
                            <option value="celana" {{ $data->type === 'celana' ? 'selected' : '' }}>Celana</option>
                            <option value="baju"{{ $data->type === 'baju' ? 'selected' : '' }}>Baju</option>
                            <option value="aksesoris"{{ $data->type === 'aksesoris' ? 'selected' : '' }}>Aksesoris
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="kategori" class="col-sm-5 col-form-label">Kategori </label>
                    <div class="col-sm-7">
                        <select type="text" class="form-control" id="kategori" name="kategory">
                            <option value="">pilih kategori</option>
                            <option value="Pria"{{ $data->kategory === 'Pria' ? 'selected' : '' }}>Pria</option>
                            <option value="Wanita"{{ $data->kategory === 'Wanita' ? 'selected' : '' }}>Wanita</option>
                            <option value="Anak-anak"{{ $data->kategory === 'Anak-anak' ? 'selected' : '' }}>Anak-anak
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="harga" class="col-sm-5 col-form-label">Harga Product</label>
                    <div class="col-sm-7">
                        <input type="number" class="form-control" id="harga" name="harga"
                            value="{{ $data->harga }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="quantity" class="col-sm-5 col-form-label">quantity</label>
                    <div class="col-sm-7">
                        <input type="number" class="form-control" id="quantity" name="quantity"
                            value="{{ $data->quantity }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="foto" class="col-sm-5 col-form-label">Foto Product</label>
                    <div class="col-sm-7">
                        <input type="hidden" name="foto" value="{{$data->foto}}">
                        <img src="{{ asset('storage/product/' . $data->foto) }}" id="preview" class="mb-2"
                            alt="" style="width: 100px;">
                        <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="foto"
                            name="foto" onchange="previuwImg()">
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
