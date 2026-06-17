<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\Concerns\GorselYukle;
use App\Models\OncesiSonrasi;
use App\Models\Proje;
use Illuminate\Http\Request;

class OncesiSonrasiController extends Controller
{
    use GorselYukle;

    public function index()
    {
        $kayitlar = OncesiSonrasi::with('proje')->orderBy('sira')->paginate(20);

        return view('panel.oncesi-sonrasi.index', compact('kayitlar'));
    }

    public function create()
    {
        return view('panel.oncesi-sonrasi.form', [
            'kayit' => new OncesiSonrasi(['durum' => 'yayin']),
            'projeler' => Proje::orderBy('baslik')->get(['id', 'baslik']),
        ]);
    }

    public function store(Request $request)
    {
        $veri = $this->dogrula($request, true);
        $veri['oncesi_gorsel'] = $this->gorselKaydet($request->file('oncesi_gorsel'), 'oncesi-sonrasi');
        $veri['sonrasi_gorsel'] = $this->gorselKaydet($request->file('sonrasi_gorsel'), 'oncesi-sonrasi');
        OncesiSonrasi::create($veri);

        return redirect()->route('panel.oncesi-sonrasi.index')->with('basari', 'Öncesi/Sonrası kaydı eklendi.');
    }

    public function edit(OncesiSonrasi $oncesiSonrasi)
    {
        return view('panel.oncesi-sonrasi.form', [
            'kayit' => $oncesiSonrasi,
            'projeler' => Proje::orderBy('baslik')->get(['id', 'baslik']),
        ]);
    }

    public function update(Request $request, OncesiSonrasi $oncesiSonrasi)
    {
        $veri = $this->dogrula($request, false);
        if ($request->hasFile('oncesi_gorsel')) {
            $veri['oncesi_gorsel'] = $this->gorselKaydet($request->file('oncesi_gorsel'), 'oncesi-sonrasi', $oncesiSonrasi->oncesi_gorsel);
        }
        if ($request->hasFile('sonrasi_gorsel')) {
            $veri['sonrasi_gorsel'] = $this->gorselKaydet($request->file('sonrasi_gorsel'), 'oncesi-sonrasi', $oncesiSonrasi->sonrasi_gorsel);
        }
        $oncesiSonrasi->update($veri);

        return redirect()->route('panel.oncesi-sonrasi.index')->with('basari', 'Kayıt güncellendi.');
    }

    public function destroy(OncesiSonrasi $oncesiSonrasi)
    {
        $this->gorselSil($oncesiSonrasi->oncesi_gorsel);
        $this->gorselSil($oncesiSonrasi->sonrasi_gorsel);
        $oncesiSonrasi->delete();

        return back()->with('basari', 'Kayıt silindi.');
    }

    protected function dogrula(Request $request, bool $yeni): array
    {
        $veri = $request->validate([
            'baslik' => ['nullable', 'string', 'max:160'],
            'proje_id' => ['nullable', 'exists:projeler,id'],
            'sira' => ['nullable', 'integer'],
            'durum' => ['required', 'in:yayin,gizli'],
            'oncesi_gorsel' => [$yeni ? 'required' : 'nullable', 'image', 'max:4096'],
            'sonrasi_gorsel' => [$yeni ? 'required' : 'nullable', 'image', 'max:4096'],
        ]);

        // sira kolonu NOT NULL — boş bırakılırsa 0'a sabitle (null insert hatasını önler).
        $veri['sira'] = $request->integer('sira');

        return $veri;
    }
}
