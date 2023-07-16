<?php

namespace App\Imports;

use App\Soci;
use App\Address;
use App\Road;
use App\User;
use App\TipusSoci;
use App\Section;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DateTime;

class SociImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $member_number = $row['num_soci'];
            if ($member_number == null)
                $member_number = Soci::orderBy('id', 'desc')->first()->member_number + 1;
            $name = $row['nom'];
            $surname = $row['cognom'];
            if ($surname == null)
                $surname = "";
            $second_surname = $row['segon_cognom'];
            if ($second_surname == null)
                $second_surname = "";
            $dni = $row['dni'];
            if ($dni == null)
                $dni = "";
            $phone = $row['telefon'];
            if ($phone == null)
                $phone = "";
            $mobile = $row['mobil'];
            if ($mobile == null)
                $mobile = "";
            $birth_date = DateTime::createFromFormat('d/m/Y', $row['data_naixement']);
            $sex = $row['sexe'];
            if ($sex == null)
                $sex = "";
            $email = $row['email'];
            if ($email == null)
                $email = "";
            $register_date = DateTime::createFromFormat('d/m/Y', $row['data_alta_soci']);
            $unregister_date = DateTime::createFromFormat('d/m/Y', $row['data_baixa_soci']);
            if (!$unregister_date)
                $unregister_date = null;


            $tipus_soci = $row['tipus_soci'];
            $tSoci = TipusSoci::where('tipus_soci',$tipus_soci)->first();
            $cuota_soci = $tSoci->cuota_soci;
            if (strtolower($tipus_soci) == 'protector')
                $cuota_soci = $row['cuota_soci'];
                
            $observacions = $row['observacions'];
            if ($observacions == null)
                $observacions = "";

            $road = $row['via'];
            if ($road == null)
                $road = "";
            $address = $row['carrer'];
            if ($address == null)
                $address = "";
            $address_num = $row['num_carrer'];
            if ($address_num == null)
                $address_num = "";
            $address_floor = $row['pis'];
            if ($address_floor == null)
                $address_floor = '';
            $address_door = $row['porta'];
            if ($address_door == null)
                $address_door = '';
            $postal_code = $row['codi_postal'];
            if ($postal_code == null)
                $postal_code = '';
            $city = $row['ciutat'];
            if ($city == null)
                $city = $row['porta'];
            $iban = $row['iban'];
            if ($iban == null)
                $iban = '';
            $account_holder = $row['titular_compte'];
            if ($account_holder == null)
                $account_holder = '';
            $dni_holder = $row['dni_titular'];
            if ($dni_holder == null)
                $dni_holder = '';

            if ($name != null) {
                $soci = new Soci;
                $soci->member_number = $member_number;
                $soci->name = $name;
                $soci->surname = $surname;
                $soci->second_surname = $second_surname;
                $soci->dni = $dni;
                $soci->phone = $phone;
                $soci->mobile = $mobile;
                $soci->birth_date = $birth_date;
                $soci->sex = $sex;
                $soci->soci_img = 'default.png';
                $soci->email = $email;
                $soci->register_date = $register_date;
                $soci->unregister_date = $unregister_date;                
                $soci->road = $road;
                $soci->address = $address;
                $soci->address_num = $address_num;
                $soci->address_floor = $address_floor;
                $soci->address_door = $address_door;
                $soci->postal_code = $postal_code;
                $soci->city = $city;
                $soci->iban = $iban;
                $soci->account_holder = $account_holder;
                $soci->dni_holder = $dni_holder;
                $soci->tipus_soci = $tipus_soci;
                $soci->cuota_soci = $cuota_soci;
                $soci->observacions = $observacions;
                $soci->save();
                $insertedId = $soci->id;

                Address::firstOrCreate(['address' => $address]);

                Road::firstOrCreate(['road' => $road]);

                if ($email != "" && $dni != "") {
                    $user = new User;
                    $user->soci_id = $insertedId;
                    $user->name = $name . ' ' . $surname . ' ' . $second_surname;
                    $user->username = $dni;
                    $user->email = $email;
                    $user->password = bcrypt(str_random(8));
                    $user->save();
                    $section = Section::findOrFail(2);			
                    $section->users()->attach($user);
                }
            }
        }
    }
}
