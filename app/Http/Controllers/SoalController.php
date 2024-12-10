<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\Jawaban;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\JawabanSiswa;
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

    public function indexPublic()
    {
        // Mendapatkan sekolah user yang sedang login
        $asalSekolah = Auth::user()->asal_sekolah;
    
        // Query soal berdasarkan asal sekolah guru
        $soals = Soal::whereHas('guru', function ($query) use ($asalSekolah) {
            $query->where('asal_sekolah', $asalSekolah);
        })->get();
    
        return view('siswa.soals.index', compact('soals'));
    }

    // Menampilkan soal tertentu
    public function showPublic($id)
    {
        // Ambil soal berdasarkan ID
        $soal = Soal::findOrFail($id);

        return view('siswa.soals.show', compact('soal'));
    }

    // Menyimpan jawaban siswa
    public function submitJawaban(Request $request, $id)
    {
        // Validasi jawaban
        $request->validate([
            'jawaban' => 'required|string',
        ]);

        // Simpan jawaban siswa
        $siswa = Auth::user();
        $soal = Soal::findOrFail($id);

        // Simpan jawaban siswa ke tabel jawaban atau logika sesuai kebutuhan
        $soal->jawabans()->create([
            'siswa_id' => $siswa->id,
            'jawaban' => $request->jawaban,
            'is_correct' => $request->is_correct, // Jika ingin memeriksa jawaban
        ]);

        return redirect()->route('soals.indexPublic')->with('success', 'Jawaban berhasil disubmit!');
    }

//     public function showQuestion($soal_id)
// {
//     $soal = Soal::with('jawabans')->findOrFail($soal_id);

//     // Ambil soal berikutnya (berdasarkan ID)
//     $nextSoal = Soal::where('id', '>', $soal_id)->whereHas('guru', function ($query) {
//         $query->where('asal_sekolah', Auth::user()->asal_sekolah);
//     })->orderBy('id')->first();

//     return view('siswa.soals.question', compact('soal', 'nextSoal'));
// }
// public function submitAnswer(Request $request, $soal_id)
// {
//     $request->validate([
//         'jawaban_id' => 'required|exists:jawabans,id',
//     ]);

//     $siswa = Auth::user();

//     JawabanSiswa::create([
//         'siswa_id' => $siswa->id,
//         'soal_id' => $soal_id,
//         'jawaban_id' => $request->jawaban_id,
//     ]);

//     return redirect()->route('siswa.showQuestion', $request->next_soal_id ?? $soal_id)
//         ->with('success', 'Jawaban berhasil disimpan!');
// }
// public function showScore()
// {
//     $siswa = Auth::user();

//     // Ambil semua jawaban siswa
//     $jawabanSiswa = JawabanSiswa::where('siswa_id', $siswa->id)->get();

//     // Hitung skor berdasarkan jawaban yang benar
//     $totalSoal = $jawabanSiswa->count();
//     $jawabanBenar = 0;

//     foreach ($jawabanSiswa as $jawaban) {
//         $jawabanModel = Jawaban::find($jawaban->jawaban_id);
//         if ($jawabanModel && $jawabanModel->is_correct) {
//             $jawabanBenar++;
//         }
//     }

//     $skor = $totalSoal > 0 ? round(($jawabanBenar / $totalSoal) * 100) : 0;

//     return view('siswa.score', compact('skor', 'jawabanBenar', 'totalSoal'));
// }
// public function submitJawaban(Request $request, $id)
// {
//     $request->validate([
//         'jawaban_id' => 'required|exists:jawabans,id',
//     ]);

//     $siswa = Auth::user();
//     $jawabanId = $request->jawaban_id;

//     // Simpan jawaban siswa
//     JawabanSiswa::create([
//         'siswa_id' => $siswa->id,
//         'soal_id' => $id,
//         'jawaban_id' => $jawabanId,
//     ]);

//     // Periksa apakah ada soal berikutnya
//     $nextSoal = Soal::where('id', '>', $id)->whereHas('guru', function ($query) {
//         $query->where('asal_sekolah', Auth::user()->asal_sekolah);
//     })->first();

//     if ($nextSoal) {
//         // Jika ada soal berikutnya, arahkan ke soal berikutnya
//         return redirect()->route('siswa.showSoal', $nextSoal->id);
//     } else {
//         // Jika tidak ada soal lagi, arahkan ke halaman skor
//         return redirect()->route('siswa.score')->with('success', 'Anda telah menyelesaikan semua soal.');
//     }
// }
}