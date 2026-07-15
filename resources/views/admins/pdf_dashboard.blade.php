<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Overview - WilmarBuku</title>
    <style>
        body { font-family: sans-serif; color: #121c29; font-size: 14px; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #004b23; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #004b23; margin: 0 0 5px 0; font-size: 24px; }
        .header p { color: #404941; margin: 0; font-size: 12px; }
        
        .metrics-grid { width: 100%; margin-bottom: 40px; }
        .metrics-grid td { width: 25%; padding: 15px; border: 1px solid #d9e3f6; text-align: center; background-color: #f8f9ff; border-radius: 8px; }
        .metric-title { font-size: 11px; font-weight: bold; color: #707970; text-transform: uppercase; margin-bottom: 5px; }
        .metric-value { font-size: 20px; font-weight: bold; color: #121c29; margin: 0; }
        
        .table-container { width: 100%; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #eaf1ff; color: #003215; text-align: left; padding: 10px; font-size: 12px; font-weight: bold; border-bottom: 2px solid #d9e3f6; }
        td { padding: 10px; border-bottom: 1px solid #d9e3f6; font-size: 12px; color: #404941; }
        tr:nth-child(even) { background-color: #f8f9ff; }
        
        .status-badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .status-paid { background-color: #e6ffed; color: #147b36; border: 1px solid #a3e6b3; }
        .status-unpaid { background-color: #fff3e6; color: #9c5c0c; border: 1px solid #ffe0b3; }
        
        .footer { text-align: right; margin-top: 50px; font-size: 11px; color: #707970; }
    </style>
</head>
<body>
    <div class="header">
        <h1>WilmarBuku - Dashboard Overview</h1>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
    </div>

    <table class="metrics-grid">
        <tr>
            <td>
                <div class="metric-title">Total Pendanaan (IDR)</div>
                <div class="metric-value">Rp {{ number_format($totalDonations, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="metric-title">Buku Dibutuhkan</div>
                <div class="metric-value">{{ number_format($booksNeeded) }}</div>
            </td>
            <td>
                <div class="metric-title">Total Buku</div>
                <div class="metric-value">{{ number_format($totalBooks) }}</div>
            </td>
            <td>
                <div class="metric-title">Total User Aktif</div>
                <div class="metric-value">{{ number_format($totalUsers) }}</div>
            </td>
        </tr>
    </table>

    <div style="width: 100%; display: block; margin-bottom: 20px;">
        <h3 style="margin-bottom: 0; color: #004b23;">Top 5 Buku Paling Dibutuhkan</h3>
        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th style="text-align: center;">Kebutuhan (Eks)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topNeededBooks as $buku)
                <tr>
                    <td style="font-weight: bold;">{{ $buku->judul_buku }}</td>
                    <td>{{ $buku->penulis }}</td>
                    <td>{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                    <td style="text-align: center; color: #d92d20; font-weight: bold;">{{ $buku->stok_dibutuhkan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada data buku dibutuhkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="width: 100%; display: block;">
        <h3 style="margin-bottom: 0; color: #004b23;">5 Donasi Terkini</h3>
        <table>
            <thead>
                <tr>
                    <th>Kode Tracking</th>
                    <th>Nama Donatur</th>
                    <th>Tanggal</th>
                    <th>Total Harga (Rp)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $trx)
                <tr>
                    <td style="font-weight: bold;">{{ $trx->kode_tracking }}</td>
                    <td>{{ $trx->user->nama_lengkap ?? 'Guest' }}</td>
                    <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                    <td>{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $trx->status_tracking }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada transaksi donasi terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dihasilkan oleh Sistem WilmarBuku &copy; {{ date('Y') }}
    </div>
</body>
</html>
