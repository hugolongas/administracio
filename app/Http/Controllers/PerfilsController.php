<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Soci;
use App\Road;
use App\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;
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
		
		$phone = $request->input('phone');
		if($phone==null)
			$phone="";
		$mobile = $request->input('mobile');
		if ($mobile == null)
			$mobile = "";

		$email = $request->input('email');
		if($email==null)
			$email = "";
		$birthDate = $request->input('birthDate');
		if($birthDate==null)
			$birthDate='1900-01-01';
		$sex = $request->input('sex');

		$road = $request->input('road');
		if($road==null)
			$road="";
		$address = $request->input('address');
		if($address==null)
			$address="";
		$addressNum = $request->input('addressNum');
		if($addressNum==null)
			$addressNum="";
		$addressFloor = $request->input('addressFloor');
		if($addressFloor==null)
			$addressFloor="";
		$addressDoor = $request->input('addressDoor');
		if($addressDoor==null)
			$addressDoor="";
		$city = $request->input('city');
		if($city==null)
			$city="";
		$postalCode = $request->input('postalCode');
		if($postalCode==null)
			$postalCode="";
		$sociImg = $request->input('imgName');
		$imgChanged = $request->input('imgChanged');
		$prevImgName = $request->input('prevImgName');		

		$soci = Soci::findOrFail($request->id);
		$soci->name = $name;
		$soci->surname = $surname;
		$soci->second_surname = $secondSurname;		
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
		$soci->save();
		Address::firstOrCreate(['address' => $address]);

		Road::firstOrCreate(['road' => $road]);
		if(User::where('username',$soci->dni)->get()!=null)
		{
			if ($email != "") {
				$user = User::where('username',$soci->dni)->first();
				$user->name = $name . ' ' . $surname . ' ' . $secondSurname;				
				$user->email = $email;
				$user->save();
			}
		}
		Notification::success('Perfil actualitzat Correctament');
		return redirect()->route('profile');
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
