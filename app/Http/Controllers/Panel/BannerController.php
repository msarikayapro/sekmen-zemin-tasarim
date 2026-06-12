<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\Concerns\GorselYukle;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use GorselYukle;

    public function index()
    {
        $bannerlar = Banner::sirali()->paginate(20);

        return view('panel.bannerlar.index', compact('bannerlar'));
    }

    public function create()
    {
        return view('panel.bannerlar.form', ['banner' => new Banner(['durum' => 'yayin'])]);
    }

    public function store(Request $request)
    {
        $veri = $this->dogrula($request, true);
        $veri['gorsel'] = $this->gorselKaydet($request->file('gorsel'), 'bannerlar');
        Banner::create($veri);

        return redirect()->route('panel.bannerlar.index')->with('basari', 'Banner eklendi.');
    }

    public function edit(Banner $banner)
    {
        return view('panel.bannerlar.form', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $veri = $this->dogrula($request, false);
        if ($request->hasFile('gorsel')) {
            $veri['gorsel'] = $this->gorselKaydet($request->file('gorsel'), 'bannerlar', $banner->gorsel);
        }
        $banner->update($veri);

        return redirect()->route('panel.bannerlar.index')->with('basari', 'Banner güncellendi.');
    }

    public function destroy(Banner $banner)
    {
        $this->gorselSil($banner->gorsel);
        $banner->delete();

        return back()->with('basari', 'Banner silindi.');
    }

    protected function dogrula(Request $request, bool $yeni): array
    {
        return $request->validate([
            'baslik' => ['nullable', 'string', 'max:160'],
            'alt_baslik' => ['nullable', 'string', 'max:255'],
            'alt_metin' => ['nullable', 'string', 'max:160'],
            'buton_yazi' => ['nullable', 'string', 'max:60'],
            'link' => ['nullable', 'string', 'max:255'],
            'sira' => ['nullable', 'integer'],
            'durum' => ['required', 'in:yayin,gizli'],
            'gorsel' => [$yeni ? 'required' : 'nullable', 'image', 'max:6144'],
        ]);
    }
}
