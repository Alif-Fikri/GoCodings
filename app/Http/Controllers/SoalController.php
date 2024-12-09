<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\Jawaban;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RoleMiddleware;

class SoalController extends Controller
{
    // Menampilkan dashboard guru
    public function index()
    {
        $soals = Soal::where('guru_id', Auth::id())->with('jawabans')->get();
        return view('guru.dashboard', compact('soals'));
    }

    // Menampilkan form untuk menambahkan soal baru
    public function create()
    {
        return view('guru.createsoal');
    }

    // Menyimpan soal baru
    public function store(Request $request)
    {
        $request->validate([
            'soal' => 'required|string',
            'jawaban.*.text' => 'required|string',
            'jawaban.*.is_correct' => 'required|boolean',
        ]);

        // Simpan soal
        $soal = Soal::create([
            'soal' => $request->soal,
            'guru_id' => Auth::id(),
        ]);

        // Simpan jawaban
        foreach ($request->jawaban as $jawaban) {
            Jawaban::create([
                'soal_id' => $soal->id,
                'jawaban' => $jawaban['text'],
                'is_correct' => $jawaban['is_correct'],
            ]);
        }

        return redirect()->route('guru.dashboard')->with('success', 'Soal berhasil ditambahkan!');
    }

    // Menampilkan form edit soal
    public function edit($id)
    {
        $soal = Soal::with('jawabans')->findOrFail($id);

        if ($soal->guru_id != Auth::id()) {
            abort(403);
        }

        return view('guru.editsoal', compact('soal'));
    }

    // Mengupdate soal dan jawaban
    public function update(Request $request, $id)
    {
        $request->validate([
            'soal' => 'required|string',
            'jawaban.*.id' => 'nullable|integer|exists:jawabans,id',
            'jawaban.*.text' => 'required|string',
            'jawaban.*.is_correct' => 'required|boolean',
        ]);

        $soal = Soal::findOrFail($id);

        if ($soal->guru_id != Auth::id()) {
            abort(403);
        }

        $soal->update(['soal' => $request->soal]);

        // Update atau tambahkan jawaban
        foreach ($request->jawaban as $jawabanData) {
            if (isset($jawabanData['id'])) {
                // Update jawaban yang ada
                $jawaban = Jawaban::findOrFail($jawabanData['id']);
                $jawaban->update([
                    'jawaban' => $jawabanData['text'],
                    'is_correct' => $jawabanData['is_correct'],
                ]);
            } else {
                // Tambahkan jawaban baru
                Jawaban::create([
                    'soal_id' => $soal->id,
                    'jawaban' => $jawabanData['text'],
                    'is_correct' => $jawabanData['is_correct'],
                ]);
            }
        }

        return redirect()->route('guru.dashboard')->with('success', 'Soal berhasil diperbarui!');
    }

    // Menghapus soal dan jawaban terkait
    public function destroy($id)
    {
        $soal = Soal::findOrFail($id);

        if ($soal->guru_id != Auth::id()) {
            abort(403);
        }

        // Hapus jawaban terkait
        $soal->jawabans()->delete();

        // Hapus soal
        $soal->delete();

        return redirect()->route('guru.dashboard')->with('success', 'Soal berhasil dihapus!');
    }
}
