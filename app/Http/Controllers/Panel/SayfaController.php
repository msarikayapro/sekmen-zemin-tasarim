<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Sayfa;
use Illuminate\Http\Request;

class SayfaController extends Controller
{
    public function index()
    {
        $sayfalar = Sayfa::orderBy('anahtar')->get();

        return view('panel.sayfalar.index', compact('sayfalar'));
    }

    public function edit(Sayfa $sayfa)
    {
        return view('panel.sayfalar.form', compact('sayfa'));
    }

    public function update(Request $request, Sayfa $sayfa)
    {
        $veri = $request->validate([
            'baslik' => ['nullable', 'string', 'max:200'],
            'icerik' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_desc' => ['nullable', 'string', 'max:255'],
        ]);

        // Ana sayfa blokları (home) — bloklar json'u
        if ($request->has('bloklar')) {
            $veri['bloklar'] = array_filter($request->input('bloklar', []), fn ($v) => $v !== null);
        }

        $sayfa->update($veri);

        return back()->with('basari', 'Sayfa içeriği güncellendi.');
    }
}
