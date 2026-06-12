<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Urun;
use App\Support\SssService;
use Illuminate\Http\Request;

class UrunController extends Controller
{
    public function index(Request $request)
    {
        $kategoriler = Kategori::orderBy('sira')->get();
        $aktifKategori = $request->query('kategori');

        $urunler = Urun::yayinda()->with('gorseller')->sirali()
            ->when($aktifKategori, function ($q) use ($aktifKategori) {
                $q->whereHas('kategoriler', fn ($k) => $k->where('slug', $aktifKategori));
            })
            ->paginate(12)->withQueryString();

        $ssler = SssService::sayfaSsleri('urun_kategori');

        return view('site.urunler.index', [
            'urunler'       => $urunler,
            'kategoriler'   => $kategoriler,
            'aktifKategori' => $aktifKategori,
            'ssler'         => $ssler,
            'faqSchema'     => SssService::faqSchema($ssler),
        ]);
    }

    public function show(Urun $urun)
    {
        abort_if($urun->durum !== 'yayin', 404);

        $urun->load(['gorseller', 'kategoriler']);

        // İlgili ürünler (aynı kategoriden)
        $kategoriIdler = $urun->kategoriler->pluck('id');
        $ilgili = Urun::yayinda()->with('gorseller')
            ->where('id', '!=', $urun->id)
            ->whereHas('kategoriler', fn ($k) => $k->whereIn('kategoriler.id', $kategoriIdler))
            ->sirali()->take(4)->get();
        if ($ilgili->count() < 4) {
            $ilgili = Urun::yayinda()->with('gorseller')->where('id', '!=', $urun->id)->sirali()->take(4)->get();
        }

        $ssler = SssService::sayfaSsleri('urun_detay');

        return view('site.urunler.show', [
            'urun'      => $urun,
            'ilgili'    => $ilgili,
            'ssler'     => $ssler,
            'faqSchema' => SssService::faqSchema($ssler),
            'waMesaj'   => 'Merhaba, ' . $urun->ad . ' ürünü hakkında bilgi ve teklif almak istiyorum.',
        ]);
    }
}
