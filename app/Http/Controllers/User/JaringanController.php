<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jaringan;

class JaringanController extends Controller
{
    private function getUser()
    {
        return \App\Models\User::first();
    }

    public function show($id)
    {
        $user = $this->getUser();
        $mitra = \App\Models\Jaringan::with('layanan')->findOrFail($id);
        return view('user.mitra.show', compact('mitra', 'user'));
    }
}
