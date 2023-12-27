@extends('pelanggan.layout.index')

@section('conten')
    <form action="{{ route('checkout.bayar') }}" method="POST">
        @csrf
        <div class="row mt-3">
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-body">
                        <h3>Masukan Alamat penerima</h3>

                        <div class="row mb-3">
                            <label for="nama_penerima" class="col-form-label col-sm-3">Nama penerima</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control col-sm-9" id="nama_penerima" name="namaPenerima"
                                    placeholder="Masukan Nama Penerima" autofocus required value="{{ Auth::user()->name }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tlp" class="col-form-label col-sm-3">No.tlp penerima</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control col-sm-9" id="tlp" name="tlp"
                                    placeholder="Masukan No Penerima" required value="{{ Auth::user()->tlp }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamat_penerima" class="col-form-label col-sm-3">Alamat Lengkap</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control " id="alamatPenerima" name="alamatpenerima"
                                    placeholder="Masukan Alamat Penerima" required value="{{ Auth::user()->alamat }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="provincy" class="col-form-label col-sm-3">Provinsi</label>
                            <div class="col-sm-9">
                                <select name="provincy" id="provincy" class="form-control" required oninvalid="this.setCustomValidity('Pilih Provinsi')" onchange="resetValidity(this)">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="destination" class="col-form-label col-sm-3">Kota</label>
                            <div class="col-sm-9">
                                <select name="destination" id="destination" class="form-control" required
                                    oninvalid="this.setCustomValidity('Pilih Kota')" onchange="resetValidity(this)">
                                    <option value="">Pilih Kota </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ekspedisi" class="col-form-label col-sm-3">Ekspedisi</label>
                            <div class="col-sm-9">
                                <select type="ekspedisi" class="form-control eksp" id="ekspedisi" name="ekspedisi" required
                                    oninvalid="this.setCustomValidity('Pilih Ekspedisi')" onchange="resetValidity(this)">
                                    <option value="">-- Pilih Ekspedisi --</option>
                                    <option value="pos">POS</option>
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="service" class="col-form-label col-sm-3">Pilih jasa</label>
                            <div class="col-sm-9">
                                <select name="service" id="service" class="form-control" required
                                    oninvalid="this.setCustomValidity('Pilih Jasa')" onchange="resetValidity(this)">
                                    <option value="">Pilih Jasa </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header text-center p-4">
                        <h3>Total Belanja</h3>
                    </div>
                    <div class="card-body pembayaran">
                        <h3>{{ $codeTransaksi }}</h3>
                        <input type="hidden" name="code" value="{{ $codeTransaksi }}">

                        <div class="row mb-3">
                            <label for="totalBelanja" class="col-form-label col-sm-6">Total Belanja</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control totalBelanja " id="totalBelanja"
                                    name="totalBelanja" placeholder="totalBelanja" value="{{ $detailBelanja }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="PPn" class="col-form-label col-sm-6">PPn</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control ppn" id="PPn" name="PPn" value="0" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ongkir" class="col-form-label col-sm-6">Ongkir</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control ongkir" id="ongkir" name="ongkir" value="0" readonly>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="row mb-3">
                            <label for="dibayarkan" class="col-form-label col-sm-6">Total</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control dibayarkan totalkan" id="dibayarkan"
                                    name="dibayarkan" value="0" readonly placeholder="dibayarkan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="dibayarkan" class="col-form-label col-sm-6">Jumlah Barang</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control dibayarkan" id="dibayarkan"
                                    name="jumlahBarang" value="{{ $jumlahbarang }}" readonly placeholder="dibayarkan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="dibayarkan" class="col-form-label col-sm-6">Total Quantity</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control dibayarkan" id="dibayarkan" name="totalQty"
                                    value="{{ $qtyOrder }}" readonly placeholder="dibayarkan">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">

                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        function resetValidity(selectElement) {
            // Hapus pesan kesalahan
            selectElement.setCustomValidity('');

            // Setel ulang validitas elemen
            selectElement.validity.valid = true;
            selectElement.validity.customError = false;
        }
        /**
         * get data provincy
         */
        $.ajax({
            url: '{{ route('rajaongkir.provinsi') }}',
            method: "GET",
            success: function(data) {
                var provincy = $("#provincy");
                data.forEach(element => {
                    provincy.append(
                        `<option value="${element.province_id}">${element.province}</option>`);
                });
            },
            failed: function(res) {

            }
        });

        /**
         * get data cities
         */
        function getCities(provincyId) {
            $.ajax({
                url: '{{ route('rajaongkir.kota') }}',
                method: "GET",
                data: {
                    'provincy_id': provincyId
                },
                success: function(data) {
                    var destination = $("#destination");
                    data.forEach(element => {
                        destination.append(
                            `<option value="${element.city_id}">${element.city_name}</option>`);
                    });
                },
                failed: function(res) {}
            });
        }

        /**
         * get data cost  
         */
        function getCosts(courier) {
            $.ajax({
                url: '{{ route('rajaongkir.cost') }}',
                method: "GET",
                data: {
                    'destination': $('#destination').val(),
                    'courier': courier
                },
                success: function(data) {

                    $("#service").empty();
                    $("#service").append(`<option value="">Pilih Jasa</option>`);
                    var costs = data[0]['costs'];
                    console.log(costs);
                    costs.forEach(cost => {
                        $("#service").append(
                            `<option value="${cost['cost'][0]['value']}">${cost["description"]}</option>`
                        );
                    });
                },
                failed: function(data) {

                }
            });
        }


        $(function() {
            /**
             * listen change provincy
             */
            $('#provincy').on('change', function() {
                $("#destination").empty();
                $("#destination").append(`<option value="">Pilih Kota</option>`);
                getCities($(this).val());
            });


            /**
             * listen change ekspedisi
             */
            $(".eksp").change(function(e) {
                e.preventDefault();
                var eksp = $(".eksp").val();
                getCosts(eksp);
            });

            /**
             * listen change service
             */
            $("#service").change(function(e) {
                e.preventDefault();
                var ongkir = $(".ongkir").val($(this).val());
                $(".pembayaran").each(function() {
                    var card = $(this);
                    var totalBelanja = card.find(".totalBelanja").val();
                    var totalPpn = parseInt(totalBelanja) * 0.11;
                    var ppn = card.find(".ppn").val(totalPpn);
                    var ongkir = card.find(".ongkir").val();
                    var subtotal = parseInt(totalBelanja) + parseInt(totalPpn);
                    var subtotal2 = parseInt(subtotal) + parseInt(ongkir);
                    console.log(subtotal2);
                    card.find(".totalkan").val(subtotal2);
                })
            });
        });
    </script>
@endsection
