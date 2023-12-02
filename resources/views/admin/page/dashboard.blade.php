@extends('admin.layout.index')

@section('content')
    <div class="card p-5">
        <div class="row">
            <div class="col">
                <div class="card p-8">
                    <h5>BARANG</h5>
                    <div id="chartLine"></div>
                </div>
            </div>
            <div class="col">
                <div class="card p-8">
                    <h5>TRANSAKSI</h5>
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
