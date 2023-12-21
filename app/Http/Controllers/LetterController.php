<?php

namespace App\Http\Controllers;

use App\Exports\LettersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Letter;
use App\Models\letter_types;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use PDF;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */

        public function page()
        {
            $staff = User::where('role', 'staff')->count();
            $guru = User::where('role', 'guru')->count();
            $islogin = auth()->id();
            $notulis = Letter::where('notulis', $islogin)->count();
            $letters = Letter::all()->count();
            $letterTypes = Letter_types::count();
        
            return view('home', ['staff' => $staff, 'guru' => $guru, 'letterTypes' => $letterTypes,  'notulis' => $notulis,'letters' => $letters ]);
        }

        public function index()
        {
            $letters = Letter::with(['user', 'letter_types'])->paginate(5);
            return view('letters.index', compact('letters'));
        }
        

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $types = letter_types::all();
        $gurus = User::where('role', 'guru')->get();
        return view('letters.create', compact('types', 'gurus'));
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show($id)
    {
        $letters = Letter::with('letter_types')->find($id);
        
        if (!$letters) {
            abort(404);
        }
    
        return view('letters.print', compact('letters'));
    }
    
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
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $letter = Letter::find($id);
        $types = Letter_types::all();
        $gurus = User::where('role', 'guru')->get();

        return view('letters.edit', compact('letter', 'types', 'gurus'));
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Letter::where('id', $id)->delete();
        return redirect()->route('letters.index')->with('warning', 'Berhasil Menghapus Data');
    }

    public function export()
    {
        $fill = 'surat.xlsx';
        return Excel::download(new LettersExport, $fill);
    }
    public function exportExcel()
    {
        $fill = 'surat.xlsx';
        return Excel::download(new LettersExport, $fill);
    }
}
