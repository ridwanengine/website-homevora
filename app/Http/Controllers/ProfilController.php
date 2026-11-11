<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        return view('profil');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // refresh object user
        Auth::setUser($user->fresh());

        return redirect()
            ->route('Profil')
            ->with('success', 'Profil berhasil diperbarui');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,jfif|max:2048',
        ]);

        // Ambil user yang sedang login
        $user = User::find(Auth::id());

        // Hapus foto lama jika ada
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Simpan foto baru
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->storeAs('profile', $filename, 'public');

        // Simpan path ke database
        $user->photo = 'profile/' . $filename;
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
        ]);

        $user = User::findOrFail(Auth::id());

        $user->update([
            'address' => $request->address,
        ]);

        return back()->with('success', 'Alamat berhasil diperbarui.');
    }
}
