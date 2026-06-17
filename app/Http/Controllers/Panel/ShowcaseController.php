<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\Concerns\GorselYukle;
use App\Models\Showcase;
use Illuminate\Http\Request;

class ShowcaseController extends Controller
{
    use GorselYukle;

    public function index()
    {
        $showcases = Showcase::sirali()->get();

        return view('panel.showcases.index', compact('showcases'));
    }

    public function create()
    {
        return view('panel.showcases.form', ['showcase' => new Showcase(['type' => 'image', 'is_active' => true])]);
    }

    public function store(Request $request)
    {
        $veri = $this->dogrula($request, true);

        $veri['media_path'] = $this->gorselKaydet($request->file('media'), 'showcases');
        $veri['thumbnail_path'] = $veri['type'] === 'video'
            ? $this->gorselKaydet($request->file('thumbnail'), 'showcases/thumbnails')
            : null;
        $veri['is_active'] = $request->boolean('is_active');
        unset($veri['media'], $veri['thumbnail']);

        Showcase::create($veri);

        return redirect()->route('panel.showcases.index')->with('basari', 'Vitrin kaydı eklendi.');
    }

    public function edit(Showcase $showcase)
    {
        return view('panel.showcases.form', compact('showcase'));
    }

    public function update(Request $request, Showcase $showcase)
    {
        $veri = $this->dogrula($request, false);

        if ($request->hasFile('media')) {
            $veri['media_path'] = $this->gorselKaydet($request->file('media'), 'showcases', $showcase->media_path);
        }

        // Tip "video" ise kapak yönetilir; "image"e dönüldüyse eski kapağı temizle.
        if ($veri['type'] === 'video') {
            if ($request->hasFile('thumbnail')) {
                $veri['thumbnail_path'] = $this->gorselKaydet($request->file('thumbnail'), 'showcases/thumbnails', $showcase->thumbnail_path);
            }
        } else {
            $this->gorselSil($showcase->thumbnail_path);
            $veri['thumbnail_path'] = null;
        }

        $veri['is_active'] = $request->boolean('is_active');
        unset($veri['media'], $veri['thumbnail']);

        $showcase->update($veri);

        return redirect()->route('panel.showcases.index')->with('basari', 'Vitrin kaydı güncellendi.');
    }

    public function destroy(Showcase $showcase)
    {
        $this->gorselSil($showcase->media_path);
        $this->gorselSil($showcase->thumbnail_path);
        $showcase->delete();

        return back()->with('basari', 'Vitrin kaydı silindi.');
    }

    /** Sürükle-bırak sıralama (AJAX). */
    public function sirala(Request $request)
    {
        foreach ($request->input('sira', []) as $index => $id) {
            Showcase::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['ok' => true]);
    }

    protected function dogrula(Request $request, bool $yeni): array
    {
        $tip = $request->input('type');

        $veri = $request->validate([
            'type'      => ['required', 'in:image,video'],
            'order'     => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
            // Görsel: jpg/png/webp; Video: mp4/webm. İlk kayıtta dosya zorunlu.
            'media' => [
                $yeni ? 'required' : 'nullable',
                'file',
                $tip === 'video' ? 'mimetypes:video/mp4,video/webm' : 'image',
                $tip === 'video' ? 'max:51200' : 'max:8192', // video 50MB, görsel 8MB
            ],
            // Video seçilirse dikey tasarım için kapak fotoğrafı zorunlu (ilk kayıtta).
            'thumbnail' => [
                ($yeni && $tip === 'video') ? 'required' : 'nullable',
                'image',
                'max:8192',
            ],
        ], [
            'media.required'      => 'Bir medya dosyası yüklemelisiniz.',
            'media.mimetypes'     => 'Video için MP4 veya WEBM formatı yükleyin.',
            'media.image'         => 'Görsel için geçerli bir resim dosyası yükleyin.',
            'thumbnail.required'  => 'Video için kapak fotoğrafı (thumbnail) zorunludur.',
        ]);

        // "Sıra" boş bırakılırsa NOT NULL ihlali olmasın diye 0'a düşür.
        $veri['order'] = (int) ($veri['order'] ?? 0);

        return $veri;
    }
}
