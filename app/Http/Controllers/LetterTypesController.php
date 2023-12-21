<?php

namespace App\Http\Controllers;

use App\Exports\LetterTypeExport;
use App\Models\Letter;
use App\Models\Letter_types;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class LetterTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $letters = Letter_types::simplePaginate(5);
        return view('klasifikasi.index', compact('letters'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('klasifikasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_code' => 'required|max:7',
            'name_type' => 'required|min:3'
        ]);
    
        $letter = Letter_types::create([
            'letter_code' => $request->letter_code,
            'name_type' => $request->name_type
        ]);
    
        if ($letter) {
            $kodeSurat = $request->letter_code . "-" . $letter->id;
    
            $letter->update(['letter_code' => $kodeSurat]);
    
            return redirect()->route('klasifikasi.index')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->route('klasifikasi.index')->with('error', 'Data tidak dapat ditambahkan. Terjadi kesalahan.');
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $letters = Letter::find($id);
        return view('klasifikasi.print', compact('letters'));
    }

    public function downloadPDF($id)
    {
        // ambil data yang diperlukan, dan pastikan data berformat array
        $letters = Letter::find($id)->toArray();
        // mengirim inisial variable dari data yang akan digunakan pada layout pdf
        view()->share('letters', $letters);
        // panggil blade yang akan di download 
        $pdf = PDF::loadView('klasifikasi.download-pdf', $letters);
        // kembalikan atau hasilkan bentuk pdf dengan nama file tertentu
        return $pdf->download('surat.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $letter_types = Letter_types::find($id);
        return view('klasifikasi.edit', compact('letter_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'letter_code' => 'required|min:4',
            'name_type' => 'required'
        ]);
        
        Letter_types::where('id', $id)->update([
            'letter_code' => $request->letter_code,
            'name_type' => $request->name_type
        ]);

        return redirect()->route('klasifikasi.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Letter_types::where('id', $id)->delete();
        return redirect()->route('klasifikasi.index')->with('success', 'Data berhasil dihapus');
    }

    public function export()
    {
        $fill = 'klasifikasi surat.xlsx';
        return Excel::download(new LetterTypeExport, $fill);
    }
    
}
