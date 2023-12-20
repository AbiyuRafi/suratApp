<?php

namespace App\Exports;

use App\Models\Letter_types;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LetterTypeExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Letter_types::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Surat',
            'Klasifikasi Surat',
        ];
    }

    public function map($letter): array
    {
        return [
            $letter->id,
            $letter->letter_code,
            $letter->name_type,
        ];
    }
}
