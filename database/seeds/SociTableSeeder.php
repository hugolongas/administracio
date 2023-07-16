<?php

use Illuminate\Database\Seeder;
use App\Soci;
use App\User;
use App\Address;
use App\Road;

class SociTableSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->arraySocis as $s) {

            $memberNumber = $s['memberNumber'];
            $name = $s['name'];
            $surname = $s['surname'];
            $secondSurname = $s['secondSurname'];
            $dni = $s['dni'];
            $phone = $s['phone'];
            $mobile = $s['mobile'];
            $birthDate = $s['birthDate'];
            $sex = $s['sex'];
            $soci_img = $s['sociImg'];
            $email = $s['email'];

            $registerDate = $s['registerDate'];
            $unregisterDate = $s['unregisterDate'];
            $sociProtector = $s['sociProtector'];

            $road = $s['road'];
            $address = $s['address'];
            $addressNum = $s['addressNum'];
            $addressFloor = $s['addressFloor'];
            $addressDoor = $s['addressDoor'];
            $postCode = $s['postCode'];
            $city = $s['city'];
            $iban = $s['iban'];
            $accountHolder = $s['accountHolder'];
            $dniHolder = $s['dniHolder'];

            $soci = new Soci;
            $soci->member_number = $memberNumber;
            $soci->name = $name;
            $soci->surname = $surname;
            $soci->second_surname = $secondSurname;
            $soci->dni = $dni;
            $soci->phone = $phone;
            $soci->mobile = $mobile;
            $soci->birth_date = $birthDate;
            $soci->sex = $sex;
            $soci->soci_img = $soci_img;
            $soci->email = $email;

            $soci->register_date = $registerDate;
            $soci->unregister_date = $unregisterDate;
            $soci->soci_protector = $sociProtector;

            $soci->road = $road;
            $soci->address = $address;
            $soci->address_num = $addressNum;
            $soci->address_floor = $addressFloor;
            $soci->address_door = $addressDoor;
            $soci->postal_code = $postCode;
            $soci->city = $city;
            $soci->iban = $iban;
            $soci->account_holder = $accountHolder;
            $soci->dni_holder = $dniHolder;
            $soci->save();

            Address::firstOrCreate(['address' => $address]);
            Road::firstOrCreate(['road' => $road]);

            $user = new User;
            $user->soci_id = $soci->id;
            $user->name = $soci->name.'  '.$soci->surname.' '.$soci->secondSurname;
            $user->username = $soci->dni;
            $user->email = $soci->email;
            $user->password = bcrypt($s['password']);
            $user->save();

            
        }
    }

    private $arraySocis = array(
        array(
            'memberNumber' => '478124',
            'name' => 'Hugo',
            'surname' => 'Longás',
            'secondSurname' => 'Costa',
            'dni' => '47811275W',
            'phone' => 938414917,
            'mobile' => 667746281,
            'birthDate' => '1985-05-15',
            'sex' => 'Home',
            'email' => 'hugolo3@gmail.com',
            'sociImg' => 'hugo_longas_costa.jpg',
            'sociProtector' => false,

            'registerDate' => '1990-01-01',
            'unregisterDate' => null,

            'road' => 'Carrer',
            'address' => 'Can Carreras',
            'addressNum' => '6',
            'addressFloor' => '',
            'addressDoor' => '',
            'postCode' => '08186',
            'city' => 'Lliçà d\'Amunt',

            'iban' => 'ESIBAN',
            'accountHolder' => 'Hugo Longás Costa',
            'dniHolder' => '47811275W',

            'password' => 'longas123'
        )
    );
}
