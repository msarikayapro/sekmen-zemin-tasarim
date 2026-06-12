<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Sss;
use App\Models\SssSayfa;
use Illuminate\Http\Request;

class SssController extends Controller
{
    public function index()
    {
        $gruplar = Sss::with('sayfalar')->sirali()->get()->groupBy('kategori');

        return view('panel.sss.index', compact('gruplar'));
    }

    public function create()
    {
        return view('panel.sss.form', ['sss' => new Sss(['durum' => 'yayin']), 'seciliSayfalar' => []]);
    }

    public function store(Request $request)
    {
        $veri = $this->dogrula($request);
        $sss = Sss::create($veri);
        $this->sayfalariKaydet($request, $sss);

        return redirect()->route('panel.sss.index')->with('basari', 'Soru-Cevap eklendi.');
    }

    public function edit(Sss $sss)
    {
        return view('panel.sss.form', [
            'sss' => $sss,
            'seciliSayfalar' => $sss->sayfalar->pluck('sayfa_anahtar')->all(),
        ]);
    }

    public function update(Request $request, Sss $sss)
    {
        $sss->update($this->dogrula($request));
        $this->sayfalariKaydet($request, $sss);

        return redirect()->route('panel.sss.index')->with('basari', 'Soru-Cevap güncellendi.');
    }

    public function destroy(Sss $sss)
    {
        $sss->delete();

        return back()->with('basari', 'Soru-Cevap silindi.');
    }

    protected function dogrula(Request $request): array
    {
        return $request->validate([
            'soru' => ['required', 'string', 'max:255'],
            'cevap' => ['required', 'string'],
            'kategori' => ['required', 'string', 'max:60'],
            'sira' => ['nullable', 'integer'],
            'durum' => ['required', 'in:yayin,gizli'],
        ]);
    }

    protected function sayfalariKaydet(Request $request, Sss $sss): void
    {
        $sss->sayfalar()->delete();
        foreach ((array) $request->input('sayfalar', []) as $anahtar) {
            if (array_key_exists($anahtar, Sss::SAYFALAR)) {
                SssSayfa::create(['sss_id' => $sss->id, 'sayfa_anahtar' => $anahtar]);
            }
        }
    }
}
