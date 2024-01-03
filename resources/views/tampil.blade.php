@isset($_GET['tahun'])
    @php
        $menu = json_decode(file_get_contents('http://tes-web.landa.id/intermediate/menu'));
        $transaksi = json_decode(file_get_contents('http://tes-web.landa.id/intermediate/transaksi?tahun=' . $_GET['tahun']));
    @endphp
@endisset
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        td,
        th {
            font-size: 11px;
        }
    </style>


    <title>TES - Venturo Camp Tahap 2</title>
</head>

<body>
    <div class="container-fluid">
        <div class="card" style="margin: 2rem 0rem;">
            <div class="card-header">
                Venturo - Laporan penjualan tahunan per menu
            </div>
            <div class="card-body">
                <form action="{{ route('laporan.index') }}" method="get">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select id="my-select" class="form-control" name="tahun">
                                    <option value="">Pilih Tahun</option>
                                    <option value="2021" @selected($tahun == 2021)>2021</option>
                                    <option value="2022" @selected($tahun == 2022)>2022</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">
                                Tampilkan
                            </button>
                            <a href="http://tes-web.landa.id/intermediate/menu" target="_blank" rel="Array Menu"
                                class="btn btn-secondary">
                                Json Menu
                            </a>
                            <a href="http://tes-web.landa.id/intermediate/transaksi?tahun=2021" target="_blank"
                                rel="Array Transaksi" class="btn btn-secondary">
                                Json Transaksi
                            </a>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table">
                    <table class="table table-hover table-bordered" style="margin: 0;">
                        <thead>
                            <tr class="table-dark">
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">Menu
                                </th>
                                <th colspan="12" style="text-align: center;">Periode Pada {{ $tahun }}
                                </th>
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total
                                </th>
                            </tr>
                            <tr class="table-dark">
                                @foreach ($allBulan as $item)
                                    <th style="text-align: center;width: 75px;">{{ $item }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalBulan = array_fill_keys($allBulan, 0);
                                $allTotal = 0;
                            @endphp
                            <tr>
                                <td class="table-secondary" colspan="14"><b>Makanan</b></td>
                            </tr>
                            @foreach ($makanan as $menu)
                                @php
                                    $total = 0;
                                @endphp
                                <tr>
                                    <td>{{ $menu }}</td>
                                    @foreach ($allBulan as $item)
                                        @php
                                            $price = $perBulan[$menu][$item] ?? 0;
                                            $total += $price;
                                            $totalBulan[$item] += $price;
                                        @endphp
                                        <td style="text-align: right;"
                                            onclick="detail('{{ $menu }}', '{{ $item }}')">
                                            {{ isset($perBulan[$menu][$item]) ? $perBulan[$menu][$item] : '' }}
                                        </td>
                                    @endforeach
                                    @php
                                        $allTotal += $total;
                                    @endphp
                                    <td style="text-align: right;" onclick="detail('{{ $menu }}')"><b>{{ $total }}</b></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="table-secondary" colspan="14"><b>Minuman</b></td>
                            </tr>
                            @foreach ($minuman as $menu)
                                @php
                                    $total = 0;
                                @endphp
                                <tr>
                                    <td>{{ $menu }}</td>
                                    @foreach ($allBulan as $item)
                                        @php
                                            $price = $perBulan[$menu][$item] ?? 0;
                                            $total += $price;
                                            $totalBulan[$item] += $price;
                                        @endphp
                                        <td style="text-align: right;"
                                            onclick="detail('{{ $menu }}', '{{ $item }}')">
                                            {{ isset($perBulan[$menu][$item]) ? $perBulan[$menu][$item] : '' }}
                                        </td>
                                    @endforeach
                                    @php
                                        $allTotal += $total;
                                    @endphp
                                    <td style="text-align: right;" onclick="detail('{{ $menu }}')"><b>{{ $total }}</b></td>
                                </tr>
                            @endforeach


                            <tr class="table-dark">
                                <td><b>Total</b></td>
                                @foreach ($allBulan as $item)
                                    <td style="text-align: right;" onclick="detail(null, '{{ $item }}')">
                                        <b>{{ $totalBulan[$item] != 0 ? $totalBulan[$item] : '' }}</b>
                                    </td>
                                @endforeach
                                <td style="text-align: right;"><b>{{ $allTotal }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Penjualan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @isset($menu)
                <div class="row m-3">
                    <div class="col-6">
                        <h4>Isi Json Menu</h4>
                        <pre style="height: 400px; background:#eaeaea;"><?php var_dump($menu); ?></pre>
                    </div>
                    <div class="col-6">
                        <h4>Isi Json Transaksi</h4>
                        <pre style="height: 400px; background:#eaeaea;"><?php var_dump($transaksi); ?></pre>
                    </div>
                </div>
            @endisset --}}

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function detail(menu, bulan= null) {
            const queryString = window.location.search;
            const params = new URLSearchParams(queryString);
            const tahun = params.get('tahun');

            $('#modal-body').empty()

            $.ajax({
                type: "get",
                url: "/laporan",
                data: {
                    menu: menu,
                    bulan: bulan,
                    tahun: tahun
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $('#exampleModal').modal('show');
                    if (response.length === 0) {
                        $('#modal-body').append('<h5>Data tidak tersedia<h5>');
                    } else {
                        $('#modal-body').append(
                            `<table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Nominal</th>
                                </tr>
                            </thead>
                            <tbody id='table-body'>
                                
                                
                            </tbody>
                        </table>`
                        );
                        $('#table-body').append(
                            response.map((v, e) => {
                                return `<tr>
                            <td>${v.tanggal}</td>
                            <td>${v.menu}</td>
                            <td>${v.total}</td>
                            </tr>`
                            })
                        );
                    }
                }
            });
        }
    </script>


</body>

</html>
