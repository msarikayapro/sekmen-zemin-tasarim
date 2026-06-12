<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KullaniciController extends Controller
{
    public function index()
    {
        $kullanicilar = User::orderByDesc('id')->paginate(20);

        return view('panel.kullanicilar.index', compact('kullanicilar'));
    }

    public function create()
    {
        return view('panel.kullanicilar.form', ['kullanici' => new User(['rol' => 'editor', 'aktif' => true])]);
    }

    public function store(Request $request)
    {
        $veri = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'unique:users,email'],
            'telefon' => ['nullable', 'string', 'max:30'],
            'rol' => ['required', 'in:admin,editor'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $veri['password'] = Hash::make($veri['password']);
        $veri['aktif'] = $request->boolean('aktif');
        User::create($veri);

        return redirect()->route('panel.kullanicilar.index')->with('basari', 'Kullanıcı eklendi.');
    }

    public function edit(User $kullanici)
    {
        return view('panel.kullanicilar.form', compact('kullanici'));
    }

    public function update(Request $request, User $kullanici)
    {
        $veri = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($kullanici->id)],
            'telefon' => ['nullable', 'string', 'max:30'],
            'rol' => ['required', 'in:admin,editor'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if ($request->filled('password')) {
            $veri['password'] = Hash::make($request->password);
        } else {
            unset($veri['password']);
        }
        $veri['aktif'] = $request->boolean('aktif');
        $kullanici->update($veri);

        return redirect()->route('panel.kullanicilar.index')->with('basari', 'Kullanıcı güncellendi.');
    }

    public function destroy(Request $request, User $kullanici)
    {
        if ($kullanici->id === $request->user()->id) {
            return back()->withErrors(['kullanici' => 'Kendi hesabınızı silemezsiniz.']);
        }
        $kullanici->delete();

        return back()->with('basari', 'Kullanıcı silindi.');
    }
}
