<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\Concerns\GorselYukle;
use App\Models\Hizmet;
use Illuminate\Http\Request;

class HizmetController extends Controller
{
    use GorselYukle;

    public function index()
    {
        $hizmetler = Hizmet::sirali()->paginate(20);

        return view('panel.hizmetler.index', compact('hizmetler'));
    }

    public function create()
    {
        return view('panel.hizmetler.form', ['hizmet' => new Hizmet(['durum' => 'yayin'])]);
    }

    public function store(Request $request)
    {
        $veri = $this->dogrula($request);
        $veri['slug'] = slugify_tr($request->slug ?: $request->ad);
        $veri['gorsel'] = $this->gorselKaydet($request->file('gorsel'), 'hizmetler');
        Hizmet::create($veri);

        return redirect()->route('panel.hizmetler.index')->with('basari', 'Hizmet eklendi.');
    }

    public function edit(Hizmet $hizmet)
    {
        return view('panel.hizmetler.form', compact('hizmet'));
    }

    public function update(Request $request, Hizmet $hizmet)
    {
        $veri = $this->dogrula($request);
        $veri['slug'] = slugify_tr($request->slug ?: $request->ad);
        if ($request->hasFile('gorsel')) {
            $veri['gorsel'] = $this->gorselKaydet($request->file('gorsel'), 'hizmetler', $hizmet->gorsel);
        }
        $hizmet->update($veri);

        return redirect()->route('panel.hizmetler.index')->with('basari', 'Hizmet güncellendi.');
    }

    public function destroy(Hizmet $hizmet)
    {
        $this->gorselSil($hizmet->gorsel);
        $hizmet->delete();

        return back()->with('basari', 'Hizmet silindi.');
    }

    protected function dogrula(Request $request): array
    {
        return $request->validate([
            'ad' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:170'],
            'ikon' => ['nullable', 'string', 'max:60'],
            'aciklama' => ['nullable', 'string'],
            'sira' => ['nullable', 'integer'],
            'durum' => ['required', 'in:yayin,taslak'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_desc' => ['nullable', 'string', 'max:255'],
            'gorsel' => ['nullable', 'image', 'max:4096'],
        ]);
    }
}
