<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesDo;
use App\Models\DetailSalesDo;
use Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;


class DoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $do = SalesDo::orderBy('id')->where('id_user', Auth::id())->paginate(10);
        return view('do.index', compact('do'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $client1 = new Client();

        $api1 = 'https://gudangal.com/api/sales';

        $response1 = $client1->request('GET', $api1, [
            'verify'  => false,
        ]);

        $data1 = json_decode($response1->getBody());
        $sales = collect($data1);


        $client = new Client();

        $api = 'https://gudangal.com/api/kios';

        $response = $client->request('GET', $api, [
            'verify'  => false,
        ]);

        $data = json_decode($response->getBody());
        $kios = collect($data);
        return view('do.create', compact('kios','sales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $surat = SalesDo::orderBy('id', 'DESC')->first();
        if($surat){
            $kode = 'DO'.Auth::user()->kode.'-'.$surat->id + 1;
        }else{
            $kode = 'DO'.Auth::user()->kode.'-'.'1';

        }
        $do = New SalesDo;
        $do->sales = $request->sales;
        $do->kios = $request->kios;
        $do->id_user = Auth::id();
        $do->nomor_surat = $kode;
        $do->save();

        return redirect()->route('do.detailStore', $do->id);
    }

    public function detail_store($id){
        $do = SalesDo::find($id);
        $client1 = new Client();

        $api1 = 'https://gudangal.com/api/daftar-produk';

        $response1 = $client1->request('GET', $api1, [
            'verify'  => false,
        ]);

        $data1 = json_decode($response1->getBody());
        $produk = collect($data1);
        return view('do.form-detail-do', compact('do','produk'));
    }

    public function simpan_detail_store(Request $request, $id){


        $client1 = new Client();

        $api1 = 'https://gudangal.com/api/cari-produk/'.$request->produk;

        $response1 = $client1->request('GET', $api1, [
            'verify'  => false,
        ]);

        $data1 = json_decode($response1->getBody());
        $produk = collect($data1);

        $total = $request->dus * $produk['isi_perdus'] + $request->btl;

        $client = new Client();
        $url = "https://script.google.com/macros/s/AKfycbzcqV8Ae4s_ZKgYdufJmI1BBwwTxsV7hHmPP7Te7GfA_GhQFDhRVoed_MOuV3eFNdqc/exec?nama_produk=" . urlencode(strtolower($produk['nama']));

        // dd($url);

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $data = json_decode($response->getBody());
        $barang = collect($data);

        $laba = ($total * $request->harga) - ($total * $barang['harga']);

        // dd($barang['harga'], $url);
        
        $detail = New DetailSalesDo;
        $detail->produk = $produk['nama'];
        $detail->dus = $request->dus;
        $detail->btl = $request->btl;
        $detail->total = $total;
        $detail->id_sales_do = $id;
        $detail->harga = $request->harga;
        $detail->hpp = $barang['harga'];
        $detail->laba = $laba;
        $detail->save();

        return redirect()->back()->with('info', 'Barang do berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $detail = SalesDo::find($id);
        return view('do.detail', compact('detail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $detail = DetailSalesDo::find($id);
        $client1 = new Client();

        $api1 = 'https://gudangal.com/api/daftar-produk';

        $response1 = $client1->request('GET', $api1, [
            'verify'  => false,
        ]);

        $data1 = json_decode($response1->getBody());
        $produk = collect($data1);
        return view('do.edit', compact('detail','produk'));
    }

    public function edit2($id)
    {
        $detail = DetailSalesDo::find($id);
        $client1 = new Client();

        $api1 = 'https://gudangal.com/api/daftar-produk';

        $response1 = $client1->request('GET', $api1, [
            'verify'  => false,
        ]);

        $data1 = json_decode($response1->getBody());
        $produk = collect($data1);
        return view('do.edit-2', compact('detail','produk'));
    }

    public function update2(Request $request, $id)
    {
        // dd('di');
        $client1 = new Client();

        $api1 = 'https://gudangal.com/api/cari-produk/'.$request->produk;

        $response1 = $client1->request('GET', $api1, [
            'verify'  => false,
        ]);

        $data1 = json_decode($response1->getBody());
        $produk = collect($data1);

        $total = $request->dus * $produk['isi_perdus'] + $request->btl;

        $update = DetailSalesDo::find($id);
        $update->produk = $produk['nama'];
        $update->dus = $request->dus;
        $update->btl = $request->btl;
        $update->total = $total;
        $update->save();

        return redirect()->route('do.show', $update->do->id)->with('info', 'data do berhasil direvisi');
    }

    public function edit_kop_do($id)
    {
        $detail = SalesDo::find($id);

        $client1 = new Client();

        $api1 = 'https://gudangal.com/api/sales';

        $response1 = $client1->request('GET', $api1, [
            'verify'  => false,
        ]);

        $data1 = json_decode($response1->getBody());
        $sales = collect($data1);


        $client = new Client();

        $api = 'https://gudangal.com/api/kios';

        $response = $client->request('GET', $api, [
            'verify'  => false,
        ]);

        $data = json_decode($response->getBody());
        $kios = collect($data);
        return view('do.revisi-kop', compact('kios','sales','detail'));
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->produk);
        $client1 = new Client();

        $api1 = 'https://gudangal.com/api/cari-nama-barang/'.$request->produk;

        $response1 = $client1->request('GET', $api1, [
            'verify'  => false,
        ]);

        $data1 = json_decode($response1->getBody());
        $produk = collect($data1);

        // dd($produk['isi_perdus'], $request->produk);
        $total = $request->dus * $produk['isi_perdus'] + $request->btl;

        $client = new Client();
        $url = "https://script.google.com/macros/s/AKfycbzcqV8Ae4s_ZKgYdufJmI1BBwwTxsV7hHmPP7Te7GfA_GhQFDhRVoed_MOuV3eFNdqc/exec?nama_produk=" . urlencode(strtolower($produk['nama']));

        // dd($url);

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $data = json_decode($response->getBody());
        $barang = collect($data);

        $laba = ($total * $request->harga) - ($total * $barang['harga']);

        $update = DetailSalesDo::find($id);
        $update->produk = $produk['nama'];
        $update->dus = $request->dus;
        $update->btl = $request->btl;
        $update->total = $total;
        $update->harga = $request->harga;
        $update->hpp = $barang['harga'];
        $update->laba = $laba;
        $update->save();

        return redirect()->route('do.detailStore', $update->do->id)->with('info', 'data do berhasil direvisi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $update = DetailSalesDo::find($id);
        $update->delete();
        return redirect()->back();
        
    }

    public function update_kop(Request $request, $id){
        $update = SalesDo::find($id);
        $update->sales = $request->sales;
        $update->kios = $request->kios;
        $update->save();

        return redirect()->route('do.index')->with('info', 'Data Kop berhasil dirubah');
    }

    public function hapus_do($id){
        $hapus = SalesDo::find($id);

        $detail = DetailSalesDo::where('id_sales_do', $id)->get();
        foreach($detail as $hd){
            $hapus_detail = DetailSalesDo::find($hd->id);
            $hapus_detail->delete();
        }

        $hapus->delete();

        return redirect()->back()->with('info', 'Data sudah terhapus');
    }
}
