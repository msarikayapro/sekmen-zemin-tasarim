<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Yonlendirme;
use Illuminate\Http\Request;

class YonlendirmeController extends Controller
{
    public function index()
    {
        $yonlendirmeler = Yonlendirme::latest()->paginate(30);

        return view('panel.yonlendirmeler.index', compact('yonlendirmeler'));
    }

    public function store(Request $request)
    {
        $veri = $request->validate([
            'eski_url' => ['required', 'string', 'max:255'],
            'yeni_url' => ['required', 'string', 'max:255'],
            'tip' => ['required', 'integer', 'in:301,302'],
        ]);
        $veri['aktif'] = true;
        Yonlendirme::create($veri);
        Yonlendirme::temizle();

        return back()->with('basari', 'Yönlendirme eklendi.');
    }

    public function toggle(Yonlendirme $yonlendirme)
    {
        $yonlendirme->update(['aktif' => ! $yonlendirme->aktif]);
        Yonlendirme::temizle();

        return back()->with('basari', 'Yönlendirme durumu güncellendi.');
    }

    public function destroy(Yonlendirme $yonlendirme)
    {
        $yonlendirme->delete();
        Yonlendirme::temizle();

        return back()->with('basari', 'Yönlendirme silindi.');
    }
}
