<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\SeoLanding;
use Illuminate\Http\Request;

class SeoLandingController extends Controller
{
    public function index()
    {
        $sayfalar = SeoLanding::latest()->paginate(20);

        return view('panel.seo-landing.index', compact('sayfalar'));
    }

    public function create()
    {
        return view('panel.seo-landing.form', ['sayfa' => new SeoLanding(['durum' => 'yayin'])]);
    }

    public function store(Request $request)
    {
        $veri = $this->dogrula($request);
        $veri['slug'] = $this->slug($request->slug ?: ($request->sehir . '-' . $request->urun_tipi));
        // Otomatik meta üretimi (boşsa)
        $veri['meta_title'] = $veri['meta_title'] ?? ($request->baslik_h1 . ' | Sekmen Zemin Tasarım');
        SeoLanding::create($veri);

        return redirect()->route('panel.seo-landing.index')->with('basari', 'SEO landing sayfası eklendi.');
    }

    public function edit(SeoLanding $seoLanding)
    {
        return view('panel.seo-landing.form', ['sayfa' => $seoLanding]);
    }

    public function update(Request $request, SeoLanding $seoLanding)
    {
        $veri = $this->dogrula($request);
        $veri['slug'] = $this->slug($request->slug ?: $seoLanding->slug, $seoLanding->id);
        $seoLanding->update($veri);

        return redirect()->route('panel.seo-landing.index')->with('basari', 'Sayfa güncellendi.');
    }

    public function destroy(SeoLanding $seoLanding)
    {
        $seoLanding->delete();

        return back()->with('basari', 'Sayfa silindi.');
    }

    protected function dogrula(Request $request): array
    {
        return $request->validate([
            'baslik_h1' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200'],
            'sehir' => ['nullable', 'string', 'max:80'],
            'urun_tipi' => ['nullable', 'string', 'max:80'],
            'icerik' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_desc' => ['nullable', 'string', 'max:255'],
            'durum' => ['required', 'in:yayin,taslak'],
        ]);
    }

    protected function slug(string $kaynak, ?int $haricId = null): string
    {
        $slug = slugify_tr($kaynak);
        $orijinal = $slug;
        $i = 1;
        while (SeoLanding::where('slug', $slug)->when($haricId, fn ($q) => $q->where('id', '!=', $haricId))->exists()) {
            $slug = $orijinal . '-' . $i++;
        }

        return $slug;
    }
}
