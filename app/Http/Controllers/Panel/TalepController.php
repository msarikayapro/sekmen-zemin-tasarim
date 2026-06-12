<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Talep;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TalepController extends Controller
{
    public function index(Request $request)
    {
        $talepler = Talep::with('urun')
            ->when($request->durum, fn ($q) => $q->where('durum', $request->durum))
            ->when($request->q, fn ($q) => $q->where(fn ($w) =>
                $w->where('ad', 'like', "%{$request->q}%")->orWhere('telefon', 'like', "%{$request->q}%")))
            ->latest()->paginate(20)->withQueryString();

        return view('panel.talepler.index', [
            'talepler' => $talepler,
            'durumlar' => Talep::DURUMLAR,
            'aktifDurum' => $request->durum,
        ]);
    }

    public function show(Talep $talep)
    {
        if ($talep->durum === 'yeni') {
            $talep->update(['durum' => 'okundu']);
        }

        return view('panel.talepler.show', ['talep' => $talep->load('urun'), 'durumlar' => Talep::DURUMLAR]);
    }

    public function updateDurum(Request $request, Talep $talep)
    {
        $request->validate(['durum' => ['required', 'in:yeni,okundu,arandi,sonuclandi']]);
        $talep->update(['durum' => $request->durum]);

        return back()->with('basari', 'Durum güncellendi.');
    }

    public function destroy(Talep $talep)
    {
        $talep->delete();

        return redirect()->route('panel.talepler.index')->with('basari', 'Talep silindi.');
    }

    /** Excel/CSV dışa aktarma. */
    public function export(): StreamedResponse
    {
        $dosyaAdi = 'teklif-talepleri-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $cikis = fopen('php://output', 'w');
            fprintf($cikis, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM (Excel TR)
            fputcsv($cikis, ['ID', 'Ad', 'Telefon', 'E-posta', 'İl/İlçe', 'İlgi Alanı', 'm²', 'Mesaj', 'Durum', 'Kaynak', 'Tarih'], ';');
            Talep::with('urun')->latest()->chunk(200, function ($grup) use ($cikis) {
                foreach ($grup as $t) {
                    fputcsv($cikis, [
                        $t->id, $t->ad, $t->telefon, $t->email, $t->il_ilce,
                        $t->ilgi_alani ?: optional($t->urun)->ad, $t->m2, $t->mesaj,
                        Talep::DURUMLAR[$t->durum] ?? $t->durum, $t->kaynak,
                        $t->created_at->format('d.m.Y H:i'),
                    ], ';');
                }
            });
            fclose($cikis);
        }, $dosyaAdi, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
