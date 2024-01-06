<?php

namespace App\Http\Controllers;

use App\Exports\LettersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Letter;
use App\Models\Letter_types;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Result;
use Illuminate\Support\Facades\Storage;
use PDF;

class LetterController extends Controller
{
    /**
     * Fungsi untuk mengonversi angka bulan menjadi angka Romawi.
     */
    private function romanNumerals($number) {
        $numerals = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];

        return $numerals[$number] ?? '';
    }
    /**
     * Menampilkan halaman dashboard.
     */
    public function page()
    {
        $staff = User::where('role', 'staff')->count();
        $guru = User::where('role', 'guru')->count();
        $islogin = auth()->id();
        $notulis = Letter::where('notulis', $islogin)->count();
        $letters = Letter::count(); 
        $letterTypes = Letter_types::count();
        $result = Result::count();  
    
        return view('home', ['staff' => $staff, 'guru' => $guru, 'letterTypes' => $letterTypes, 'notulis' => $notulis, 'letters' => $letters, 'result' => $result]);
    }
    
    /**
     * Menampilkan daftar surat.
     */
    public function index()
    {
        $letters = Letter::with(['user', 'letter_types'])->paginate(5);
        return view('letters.index', compact('letters'));
    }

    /**
     * Menampilkan formulir untuk membuat surat baru.
     */
    public function create()
    {
        $types = Letter_types::all();
        $gurus = User::where('role', 'guru')->get();

        // Pemanggilan fungsi romanNumerals pada bagian create atau di tempat lain yang membutuhkannya
        $romanMonth = $this->romanNumerals(date('m'));

        return view('letters.create', compact('types', 'gurus', 'romanMonth'));
    }

    /**
     * Menyimpan surat yang baru dibuat ke dalam penyimpanan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_type_id' => 'required|exists:letter_types,id',
            'letter_perihal' => 'required|min:3',
            'recipients' => 'required',
            'content' => 'required|min:3',
            'attachment' => 'file',
            'notulis' => 'required',
        ]);

        $attachment = $request->file('attachment')->store('attachment_directory', 'public');
        $nama_file = basename($attachment);
        
        Letter::create([
            'letter_type_id' => $request->input('letter_type_id'),
            'letter_perihal' => $request->input('letter_perihal'),
            'recipients' => $request->input('recipients'),
            'content' => $request->input('content'),
            'attachment' => $nama_file,
            'notulis' => $request->input('notulis'),
        ]);

        return redirect()->route('letters.index')->with('success', 'Surat berhasil ditambahkan');
    }

    /**
     * Menampilkan halaman detail surat.
     */
    public function show($id)
    {
        $letters = Letter::with('letter_types')->find($id);
        
        if (!$letters) {
            abort(404);
        }

        // Pemanggilan fungsi romanNumerals di dalam fungsi show
        $romanMonth = $this->romanNumerals(date('m', strtotime($letters->created_at)));

        return view('letters.print', compact('letters', 'romanMonth'));
    }

    /**
     * Mengunduh surat dalam format PDF.
     */
    public function downloadPDF($id)
    {
        $letters = Letter::with('letter_types')->find($id);
    
        if (!$letters) {
            abort(404);
        }

        view()->share('letters', $letters);
        
        // Panggil blade yang akan di-download 
        $pdf = PDF::loadView('letters.download-pdf', compact('letters'));
        
        // Kembalikan atau hasilkan bentuk pdf dengan nama file tertentu
        return $pdf->download('surat.pdf');
    }

    /**
     * Menampilkan formulir untuk mengedit surat.
     */
    public function edit($id)
    {
        $letter = Letter::find($id);
        $types = Letter_types::all();
        $gurus = User::where('role', 'guru')->get();

        return view('letters.edit', compact('letter', 'types', 'gurus'));
    }

    /**
     * Memperbarui surat dalam penyimpanan.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'letter_type_id' => 'required|exists:letter_types,id',
            'letter_perihal' => 'required|min:3',
            'recipients' => 'required',
            'content' => 'required|min:3',
            'attachment',
            'notulis' => 'required',
        ]);

        $letter = Letter::find($id);
        $letter->update([
            'letter_type_id' => $request->input('letter_type_id'),
            'letter_perihal' => $request->input('letter_perihal'),
            'recipients' => $request->input('recipients'),
            'content' => $request->input('content'),
            'attachment' => $request->input('attachment'),
            'notulis' => $request->input('notulis'),
        ]);

        return redirect()->route('letters.index')->with('success', 'Surat berhasil diperbarui');
    }

    /**
     * Menghapus surat dari penyimpanan.
     */
    public function destroy($id)
    {
        Letter::where('id', $id)->delete();
        return redirect()->route('letters.index')->with('warning', 'Berhasil Menghapus Data');
    }

    /**
     * Mengexport surat dalam format Excel.
     */
    public function export()
    {
        $fill = 'surat.xlsx';
        return Excel::download(new LettersExport, $fill);
    }

    /**
     * Mengexport surat dalam format Excel (sama seperti fungsi export).
     */
    public function exportExcel()
    {
        $fill = 'surat.xlsx';
        return Excel::download(new LettersExport, $fill);
    }
}
