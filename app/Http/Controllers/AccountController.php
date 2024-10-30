<?php

namespace App\Http\Controllers;

use App\Models\MapsRecycleOrg;
use App\Models\MapsUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function loading()
    {
        return view('start');
    }

    public function register()
    {
        return view('account.register');
    }

    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'phonenumber' => 'required',
            'role' => 'required|in:user,recycleorg',
            'location' => 'required', // Validasi lokasi
            'password_confirmation' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }

        // Register user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phonenumber = $request->phonenumber;
        $user->role = $request->role;
        $user->location = $request->location;
        $user->password = Hash::make($request->password);
        $user->save();

        $latitude = $request->latitude; // Ambil latitude dari input tersembunyi
        $longitude = $request->longitude; // Ambil longitude dari input tersembunyi

        if ($user->role === 'user') {
            MapsUser::create([
                'user_id' => $user->id,
                'address' => $request->location, // Simpan alamat
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
        } elseif ($user->role === 'recycleorg') {
            MapsRecycleOrg::create([
                'user_id' => $user->id,
                'address' => $request->location, // Simpan alamat
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
        }


        return redirect()->route('account.login')->with('success', 'You have registered successfully.');
    }


    public function login()
    {
        return view('account.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'role' => 'required|in:user,recycleorg',
            'password' => 'required'


        ]);

        if ($validator->fails()) {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('account.profile');
        } else {
            return redirect()->route('account.login')->with('error', 'Either email or password is incorrect.');
        }
    }

    // show user profile page
    public function profile()
    {
        $user = User::find(Auth::user()->id);
        $mapData = MapsUser::where('user_id', $user->id)->first();
        return view('account.profile', [
            'user' => $user,
            'mapData' => $mapData
        ]);
    }

    // update user profile
    public function updateProfile(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id . ',id',
            'phonenumber' => 'required',
            'role' => 'required|in:user,recycleorg',
            'location' => 'required', // Validasi lokasi

        ];



        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('account.profile')->withInput()->withErrors($validator);
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phonenumber = $request->phonenumber;
        $user->role = $request->role;
        $user->location = $request->location;
        $user->save();

        $latitude = $request->latitude; // Ambil latitude dari input tersembunyi
        $longitude = $request->longitude; // Ambil longitude dari input tersembunyi

        if ($user->role === 'user') {
            MapsUser::create([
                'user_id' => $user->id,
                'address' => $request->location, // Simpan alamat
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
        } elseif ($user->role === 'recycleorg') {
            MapsRecycleOrg::create([
                'user_id' => $user->id,
                'address' => $request->location, // Simpan alamat
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
        }


        // // upload image
        // if (!empty($request->image)) {

        //     // delete old image
        //     File::delete(public_path('uploads/profile/' . $user->image));
        //     File::delete(public_path('uploads/profile/thumb/' . $user->image));

        //     $image = $request->image;
        //     $ext = $image->getClientOriginalExtension();
        //     $imageName = time() . '.' . $ext;
        //     $image->move(public_path('uploads/profile'), $imageName);
        //     $user->image = $imageName;
        //     $user->save();
        // }

        return redirect()->route('account.profile')->with('success', 'Profile updated successfully');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }


    // public function processRegister(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|min:3',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|confirmed|min:5',
    //         'phonenumber' => 'required',
    //         'role' => 'required|in:user,recycleorg',
    //         'password_confirmation' => 'required'
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->route('account.register')->withInput()->withErrors($validator);
    //     }

    //     // Register user
    //     $user = new User();
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->phonenumber = $request->phonenumber;
    //     $user->role = $request->role;
    //     $user->password = Hash::make($request->password);
    //     $user->save();

    //     return redirect()->route('account.login')->with('success', 'You have registered succesfully.');
    // }

    // private function getCoordinatesFromAddress($address)
    // {
    //     $apiKey = env('GOOGLE_MAPS_API_KEY');
    //     $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key={$apiKey}";



    //     $response = file_get_contents($url);
    //     $data = json_decode($response, true);

    //     if ($data['status'] === 'OK') {
    //         return [
    //             'latitude' => $data['results'][0]['geometry']['location']['lat'],
    //             'longitude' => $data['results'][0]['geometry']['location']['lng'],
    //         ];
    //     }

    //     return ['latitude' => null, 'longitude' => null];
    // }




}
