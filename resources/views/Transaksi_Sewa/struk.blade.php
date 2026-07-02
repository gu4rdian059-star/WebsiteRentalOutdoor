<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran - #{{ $transaksi->id_sewa }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            background: #f5f5f5;
            padding: 20px;
        }
        .struk-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border: 2px solid #333;
            padding: 30px;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #333;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 14px;
            margin: 3px 0;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section h3 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #1e8e5a;
            border-bottom: 1px solid #1e8e5a;
            padding-bottom: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 13px;
        }
        .info-label {
            font-weight: normal;
            color: #666;
        }
        .info-value {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 13px;
        }
        table th {
            text-align: left;
            border-bottom: 2px solid #333;
            padding: 8px 5px;
        }
        table td {
            border-bottom: 1px solid #ddd;
            padding: 8px 5px;
        }
        .total-section {
            margin-top: 20px;
            border-top: 2px solid #333;
            padding-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .total-grand {
            font-size: 18px;
            font-weight: bold;
            color: #1e8e5a;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 12px;
        }
        .status-disewa {
            background: #ffc107;
            color: #000;
        }
        .status-selesai {
            background: #28a745;
            color: #fff;
        }
        .status-terlambat {
            background: #dc3545;
            color: #fff;
        }
        .btn-download {
            display: inline-block;
            background: #1e8e5a;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .no-print {
            text-align: center;
            margin-top: 20px;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .struk-container {
                border: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="struk-container">
        <div class="header">
            <h1>🏕️ STRUK PEMBAYARAN</h1>
            <p>Persewaan Alat Outdoor</p>
            <p>No. Transaksi: <strong>#{{ $transaksi->id_sewa }}</strong></p>
            <p>Tanggal: {{ date('d-m-Y H:i:s') }}</p>
        </div>

        <div class="info-section">
            <h3>📋 DATA PENYEWA</h3>
            <div class="info-row">
                <span class="info-label">Nama:</span>
                <span class="info-value">{{ $mainTransaksi->pelanggan->nama_pelanggan ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">No. Telepon:</span>
                <span class="info-value">{{ $mainTransaksi->pelanggan->no_telepon ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Alamat:</span>
                <span class="info-value">{{ $mainTransaksi->pelanggan->alamat_pelanggan ?? '-' }}</span>
            </div>
        </div>

        <div class="info-section">
            <h3>📅 JADWAL SEWA</h3>
            <div class="info-row">
                <span class="info-label">Tanggal Sewa:</span>
                <span class="info-value">{{ date('d-m-Y', strtotime($mainTransaksi->tanggal_sewa)) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Kembali:</span>
                <span class="info-value">{{ date('d-m-Y', strtotime($mainTransaksi->tanggal_kembali)) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Durasi:</span>
                <span class="info-value">{{ $mainTransaksi->jumlah_hari }} hari</span>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alat</th>
                    <th>Qty</th>
                    <th>Harga/Hari</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($transaksiGroup as $trx)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $trx->alat->nama_alat ?? '-' }}</td>
                    <td>{{ $trx->jumlah_satuan ?? 1 }}</td>
                    <td>Rp {{ number_format($trx->alat->harga_sewa ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                </tr>
                @php $no++; @endphp
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Denda:</span>
                <span>Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
            </div>
            <div class="total-row total-grand">
                <span>TOTAL BAYAR:</span>
                <span>Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="info-section" style="margin-top: 20px;">
            <div class="info-row">
                <span class="info-label">Metode Pembayaran:</span>
                <span class="info-value">{{ str_replace('_', ' ', ucfirst($mainTransaksi->payment_method ?? '-')) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status Pembayaran:</span>
                <span class="info-value">{{ ucfirst($mainTransaksi->payment_status ?? '-') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status Sewa:</span>
                <span class="info-value">
                    <span class="status status-{{ $mainTransaksi->status }}">{{ strtoupper($mainTransaksi->status) }}</span>
                </span>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih telah menggunakan layanan Persewaan Alat Outdoor!</p>
            <p>Struk ini merupakan bukti transaksi yang sah.</p>
        </div>

        @if(!isset($download) || !$download)
        <div class="no-print">
            <a href="{{ route('transaksi_sewa.downloadStruk', $transaksi->id_sewa) }}" class="btn-download">
                📥 Download Struk
            </a>
            <br><br>
            <a href="{{ route('transaksi_sewa.index') }}" style="color: #666; font-size: 12px;">
                ← Kembali ke Daftar Transaksi
            </a>
        </div>
        @endif
    </div>
</body>
</html>
