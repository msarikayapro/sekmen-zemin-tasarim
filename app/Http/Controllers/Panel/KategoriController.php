<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\Concerns\GorselYukle;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    use GorselYukle;

    public function index()
    {
        $kategoriler = Kategori::withCount('urunler')->orderBy('sira')->get();

        return view('panel.kategoriler.index', compact('kategoriler'));
    }

    public function create()
    {
        return view('panel.kategoriler.form', ['kategori' => new Kategori()]);
    }

    public function store(Request $request)
    {
        $veri = $this->dogrula($request);
        $veri['slug'] = slugify_tr($request->slug ?: $request->ad);
        $veri['gorsel'] = $this->gorselKaydet($request->file('gorsel'), 'kategoriler');
        Kategori::create($veri);

        return redirect()->route('panel.kategoriler.index')->with('basari', 'Kategori eklendi.');
    }

    public function edit(Kategori $kategori)
    {
        return view('panel.kategoriler.form', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $veri = $this->dogrula($request);
        $veri['slug'] = slugify_tr($request->slug ?: $request->ad);
        if ($request->hasFile('gorsel')) {
            $veri['gorsel'] = $this->gorselKaydet($request->file('gorsel'), 'kategoriler', $kategori->gorsel);
        }
        $kategori->update($veri);

        return redirect()->route('panel.kategoriler.index')->with('basari', 'Kategori güncellendi.');
    }

    public function destroy(Kategori $kategori)
    {
        $this->gorselSil($kategori->gorsel);
        $kategori->delete();

        return back()->with('basari', 'Kategori silindi.');
    }

    protected function dogrula(Request $request): array
    {
        return $request->validate([
            'ad' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:140'],
            'aciklama_seo' => ['nullable', 'string'],
            'sira' => ['nullable', 'integer'],
            'gorsel' => ['nullable', 'image', 'max:4096'],
        ]);
    }
}
