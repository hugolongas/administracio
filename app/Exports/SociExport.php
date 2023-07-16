<?php

namespace App\Exports;

use App\Soci;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SociExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'num_soci',
            'nom',
            'cognom',
            'segon_cognom',
            'dni',
            'telefon',
            'mobil',
            'data_naixement',
            'sexe',
            'email',
            'data_alta_soci',
            'data_baixa_soci',
            'tipus_soci',
            'cuota_soci',
            'observacions',
            'via',
            'carrer',
            'num_carrer',
            'pis',
            'porta',
            'codi_postal',
            'ciutat',
            'iban',
            'titular_compte',
            'dni_titular'
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $socis = Soci::select(
        'member_number',
        'name',
        'surname',
        'second_surname',
        'dni',
        'phone',
        'mobile',
        'birth_date',
        'sex',
        'email',
        'register_date',
        'unregister_date',
        'tipus_soci',
        'cuota_soci',
        'observacions',
        'road',
        'address',
        'address_num',
        'address_floor',
        'address_door',
        'postal_code',
        'city',
        'iban',
        'account_holder',
        'dni_holder'
        )->get();
        return $socis;
    }
}
