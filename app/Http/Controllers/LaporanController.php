<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tahun = $request->tahun;
        $inputMenu = $request->menu;
        $inputBulan = $request->bulan;

        $transaksi = Http::get("https://tes-web.landa.id/intermediate/transaksi?tahun=$tahun")->json();
        $menu = Http::get('https://tes-web.landa.id/intermediate/menu')->json();
        $makanan = collect($menu)->where('kategori', 'makanan')->values()->pluck('menu')->toArray();
        $minuman = collect($menu)->where('kategori', 'minuman')->values()->pluck('menu')->toArray();

        $perBulan = [];
        $allBulan = [];

        for ($i = 1; $i <= 12; $i++) {
            $allBulan[] = Carbon::create(null, $i, 1)->format('M');
        }
        // $c = collect($transaksi)->where('menu', 'Nasi Goreng')->whereBetween('tanggal', ['2021-01-01', '2021-01-31']);
        // dd($c);

        try {
            foreach ($transaksi as $key => $value) {
                $bulan = Carbon::parse($value['tanggal'])->format('M');

                if (!isset($perBulan[$value['menu']][$bulan])) {
                    $perBulan[$value['menu']][$bulan] = 0;
                }

                $perBulan[$value['menu']][$bulan] += $value['total'];
            }
        } catch (\Throwable $th) {
        }

        // if (isset($menu)) {
        if ($request->ajax()) {
            if (isset($inputMenu) && isset($inputBulan)) {
                $month = array_keys($allBulan, $inputBulan);
                $intBulan = $month[0] + 1;
                $tanggal = "$tahun-0$intBulan";
                $filter = collect($transaksi)->where('menu', $inputMenu)->whereBetween('tanggal', ["$tanggal-01", "$tanggal-31"])->values();
            } else if (!isset($inputBulan)) {
                $filter = collect($transaksi)->where('menu', $inputMenu)->whereBetween('tanggal', ["$tahun-01-01", "$tahun-12-31"])->values();
            }elseif (!isset($inputMenu)) {
                $month = array_keys($allBulan, $inputBulan);
                $intBulan = $month[0] + 1;
                $tanggal = "$tahun-0$intBulan";
                $filter = collect($transaksi)->whereBetween('tanggal', ["$tanggal-01", "$tanggal-31"])->values();
            }

            return json_encode($filter);
        }

        // dd(array_keys($allBulan, 'Jan'));
        return view('tampil', compact('perBulan', 'allBulan', 'makanan', 'minuman', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
