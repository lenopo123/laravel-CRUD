@extends('app')

@section('title', 'Daftar Pembelian User')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center fw-bold text-primary">
        <i class="bi bi-people-fill me-2"></i> Daftar Pembelian User
    </h2>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if($purchases->isEmpty())
        <div class="alert alert-info text-center">
            Belum ada transaksi pembelian dari pengguna.
        </div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Nama Pengguna</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal Pembelian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $index => $purchase)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $purchase->user->name ?? 'User Dihapus' }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($purchase->produk && $purchase->produk->gambar)
                                        <img src="{{ asset('storage/' . $purchase->produk->gambar) }}" 
                                             alt="{{ $purchase->produk->nama }}" 
                                             class="me-3 rounded" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <img src="https://via.placeholder.com/60" 
                                             alt="No Image" 
                                             class="me-3 rounded">
                                    @endif
                                    <div>
                                        <strong>{{ $purchase->produk->nama ?? 'Produk Dihapus' }}</strong><br>
                                        <small class="text-muted">
                                            Rp {{ number_format($purchase->produk->harga ?? 0, 0, ',', '.') }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">{{ $purchase->quantity }}</td>
                            <td class="text-center">
                                <strong>Rp {{ number_format(($purchase->produk->harga ?? 0) * $purchase->quantity, 0, ',', '.') }}</strong>
                            </td>
                            <td class="text-center">
                                @php
                                    $status = $purchase->status;
                                    $badge = match($status) {
                                        'Menunggu Konfirmasi' => 'warning',
                                        'Sedang Dikemas' => 'primary',
                                        'Sedang Dikirim' => 'info',
                                        'Selesai' => 'success',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $status }}</span>
                            </td>
                            <td class="text-center">{{ $purchase->created_at->format('d M Y, H:i') }}</td>
                            <td class="text-center">
                                <form action="{{ route('purchase.updateStatus', $purchase->id) }}" method="POST" class="d-flex">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select form-select-sm me-2" required>
                                        <option value="Menunggu Konfirmasi" {{ $status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Sedang Dikemas" {{ $status == 'Sedang Dikemas' ? 'selected' : '' }}>Sedang Dikemas</option>
                                        <option value="Sedang Dikirim" {{ $status == 'Sedang Dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                                        <option value="Selesai" {{ $status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bi bi-save"></i> Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection