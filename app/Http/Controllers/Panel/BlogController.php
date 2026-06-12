<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\Concerns\GorselYukle;
use App\Models\BlogYazi;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use GorselYukle;

    public function index()
    {
        $yazilar = BlogYazi::latest()->paginate(20);

        return view('panel.blog.index', compact('yazilar'));
    }

    public function create()
    {
        return view('panel.blog.form', ['yazi' => new BlogYazi(['durum' => 'taslak'])]);
    }

    public function store(Request $request)
    {
        $veri = $this->dogrula($request);
        $veri['slug'] = $this->slug($request->slug ?: $request->baslik);
        $veri['kapak'] = $this->gorselKaydet($request->file('kapak'), 'blog');
        $veri['etiketler'] = $this->etiket($request->etiketler);
        BlogYazi::create($veri);

        return redirect()->route('panel.blog.index')->with('basari', 'Blog yazısı eklendi.');
    }

    public function edit(BlogYazi $blog)
    {
        return view('panel.blog.form', ['yazi' => $blog]);
    }

    public function update(Request $request, BlogYazi $blog)
    {
        $veri = $this->dogrula($request);
        $veri['slug'] = $this->slug($request->slug ?: $request->baslik, $blog->id);
        if ($request->hasFile('kapak')) {
            $veri['kapak'] = $this->gorselKaydet($request->file('kapak'), 'blog', $blog->kapak);
        }
        $veri['etiketler'] = $this->etiket($request->etiketler);
        $blog->update($veri);

        return redirect()->route('panel.blog.index')->with('basari', 'Blog yazısı güncellendi.');
    }

    public function destroy(BlogYazi $blog)
    {
        $this->gorselSil($blog->kapak);
        $blog->delete();

        return back()->with('basari', 'Blog yazısı silindi.');
    }

    protected function dogrula(Request $request): array
    {
        return $request->validate([
            'baslik' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:220'],
            'ozet' => ['nullable', 'string'],
            'icerik' => ['nullable', 'string'],
            'kategori' => ['nullable', 'string', 'max:80'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_desc' => ['nullable', 'string', 'max:255'],
            'durum' => ['required', 'in:yayin,taslak'],
            'kapak' => ['nullable', 'image', 'max:6144'],
        ]);
    }

    protected function etiket(?string $metin): array
    {
        return $metin ? collect(explode(',', $metin))->map(fn ($s) => trim($s))->filter()->values()->all() : [];
    }

    protected function slug(string $kaynak, ?int $haricId = null): string
    {
        $slug = slugify_tr($kaynak);
        $orijinal = $slug;
        $i = 1;
        while (BlogYazi::where('slug', $slug)->when($haricId, fn ($q) => $q->where('id', '!=', $haricId))->exists()) {
            $slug = $orijinal . '-' . $i++;
        }

        return $slug;
    }
}
