<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use App\Soci;
use App\Road;
use App\Address;
use App\User;
use App\SociBaixa;
use App\Section;
use App\TipusSoci;
use Storage;
use Notification;
use Validator;
use App\Imports\SociImport;
use App\Exports\SociExport;
use Maatwebsite\Excel\Facades\Excel;
use League\Flysystem\Exception;
use Redirect;
use App\Exports\CustomExport;

class SocisController extends Controller
{
	public function index(Request $request)
	{
		if ($request->ajax()) {
            $socis = Soci::all();
            return Datatables::of($socis)->make(true);
        }        
		return view('socis.index');
	}
	
	public function	show($id)
	{
		$soci = Soci::findOrFail($id);
		return view('socis.show')->with('soci', $soci);
	}

	public function create()
	{
		$lastMemberNumber = Soci::orderBy('id', 'desc')->first()->member_number + 1;
		$roads = Road::orderBy('road')->get();
		$addresses = Address::orderBy('address')->get();
		$tipusSocis = TipusSoci::all();
		return view('socis.create')
		->with('memberNumber', $lastMemberNumber)
		->with('roads', $roads)
		->with('addresses', $addresses)
		->with('tipusSocis', $tipusSocis);
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'surname' => 'required',
			'secondSurname' => 'required'
			]);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		}
		$name = $request->input('name');
		$surname = $request->input('surname');
		$secondSurname = $request->input('secondSurname');

		$dni = $request->input('dni');
		if($dni==null)
			$dni = "";
		
		$phone = $request->input('phone');
		if($phone==null)
			$phone = "";

		$mobile = $request->input('mobile');
		if ($mobile == null)
			$mobile = "";

		$email = $request->input('email');
		if($email==null)
			$email = "";

		$birthDate = $request->input('birthDate');
		if($birthDate==null)
			$birthDate=date('Y-m-d');

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
		if ($addressFloor == null)
			$addressFloor = '';

		$addressDoor = $request->input('addressDoor');
		if($addressDoor==null)
			$addressDoor="";

		$city = $request->input('city');
		if($city==null)
			$city="";

		$postalCode = $request->input('postalCode');
		if($postalCode==null)
			$postalCode="";

		$iban = $request->input('iban');
		$correctIban = $request->input('correctIban');
		if($iban==null)
		{
			$iban = "";
			$correctIban = true;
		}
		$accountHolder = $request->input('accountHolder');
		$dniHolder = $request->input('dniHolder');
		$sociImg = $request->input('imgName');

		//Cuota Soci
		$tipus = $request->input('tipusSoci');
		$tipusSoci = TipusSoci::where('tipus_soci',$tipus)->get();
		$tSoci = $tipusSoci[0]->tipus_soci;
		$cuotaSoci = $tipusSoci[0]->cuota_soci;
		if($tSoci=='Protector')
		{
			$cuotaSoci = $request->input('cuotaSoci');
		}
		$observacions = $request->input('observacions');
		if($observacions==null)
			$observacions = "";

		$soci = new Soci;
		$soci->member_number = Soci::orderBy('id', 'desc')->first()->member_number + 1;
		$soci->name = $name;
		$soci->surname = $surname;
		$soci->second_surname = $secondSurname;
		$soci->dni = $dni;
		$soci->phone = $phone;
		$soci->mobile = $mobile;
		$soci->birth_date = $birthDate;
		$soci->sex = $sex;
		if ($sociImg != '') {
			$soci->soci_img = $sociImg;
			//Movemos la imagen de la carpeta uploads a socis
			Storage::disk('public')->move('uploads/' . $sociImg, 'socis/' . $sociImg);
		} else {
			$soci->soci_img = 'default.png';
		}

		$soci->email = $email;
		$soci->register_date = date('Y-m-d');
		$soci->unregister_date = null;		
		$soci->road = $road;
		$soci->address = $address;
		$soci->address_num = $addressNum;
		$soci->address_floor = $addressFloor;
		$soci->address_door = $addressDoor;		
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
		$soci->tipus_soci=$tSoci;
		$soci->cuota_soci=$cuotaSoci;
		$soci->observacions = $observacions;
		$soci->save();

		$inseredID = $soci->id;

		Address::firstOrCreate(['address' => $address]);

		Road::firstOrCreate(['road' => $road]);		
		if(User::where('username',$dni)->first()==null){
			if ($email != "" && $dni != "") {
				$user = new User;
				$user->soci_id = $inseredID;
				$user->name = $name . ' ' . $surname . ' ' . $secondSurname;
				$user->username = $dni;
				$user->email = $email;
				$user->password = bcrypt(str_random(8));
				$user->save();
	
				$section = Section::findOrFail(2);
				$section->users()->attach($user);
				Notification::success('Soci Creat Correctament amb usuari');
			}
			else
			{
				Notification::success('Soci Creat Correctament sense usuari ja que no te  dni o e-mail');
			}		
		}		
		else{
			Notification::success('Soci Creat Correctament sense usuari ja que ja existeix un usuari amb aquest dni');
		}
		
		return redirect()->route('socis.show', $inseredID);
	}

	public function edit($id)
	{
		$soci = Soci::findOrFail($id);
		$roads = Road::orderBy('road')->get();
		$addresses = Address::orderBy('address')->get();
		$tipusSocis = TipusSoci::all();
		return view('socis.edit')
		->with('soci', $soci)
		->with('roads', $roads)
		->with('addresses', $addresses)
		->with('tipusSocis', $tipusSocis);
	}

	public function update(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'surname' => 'required',
			'secondSurname' => 'required'
		]);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		}

		$name = $request->input('name');
		$surname = $request->input('surname');
		$secondSurname = $request->input('secondSurname');

		$dni = $request->input('dni');
		if($dni==null)
			$dni="";
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
		$iban = $request->input('iban');
		$correctIban = $request->input('correctIban');
		if($iban==null)
		{
			$iban = "";
			$correctIban = true;
		}
		$accountHolder = $request->input('accountHolder');
		$dniHolder = $request->input('dniHolder');		
		$sociImg = $request->input('imgName');		
		$imgChanged = $request->input('imgChanged');
		$prevImgName = $request->input('prevImgName');

		//Cuota Soci
		$tipus = $request->input('tipusSoci');
		$tipusSoci = TipusSoci::where('tipus_soci',$tipus)->get();
		$tSoci = $tipusSoci[0]->tipus_soci;
		$cuotaSoci = $tipusSoci[0]->cuota_soci;
		if($tSoci=='Protector')
		{
			$cuotaSoci = $request->input('cuotaSoci');
		}
		$observacions = $request->input('observacions');
		if($observacions==null)
			$observacions = "";

		$soci_id = $request->id;
		$soci = Soci::findOrFail($soci_id);
		$soci->name = $name;
		$soci->surname = $surname;
		$soci->second_surname = $secondSurname;
		$soci->dni = $dni;
		$soci->phone = $phone;
		$soci->mobile = $mobile;
		$soci->birth_date = $birthDate;
		$soci->sex = $sex;
		$img_changed = filter_var($imgChanged, FILTER_VALIDATE_BOOLEAN);
		if ($img_changed) {
			if ($sociImg != $prevImgName) {
				$soci->soci_img = $sociImg;
				//Movemos la imagen de la carpeta uploads a socis
				Storage::disk('public')->move('uploads/' . $sociImg, 'socis/' . $sociImg);
			} else {
				if ($prevImgName != 'default.png') {
					Storage::disk('public')->delete('socis/' . $prevImgName);
					Storage::disk('public')->move('uploads/' . $sociImg, 'socis/' . $sociImg);
				}
			}
		}
		$soci->email = $email;
		$soci->road = $road;
		$soci->address = $address;
		$soci->address_num = $addressNum;
		$soci->address_floor = $addressFloor;		
		$soci->address_door = $addressDoor;		
		$soci->postal_code = $postalCode;
		$soci->city = $city;
		$soci->tipus_soci=$tSoci;
		$soci->cuota_soci=$cuotaSoci;
		$soci->observacions = $observacions;

		if ($correctIban)
			$soci->iban = $iban;
		if ($accountHolder == null) {
			$accountHolder = $name . ' ' . $surname . ' ' . $secondSurname;
			$dniHolder = $dni;
		}
		if($dniHolder==null)
			$dniHolder = "";
		$soci->account_holder = $accountHolder;
		$soci->dni_holder = $dniHolder;

		
		$soci->save();
		Address::firstOrCreate(['address' => $address]);

		Road::firstOrCreate(['road' => $road]);				
		if(User::where('username',$dni)->first()!=null)
		{

			if ($email != "" && $dni != "") {
				$user = User::where('username',$dni)->first();
				$user->name = $name . ' ' . $surname . ' ' . $secondSurname;				
				$user->email = $email;
				$user->save();
				
				$section = Section::findOrFail(2);
				$section->users()->attach($user);
			}
			Notification::success('Soci actualitzat Correctament');
		}
		else{
			if ($email != "" && $dni != "") {
				$user = new User;
				$user->soci_id = $soci_id;
				$user->name = $name . ' ' . $surname . ' ' . $secondSurname;
				$user->username = $dni;
				$user->email = $email;
				$user->password = bcrypt(str_random(8));
				$user->save();
				$section = Section::findOrFail(2);
				$section->users()->attach($user);
				Notification::success("Soci actualitzat Correctament i s'ha creat un usuari");
			}
		}

		
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

	public function import()
	{
		return view('socis.import');
	}

	public function importSocis(Request $request)
	{
		try {
			if ($request->hasFile('sample_file')) {
				$path = $request->file('sample_file')->getRealPath();
				$data = Excel::Import(new SociImport, $path);
			}
			Notification::success('Soci Importats');
			return redirect()->route('socis');
		} catch (\Exception $ex) {
			Notification::error($ex->getMessage());
			return  redirect()->back();
		}
	}

	public function delete($id)
	{
		$soci = Soci::findOrFail($id);
		$user = User::where('soci_id', $id);
		$soci->delete();
		$user->delete();
	}

	public function unregisterMotive()
	{
		$unregisterMotives = SociBaixa::select('unregister_motive')->distinct()->get();
		return $unregisterMotives;
	}

	public function reactivate($id)
	{
		$soci = Soci::findOrFail($id);
		$sociBaixa = SociBaixa::where('soci_id', $id)->where('reactivation_date', null)->first();
		$soci->unregister_date = null;
		$soci->save();
		$sociBaixa->reactivation_date = date('Y-m-d');
		$sociBaixa->save();
	}

	public function unregister(Request $request)
	{
		$unregisterMotive = $request->input('motive');
		$soci = Soci::findOrFail($request->id);
		$soci->unregister_date = date('Y-m-d');
		$soci->save();
		$sociBaixa = new SociBaixa();
		$sociBaixa->soci_id = $request->id;
		$sociBaixa->unergister_date = date('Y-m-d');
		$sociBaixa->unregister_motive = $unregisterMotive;
		$sociBaixa->save();

		if(User::where('soci_id',$soci->id)->first()!=null)
		{
			$user = User::where('soci_id',$soci->id)->first();
			$user->active = 0;
			$user->save();
		}
	}

	public function export()
	{
		Notification::success('Taula de socis Exportada');
		return Excel::download(new SociExport, 'socis.xlsx');
	}

	public function findSoci($dni)
	{
		$user = DB::select('call soci_by_dni($dni)');
	}
}
