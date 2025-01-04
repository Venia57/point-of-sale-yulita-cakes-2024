<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->orderBy('created_at', 'desc')->get();
        return view('pages.kasir', compact('produks'));
    }

    public function addProduct(Request $request)
    {
        $harga = $request->input('harga');
        $diskon = $request->input('diskon');
        $jumlah = 1; // Default jumlah awal

        // Hitung subtotal setelah diskon
        $subtotal = ($harga * $jumlah) - ($harga * $jumlah * $diskon / 100);

        $product = [
            'id' => $request->input('id'),
            'nama' => $request->input('nama'),
            'harga' => $harga,
            'diskon' => $diskon,
            'jumlah' => $jumlah,
            'subtotal' => $subtotal
        ];

        return response()->json(['product' => $product]);
    }


    public function updateQuantity(Request $request)
    {
        $jumlah = $request->input('jumlah');
        $harga = $request->input('harga');
        $diskon = $request->input('diskon'); // Diskon dalam persen

        // Hitung subtotal setelah diskon
        $subtotal = ($harga * $jumlah) - (($harga * $jumlah) * $diskon / 100);

        return response()->json(['subtotal' => $subtotal]);
    }


    protected function calculateTotal($products)
    {
        $total = 0;
        foreach ($products as $product) {
            $total += $product['subtotal'];
        }
        return $total;
    }

    public function simpanTransaksi(Request $request)
    {
        try {
            // Save transaction
            $penjualan = Penjualan::create([
                'total_item' => $request->total_item,
                'total_harga' => $request->total_harga,
                'diskon' => $request->diskon,
                'bayar' => $request->bayar,
                'diterima' => $request->diterima,
                'id_user' => Auth::user()->id,
            ]);

            foreach ($request->produk as $item) {
                $produk = Produk::find($item['id']);

                if (!$produk) {
                    return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan dengan ID: ' . $item['id']], 422);
                }

                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_produk' => $produk->id,
                    'harga_jual' => $item['harga_jual'],
                    'jumlah' => $item['jumlah'],
                    'diskon' => $item['diskon'] ?? 0,
                    'subtotal' => $item['subtotal'],
                ]);

                // Update product stock
                $produk->stok -= $item['jumlah'];
                $produk->save();

                if (in_array($produk->stok, [1, 2, 3])) {
                    $users = User::all();
                    foreach ($users as $user) {
                        $user->notify(new LowStockNotification($produk));
                    }
                }
            }

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan.', 'penjualan_id' => $penjualan->id]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }


    public function cetakNota($id)
    {
        $penjualan = Penjualan::with('detailPenjualans.produk')->findOrFail($id);

        $pdf = PDF::loadView('pages.nota', compact('penjualan'));
        return $pdf->stream('nota.pdf'); // Atau ->download('nota.pdf') untuk mendownload langsung
    }
}
