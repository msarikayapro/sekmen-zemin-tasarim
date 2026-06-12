<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\Concerns\GorselYukle;
use App\Models\Yorum;
use Illuminate\Http\Request;

class YorumController extends Controller
{
    use GorselYukle;

    public function index()
    {
        $yorumlar = Yorum::sirali()->paginate(20);

        return view('panel.yorumlar.index', compact('yorumlar'));
    }

    public function create()
    {
        return view('panel.yorumlar.form', ['yorum' => new Yorum(['durum' => 'yayin', 'puan' => 5])]);
    }

    public function store(Request $request)
    {
        $veri = $this->dogrula($request);
        $veri['gorsel'] = $this->gorselKaydet($request->file('gorsel'), 'yorumlar');
        $veri['one_cikan'] = $request->boolean('one_cikan');
        Yorum::create($veri);

        return redirect()->route('panel.yorumlar.index')->with('basari', 'Yorum eklendi.');
    }

    public function edit(Yorum $yorum)
    {
        return view('panel.yorumlar.form', compact('yorum'));
    }

    public function update(Request $request, Yorum $yorum)
    {
        $veri = $this->dogrula($request);
        if ($request->hasFile('gorsel')) {
            $veri['gorsel'] = $this->gorselKaydet($request->file('gorsel'), 'yorumlar', $yorum->gorsel);
        }
        $veri['one_cikan'] = $request->boolean('one_cikan');
        $yorum->update($veri);

        return redirect()->route('panel.yorumlar.index')->with('basari', 'Yorum güncellendi.');
    }

    public function destroy(Yorum $yorum)
    {
        $this->gorselSil($yorum->gorsel);
        $yorum->delete();

        return back()->with('basari', 'Yorum silindi.');
    }

    protected function dogrula(Request $request): array
    {
        return $request->validate([
            'ad' => ['required', 'string', 'max:120'],
            'unvan' => ['nullable', 'string', 'max:120'],
            'icerik' => ['required', 'string'],
            'puan' => ['nullable', 'integer', 'min:1', 'max:5'],
            'sira' => ['nullable', 'integer'],
            'durum' => ['required', 'in:yayin,gizli'],
            'gorsel' => ['nullable', 'image', 'max:4096'],
        ]);
    }
}
