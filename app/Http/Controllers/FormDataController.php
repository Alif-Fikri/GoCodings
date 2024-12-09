<?php
namespace App\Http\Controllers;

use App\Models\Guru; 
use App\Models\Siswa; 
use Illuminate\Http\Request;
use App\Models\User;

class FormDataController extends Controller
{
    public function saveUserData(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:gurus,email|unique:siswa,email',
            'asal_sekolah' => 'required|string|max:255',
            'jenjang_pendidikan' => 'required|string',
            'role' => 'required|string|in:gurus,siswa',
        ]);
    
        $role = $request->input('role');
    
        if ($role === 'gurus') {
            Guru::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'asal_sekolah' => $request->asal_sekolah,
                'jenjang_pendidikan' => $request->jenjang_pendidikan,
            ]);
    
            return redirect()->route('guru.dashboard')->with('success', 'Data guru berhasil disimpan.');
        } elseif ($role === 'siswa') {
            Siswa::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'asal_sekolah' => $request->asal_sekolah,
                'jenjang_pendidikan' => $request->jenjang_pendidikan,
            ]);
    
            return redirect()->route('soals.indexPublic')->with('success', 'Data siswa berhasil disimpan.');
        }
    
        return redirect()->back()->with('error', 'Role tidak valid.');
    }
    
}
