<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Soci;
use App\Road;
use App\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Storage;
use Notification;
use Validator;

class PerfilsController extends Controller
{
  public function index()
  {
    $soci = Auth::user()->soci;
    return view('profile.index')->with('soci',$soci);
  }

  public function edit()
	{
		$soci = Auth::user()->soci;
		$roads = Road::orderBy('road')->get();
		$addresses = Address::orderBy('address')->get();

		return view('profile.edit')->with('soci', $soci)->with('roads', $roads)->with('addresses', $addresses);
	}

  public function update(Request $request)
	{
		$name = $request->input('name');
		$surname = $request->input('surname');
		$secondSurname = $request->input('secondSurname');
		$dni = $request->input('dni');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$email = $request->input('email');
		$birthDate = $request->input('birthDate');
		$sex = $request->input('sex');

		$road = $request->input('road');
		$address = $request->input('address');
		$addressNum = $request->input('addressNum');
		$addressFloor = $request->input('addressFloor');
		$addressDoor = $request->input('addressDoor');
		$city = $request->input('city');
		$postalCode = $request->input('postalCode');
		$iban = $request->input('iban');
		$accountHolder = $request->input('accountHolder');
		$dniHolder = $request->input('dniHolder');
		$sociProtector = $request->input('sociProtector');
		$sociImg = $request->input('imgName');
		$correctIban = $request->input('correctIban');
		$imgChanged = $request->input('imgChanged');
		$prevImgName = $request->input('prevImgName');

		$soci = Soci::findOrFail($request->id);
		$soci->name = $name;
		$soci->surname = $surname;
		$soci->second_surname = $secondSurname;
		$soci->dni = $dni;
		$soci->phone = $phone;
		$soci->mobile = $mobile;
		$soci->birth_date = $birthDate;
		$soci->sex = $sex;
		$img_changed =filter_var($imgChanged, FILTER_VALIDATE_BOOLEAN);
		if ($img_changed) {
			if ($sociImg !=$prevImgName) {
				$soci->soci_img = $sociImg;
				//Movemos la imagen de la carpeta uploads a socis
				Storage::disk('public')->move('uploads/' . $sociImg, 'socis/' . $sociImg);				
			} else {
				if($prevImgName!='default.png'){
					Storage::disk('public')->delete('socis/'.$prevImgName);
					Storage::disk('public')->move('uploads/' . $sociImg, 'socis/' . $sociImg);				
				}
			}
		}
		$soci->email = $email;
		
		$soci->soci_protector = $sociProtector;

		$soci->road = $road;
		$soci->address = $address;
		$soci->address_num = $addressNum;
		if ($addressFloor != null)
			$soci->address_floor = $addressFloor;
		else
			$soci->address_floor = '';
		if ($addressFloor != null)
			$soci->address_door = $addressDoor;
		else
			$soci->address_door = '';
		$soci->postal_code = $postalCode;
		$soci->city = $city;
		if ($correctIban)
			$soci->iban = $iban;
		if ($accountHolder == null) {
			$accountHolder = $name . ' ' . $surname . ' ' . $secondSurname;
			$dniHolder = $dni;
		}
		$soci->account_holder = $accountHolder;
		$soci->dni_holder = $dniHolder;
		$soci->save();
		Address::firstOrCreate(['address' => $address]);

		Road::firstOrCreate(['road' => $road]);
		
		Notification::success('Soci actualitzat Correctament');
		return redirect()->route('socis');
  }
  
  public function uploadImage(Request $request)
	{
		$image = $request->image;
		$imgName = $request->imgName;
		$path = 'uploads/';
		list($type, $image) = explode(';', $image);
		list(, $image)      = explode(',', $image);
		$image = base64_decode($image);
		if ($imgName == 'default.png')
			$imgName = Str::random(8) . date('Ymdhm');
		$defaultExt = strpos($imgName, '.jpg');

		if ($defaultExt >= 0)
			$image_name = $imgName;
		if (!$defaultExt)
			$image_name = $imgName . '.jpg';
		$filePath = $path . $image_name;
		Storage::disk('public')->put($filePath, $image);
		return response()->json(['status' => true, 'imgName' => $image_name]);
  }
  
}
