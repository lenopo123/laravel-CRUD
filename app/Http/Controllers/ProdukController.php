<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    
    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama', 'harga', 'stok', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
            $data['gambar'] = $path;
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama', 'harga', 'stok', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $path = $request->file('gambar')->store('produk', 'public');
            $data['gambar'] = $path;
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }

  

    public function showBuyForm($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.buy', compact('produk'));
    }

    public function processPurchase(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $produk->stok,
            'alamat' => 'required|string|min:10|max:500',
            'metode_pembayaran' => 'required|in:transfer_bank,e_wallet,cod',
        ]);

       
        if ($produk->stok < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $produk->stok . ' unit');
        }

        Purchase::create([
            'user_id' => Auth::id(),
            'produk_id' => $produk->id,
            'quantity' => $request->quantity,
            'alamat' => $request->alamat,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'Menunggu Konfirmasi',
        ]);

      
        $produk->decrement('stok', $request->quantity);

        return redirect()->route('produk.index')->with('success', 'Pembelian berhasil! Menunggu konfirmasi admin.');
    }

    public function myPurchases()
    {
        $purchases = Purchase::with('produk')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('purchase.purchases', compact('purchases'));
    }

    public function managementPurchases()
    {
        $purchases = Purchase::with(['user', 'produk'])
            ->latest()
            ->get();

        return view('purchase.management', compact('purchases'));
    }

    public function updatePurchaseStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Konfirmasi,Dikonfirmasi,Ditolak,Sedang Dikemas,Sedang Dikirim,Selesai',
        ]);

        $purchase = Purchase::findOrFail($id);
        $oldStatus = $purchase->status;
        
        
        if ($request->status == 'Ditolak' && $oldStatus != 'Ditolak') {
            if ($purchase->produk) {
                $purchase->produk->increment('stok', $purchase->quantity);
            }
        }
        
        
        if ($oldStatus == 'Ditolak' && $request->status != 'Ditolak') {
            if ($purchase->produk) {
              
                if ($purchase->produk->stok < $purchase->quantity) {
                    return redirect()->back()->with('error', 'Stok produk tidak mencukupi! Stok tersedia: ' . $purchase->produk->stok . ' unit');
                }
                $purchase->produk->decrement('stok', $purchase->quantity);
            }
        }

        $purchase->update(['status' => $request->status]);

        $statusMessage = [
            'Menunggu Konfirmasi' => 'Menunggu Konfirmasi',
            'Dikonfirmasi' => 'Dikonfirmasi',
            'Ditolak' => 'Ditolak',
            'Sedang Dikemas' => 'Sedang Dikemas', 
            'Sedang Dikirim' => 'Sedang Dikirim',
            'Selesai' => 'Selesai'
        ];

        return redirect()->back()->with('success', 'Status pembelian berhasil diubah menjadi: ' . $statusMessage[$request->status]);
    }

    
    public function purchaseReport()
    {
        $purchases = Purchase::with(['user', 'produk'])
            ->where('status', 'Selesai')
            ->latest()
            ->get();

        $totalRevenue = $purchases->sum(function($purchase) {
            return ($purchase->produk->harga ?? 0) * $purchase->quantity;
        });

        return view('purchase.report', compact('purchases', 'totalRevenue'));
    }
}