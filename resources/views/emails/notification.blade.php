<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $pesanMasuk->judul }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2 style="color: #004225; border-bottom: 2px solid #004225; padding-bottom: 10px;">{{ $pesanMasuk->judul }}</h2>
        <div style="margin-top: 20px;">
            {!! $pesanMasuk->isi_pesan !!}
        </div>
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #777;">
            <p>Email ini dikirim secara otomatis oleh sistem WilmarBuku. Mohon untuk tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
