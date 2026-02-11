<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private function getUser($id = null)
    {
        // Prioritize ID from URL if provided, otherwise first record
        if ($id) return \App\Models\User::findOrFail($id);
        return \App\Models\User::first();
    }

    public function index($id = null)
    {
        $user = $this->getUser($id);
        return view('user.profile', compact('user'));
    }

    public function update(Request $request, $id = null)
    {
        $user = $this->getUser($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'categories' => 'nullable|array',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_profil')) {
            // Delete old photo if exists
            if ($user->foto_profil && file_exists(public_path('uploads/profile_photos/' . $user->foto_profil))) {
                unlink(public_path('uploads/profile_photos/' . $user->foto_profil));
            }

            $file = $request->file('foto_profil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile_photos'), $filename);
            $user->foto_profil = $filename;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->whatsapp = $request->phone;
        $user->bidang = $request->categories;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
