<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\Concerns\GorselYukle;
use App\Models\Proje;
use App\Models\ProjeGorsel;
use App\Models\Urun;
use Illuminate\Http\Request;

class ProjeController extends Controller
{
    use GorselYukle;

    public function index()
    {
        $projeler = Proje::sirali()->paginate(20);

        return view('panel.projeler.index', compact('projeler'));
    }

    public function create()
    {
        return view('panel.projeler.form', [
            'proje' => new Proje(['durum' => 'yayin', 'tip' => 'konut']),
            'urunler' => Urun::orderBy('ad')->get(['id', 'ad']),
            'secili' => [],
        ]);
    }

    public function store(Request $request)
    {
        $veri = $this->dogrula($request);
        $veri['slug'] = $this->slug($request->slug ?: $request->baslik);
        $veri['kapak_gorsel'] = $this->gorselKaydet($request->file('kapak_gorsel'), 'projeler');
        $proje = Proje::create($veri);
        $proje->urunler()->sync($request->input('urunler', []));
        $this->galeriEkle($request, $proje);

        return redirect()->route('panel.projeler.edit', $proje)->with('basari', 'Proje eklendi.');
    }

    public function edit(Proje $proje)
    {
        return view('panel.projeler.form', [
            'proje' => $proje->load('gorseller'),
            'urunler' => Urun::orderBy('ad')->get(['id', 'ad']),
            'secili' => $proje->urunler->pluck('id')->all(),
        ]);
    }

    public function update(Request $request, Proje $proje)
    {
        $veri = $this->dogrula($request);
        $veri['slug'] = $this->slug($request->slug ?: $request->baslik, $proje->id);
        if ($request->hasFile('kapak_gorsel')) {
            $veri['kapak_gorsel'] = $this->gorselKaydet($request->file('kapak_gorsel'), 'projeler', $proje->kapak_gorsel);
        }
        $proje->update($veri);
        $proje->urunler()->sync($request->input('urunler', []));
        $this->galeriEkle($request, $proje);

        return back()->with('basari', 'Proje güncellendi.');
    }

    public function destroy(Proje $proje)
    {
        $this->gorselSil($proje->kapak_gorsel);
        $proje->delete();

        return redirect()->route('panel.projeler.index')->with('basari', 'Proje silindi.');
    }

    public function gorselSilFn(Request $request, ProjeGorsel $gorsel)
    {
        $this->gorselSil($gorsel->yol);
        $gorsel->delete();

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return back()->with('basari', 'Görsel silindi.');
    }

    protected function dogrula(Request $request): array
    {
        $veri = $request->validate([
            'baslik' => ['required', 'string', 'max:160'],
            'slug' => ['nullable', 'string', 'max:180'],
            'tip' => ['required', 'in:konut,kamu,ticari,peyzaj'],
            'konum' => ['nullable', 'string', 'max:120'],
            'tarih' => ['nullable', 'string', 'max:50'],
            'aciklama' => ['nullable', 'string'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'musteri_adi' => ['nullable', 'string', 'max:120'],
            'musteri_yorumu' => ['nullable', 'string'],
            'one_cikan' => ['nullable', 'boolean'],
            'sira' => ['nullable', 'integer'],
            'durum' => ['required', 'in:yayin,taslak'],
            'kapak_gorsel' => ['nullable', 'image', 'max:4096'],
        ]);
        $veri['one_cikan'] = $request->boolean('one_cikan');
        $veri['sira'] = $request->integer('sira'); // NOT NULL kolon — boşsa 0

        return $veri;
    }

    protected function galeriEkle(Request $request, Proje $proje): void
    {
        foreach ((array) $request->file('galeri', []) as $i => $dosya) {
            $yol = $this->gorselKaydet($dosya, 'projeler/galeri');
            if ($yol) {
                $proje->gorseller()->create(['yol' => $yol, 'sira' => $i]);
            }
        }
    }

    protected function slug(string $kaynak, ?int $haricId = null): string
    {
        $slug = slugify_tr($kaynak);
        $orijinal = $slug;
        $i = 1;
        while (Proje::where('slug', $slug)->when($haricId, fn ($q) => $q->where('id', '!=', $haricId))->exists()) {
            $slug = $orijinal . '-' . $i++;
        }

        return $slug;
    }
}
