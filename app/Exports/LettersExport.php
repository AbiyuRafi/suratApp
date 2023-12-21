<?php

namespace App\Exports;

use App\Models\Letter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LettersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Letter::with(['letter_types', 'notulisInfo'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Surat',
            'Perihal', 
            'Peserta',
            'Tentang Surat',
            'Notulis',
        ];
    }

    public function map($letters): array
    {
        return [
        $letters->id,
            optional($letters->letter_types)->letter_code,
            $letters->letter_perihal,
            implode(', ', $letters->recipients),
            $letters->content,
            optional($letters->notulis)->name,
        ];
    }    
}
