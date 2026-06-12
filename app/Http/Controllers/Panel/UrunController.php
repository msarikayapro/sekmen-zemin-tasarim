<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\Concerns\GorselYukle;
use App\Models\Kategori;
use App\Models\Urun;
use App\Models\UrunGorsel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UrunController extends Controller
{
    use GorselYukle;

    public function index(Request $request)
    {
        $urunler = Urun::with('kategoriler')
            ->when($request->q, fn ($q) => $q->where('ad', 'like', "%{$request->q}%"))
            ->when($request->durum, fn ($q) => $q->where('durum', $request->durum))
            ->sirali()->paginate(20)->withQueryString();

        return view('panel.urunler.index', compact('urunler'));
    }

    public function create()
    {
        return view('panel.urunler.form', [
            'urun' => new Urun(['durum' => 'yayin']),
            'kategoriler' => Kategori::orderBy('sira')->get(),
            'secili' => [],
        ]);
    }

    public function store(Request $request)
    {
        $veri = $this->dogrula($request);
        $veri['slug'] = $this->slug($request->slug ?: $request->ad);
        $veri['one_cikan_gorsel'] = $this->gorselKaydet($request->file('one_cikan_gorsel'), 'urunler');

        $urun = Urun::create($veri);
        $urun->kategoriler()->sync($request->input('kategoriler', []));
        $this->galeriEkle($request, $urun);

        return redirect()->route('panel.urunler.edit', $urun)->with('basari', 'Ürün eklendi.');
    }

    public function edit(Urun $urun)
    {
        return view('panel.urunler.form', [
            'urun' => $urun->load('gorseller'),
            'kategoriler' => Kategori::orderBy('sira')->get(),
            'secili' => $urun->kategoriler->pluck('id')->all(),
        ]);
    }

    public function update(Request $request, Urun $urun)
    {
        $veri = $this->dogrula($request);
        $veri['slug'] = $this->slug($request->slug ?: $request->ad, $urun->id);
        if ($request->hasFile('one_cikan_gorsel')) {
            $veri['one_cikan_gorsel'] = $this->gorselKaydet($request->file('one_cikan_gorsel'), 'urunler', $urun->one_cikan_gorsel);
        }

        $urun->update($veri);
        $urun->kategoriler()->sync($request->input('kategoriler', []));
        $this->galeriEkle($request, $urun);

        return back()->with('basari', 'Ürün güncellendi.');
    }

    public function destroy(Urun $urun)
    {
        $urun->delete(); // SoftDelete

        return redirect()->route('panel.urunler.index')->with('basari', 'Ürün silindi (çöp kutusuna taşındı).');
    }

    /** Galeri görselini sil. */
    public function gorselSilFn(UrunGorsel $gorsel)
    {
        $this->gorselSil($gorsel->yol);
        $gorsel->delete();

        return back()->with('basari', 'Görsel silindi.');
    }

    /** Sürükle-bırak sıralama (AJAX). */
    public function sirala(Request $request)
    {
        foreach ($request->input('sira', []) as $index => $id) {
            Urun::where('id', $id)->update(['sira' => $index + 1]);
        }

        return response()->json(['ok' => true]);
    }

    // --- yardımcılar ---

    protected function dogrula(Request $request): array
    {
        $veri = $request->validate([
            'ad'           => ['required', 'string', 'max:150'],
            'slug'         => ['nullable', 'string', 'max:160'],
            'aciklama'     => ['nullable', 'string'],
            'ebat_en'      => ['nullable', 'string', 'max:50'],
            'ebat_boy'     => ['nullable', 'string', 'max:50'],
            'kalinlik'     => ['nullable', 'string', 'max:50'],
            'm2_adet'      => ['nullable', 'string', 'max:50'],
            'palet_bilgi'  => ['nullable', 'string', 'max:50'],
            'renkler'      => ['nullable', 'string'],
            'kullanim'     => ['nullable', 'string'],
            'dayanim'      => ['nullable', 'string', 'max:255'],
            'don_direnci'  => ['nullable', 'string', 'max:255'],
            'video_url'    => ['nullable', 'url', 'max:255'],
            'one_cikan'    => ['nullable', 'boolean'],
            'sira'         => ['nullable', 'integer'],
            'durum'        => ['required', 'in:yayin,taslak'],
            'meta_title'   => ['nullable', 'string', 'max:255'],
            'meta_desc'    => ['nullable', 'string', 'max:255'],
            'one_cikan_gorsel' => ['nullable', 'image', 'max:4096'],
        ]);

        $veri['renk_secenekleri'] = $this->satirlar($request->renkler);
        $veri['kullanim_alanlari'] = $this->satirlar($request->kullanim);
        $veri['one_cikan'] = $request->boolean('one_cikan');
        unset($veri['renkler'], $veri['kullanim']);

        return $veri;
    }

    protected function galeriEkle(Request $request, Urun $urun): void
    {
        foreach ((array) $request->file('galeri', []) as $i => $dosya) {
            $yol = $this->gorselKaydet($dosya, 'urunler/galeri');
            if ($yol) {
                $urun->gorseller()->create(['yol' => $yol, 'sira' => $i]);
            }
        }
    }

    protected function satirlar(?string $metin): array
    {
        if (! $metin) {
            return [];
        }

        return collect(preg_split('/[\r\n,]+/', $metin))
            ->map(fn ($s) => trim($s))->filter()->values()->all();
    }

    protected function slug(string $kaynak, ?int $haricId = null): string
    {
        $slug = slugify_tr($kaynak);
        $orijinal = $slug;
        $i = 1;
        while (Urun::withTrashed()->where('slug', $slug)->when($haricId, fn ($q) => $q->where('id', '!=', $haricId))->exists()) {
            $slug = $orijinal . '-' . $i++;
        }

        return $slug;
    }
}
