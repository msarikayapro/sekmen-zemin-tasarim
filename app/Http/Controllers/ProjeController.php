<?php

namespace App\Http\Controllers;

use App\Models\OncesiSonrasi;
use App\Models\Proje;
use App\Support\SssService;
use Illuminate\Http\Request;

class ProjeController extends Controller
{
    public function index(Request $request)
    {
        $tip = $request->query('tip');

        $projeler = Proje::yayinda()->with('gorseller')->sirali()
            ->when($tip && array_key_exists($tip, Proje::TIPLER), fn ($q) => $q->where('tip', $tip))
            ->paginate(9)->withQueryString();

        $oncesiSonrasi = OncesiSonrasi::yayinda()
            ->whereNot('oncesi_gorsel', '')->whereNot('sonrasi_gorsel', '')
            ->orderBy('sira')->get();

        $ssler = SssService::sayfaSsleri('projeler');

        return view('site.projeler.index', [
            'projeler'      => $projeler,
            'aktifTip'      => $tip,
            'tipler'        => Proje::TIPLER,
            'oncesiSonrasi' => $oncesiSonrasi,
            'ssler'         => $ssler,
            'faqSchema'     => SssService::faqSchema($ssler),
        ]);
    }

    public function show(Proje $proje)
    {
        abort_if($proje->durum !== 'yayin', 404);

        $proje->load(['gorseller', 'urunler.gorseller', 'oncesiSonrasi']);

        return view('site.projeler.show', [
            'proje' => $proje,
        ]);
    }
}
