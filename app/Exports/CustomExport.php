<?php

namespace App\Exports;

use App\Soci;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomExport implements FromArray,WithHeadings
{
    public function __construct(array $socis, array $socisHeadings)
    {
        $this->socis = $socis;
        $this->socisHeadings = $socisHeadings;
    }
    public function headings(): array
    {
        return $this->socisHeadings;
    }

    public function array(): array
    {
        return $this->socis;
    }
}
