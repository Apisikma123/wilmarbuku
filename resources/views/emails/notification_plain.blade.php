{{ $pesanMasuk->judul }}

{!! strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], "\n", $pesanMasuk->isi_pesan)) !!}

--------------------------------------------------
Email ini dikirim secara otomatis oleh sistem WilmarBuku. Mohon untuk tidak membalas email ini.
