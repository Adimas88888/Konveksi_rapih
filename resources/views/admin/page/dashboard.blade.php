@extends('admin.layout.index')

@section('content')
    <div class="container mt-4 ">
        <div class="row">
            <!-- Widget Total Barang -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Barang</h5>
                        <p class="card-text" id="totalBarangWidget">{{$Product}}</p>
                    </div>
                </div>
            </div>

            <!-- Widget Total Transaksi -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Transaksi</h5>
                        <p class="card-text" id="totalTransaksiWidget">{{$Transaksi}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <!-- Widget Total User -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Pelanggan</h5>
                        <p class="card-text" id="totalUserWidget">{{$User}}</p>
                    </div>
                </div>
            </div>

            <!-- Widget Nominal Transaksi -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Nominal Transaksi</h5>
                        <p class="card-text" id="nominalTransaksiWidget">
                            Rp {{ number_format($total_transaksi) }}
                        </p>
                    </div>
                </div>
            </div>
            
    <div class="container-fluid mt-4">
        <!-- Chart Widget for Barang -->
        <h5>BARANG</h5>
        <div class="row">
            <div class="col">
                <div class="card p-3 mb-2">
                    <div id="chartLine"></div>
                </div>
            </div>
        </div>

        <!-- Chart Widget for Transaksi -->
        <h5>TRANSAKSI</h5>
        <div class="row">
            <div class="col">
                <div class="card p-3 mb-2">
                    <div id="chartNeli"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // grafik barang
        $.ajax({
            url: "{{ route('chart') }}",
            type: "GET",
            success: function(res) {
                console.log(res);
                chartLine1(res.categories, res.series);
            },
            error: function(err) {
                console.log(err);
            }
        });

        function chartLine1(categories, series) {
            var options = {
                chart: {
                    height: 400,
                    type: 'line'
                },

                series: [{
                    name: 'Jumlah',
                    data: series
                }],
                xaxis: {
                    categories: categories
                }
            }

            var chart = new ApexCharts(document.querySelector("#chartLine"), options);

            chart.render();
        }

        // grafik transaksi
        $.ajax({
            url: "{{ route('chart2') }}",
            type: "GET",
            success: function(res) {
                console.log(res);
                chartLine2(res.categories, res.series);
            },
            error: function(err) {
                console.log(err);
            }
        });

        function chartLine2(categories, series) {
            var options = {
                chart: {
                    height: 400,
                    type: 'line'
                },
                series: [{
                    name: 'Jumlah',
                    data: series
                }],
                xaxis: {
                    categories: categories
                }
            }

            var chart = new ApexCharts(document.querySelector("#chartNeli"), options);

            chart.render();
        }
    </script>
@endsection
