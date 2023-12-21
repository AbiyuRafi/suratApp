<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Letter;
use App\Models\User;
use App\Exports\LettersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use PDF;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $login = auth()->id();
        $results = Letter::with(['user', 'letter_types'])
            ->where('notulis', $login)
            ->paginate(5);
    
        $letters = Letter::all();
        $users = User::Where('role', 'guru')->get();

        return view('result.create', compact('results', 'letters', 'users'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $users = User::Where('role', 'guru')->get();
        $letters = Letter::Where('id', $id)->get();

        return view('result.create', compact('users', 'letters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $arrayDistinct = is_array($request->presence_recipients)
        ? array_count_values($request->presence_recipients)
        : [];

    $arrayAssoc = [];

    foreach ($arrayDistinct as $id => $count) {
        $user = User::find($id);

        // Check if the user is found before accessing the 'name' property
        if ($user) {
            $arrayItem = [
                "id" => $id,
                "name" => $user->name,
            ];

            array_push($arrayAssoc, $arrayItem);
        }
    }

    $request['presence_recipients'] = $arrayAssoc;

    Result::create([
        'letter_id' => $request->letter_id,
        'presence_recipients' => $request->presence_recipients,
        'notes' => $request->notes,
        ]);

    return redirect()->route('result.index')->with('success', 'Berhasil Memberi Ringkasan Hasil Rapat');
}
public function exportExcel()
{
    $fill = 'surat.xlsx';
    return Excel::download(new LettersExport, $fill);
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
    
        return view('result.print', compact('letters'));
    }
    
    public function downloadPDF($id)
    {
        $letters = Letter::with('letter_types')->find($id);
    
        if (!$letters) {
            abort(404);
        }

        view()->share('letters', $letters);
        
        // Panggil blade yang akan di-download 
        $pdf = PDF::loadView('result.download-pdf', compact('letters'));
        
        // Kembalikan atau hasilkan bentuk pdf dengan nama file tertentu
        return $pdf->download('surat.pdf');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        //
    }
}
