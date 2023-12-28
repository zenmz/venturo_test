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
                                        <td style="text-align: right;">
                                            {{ isset($perBulan[$menu][$item]) ? $perBulan[$menu][$item] : '' }}
                                        </td>
                                    @endforeach
                                    @php
                                        $allTotal += $total;
                                    @endphp
                                    <td style="text-align: right;"><b>{{ $total }}</b></td>
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
                                        <td style="text-align: right;">
                                            {{ isset($perBulan[$menu][$item]) ? $perBulan[$menu][$item] : '' }}
                                        </td>
                                    @endforeach
                                    @php
                                        $allTotal += $total;
                                    @endphp
                                    <td style="text-align: right;"><b>{{ $total }}</b></td>
                                </tr>
                            @endforeach


                            <tr class="table-dark">
                                <td><b>Total</b></td>
                                @foreach ($allBulan as $item)
                                    <td style="text-align: right;">
                                        <b>{{ $totalBulan[$item] != 0 ? $totalBulan[$item] : '' }}</b>
                                    </td>
                                @endforeach
                                <td style="text-align: right;"><b>{{ $allTotal }}</b></td>
                            </tr>
                        </tbody>
                    </table>
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


</body>

</html>
