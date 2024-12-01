<?php

namespace App\Http\Controllers;

use App\Models\MapsRecycleOrg;
use App\Models\MapsUser;
use App\Models\User;
use App\Models\WasteData;
use App\Models\wasteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function loading()
    {
        return view('start');
    }

    public function homeUser()
    {
        $user = User::find(Auth::user()->id);
        return view('home.homeUser', [
            'user' => $user
        ]);
    }

    public function homeRO()
    {
        $user = User::find(Auth::user()->id);
        return view('home.homeRO', [
            'user' => $user
        ]);
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

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => $request->role])) {
            $user = Auth::user(); // Mendapatkan user yang login
            $userName = $user->name; // Ambil nama user

            // Autentikasi berdasarkan role
            if ($user->role == 'recycleorg') {
                // Redirect to recycleorg home page with a success message
                return redirect()->route('home.homeRO')->with('success', "Login successful! Welcome back, $userName.");
            } else {
                // Redirect to user home page with a success message
                return redirect()->route('home.homeUser')->with('success', "Login successful! Welcome back, $userName.");
            }
        } else {
            return redirect()->route('account.login')->with('error', 'Either email or password or role is incorrect.');
        }
    }

    // show user profile page
    public function profile()
    {
        $user = User::find(Auth::user()->id);
        $mapData = $user->role === 'user' ? $user->mapsUser : ($user->role === 'recycleorg' ? $user->mapsRecycleOrg : null);
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
        $user->location = $request->location;
        $user->save();



        $latitude = $request->latitude; // Ambil latitude dari input tersembunyi
        $longitude = $request->longitude; // Ambil longitude dari input tersembunyi

        // Determine the model and location data to update
        if ($user->role === 'user') {
            $mapsUser = MapsUser::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'address' => $request->location,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ]
            );
        } elseif ($user->role === 'recycleorg') {
            $mapsRecycleOrg = MapsRecycleOrg::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'address' => $request->location,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ]
            );
        }


        return redirect()->route('account.profile')->with('success', 'Profile updated successfully');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function notificationRequest()
    {
        // Mendapatkan ID recycleorg yang sedang login
        $recycleorgID = Auth::id();

        // Ambil permintaan yang statusnya 'pending' atau 'accepted' dan terkait dengan recycleorg yang login
        $requests = WasteRequest::where('recycleorgID', $recycleorgID) // Permintaan untuk recycleorg yang login
            ->whereIn('status', ['pending', 'accepted'])  // Status permintaan 'pending' atau 'accepted'
            ->where('status', '!=', 'done')  // Pastikan tidak menampilkan status 'done'
            ->with('user')  // Mengambil data pengguna yang mengajukan request
            ->get();

        // Kirim data permintaan ke tampilan
        return view('account.notificationRequest', compact('requests'));
    }

    // Menampilkan detail permintaan berdasarkan ID
    public function showNotificationRequest($id)
    {
        // Ambil permintaan berdasarkan ID dan pastikan recycleorg yang login memiliki permintaan ini
        $request = WasteRequest::where('id', $id)
            ->where('recycleorgID', Auth::id())  // Filter recycleorg yang sedang login
            ->with(['user', 'categories', 'wasteData'])  // Tambahkan wasteData ke relasi
            ->firstOrFail();

        $totalWeight = $request->wasteData
            ->filter(function ($waste) use ($request) {
                return $waste->userID == $request->user_id;
            })
            ->sum('total_weight');

        $request->total_weight = $totalWeight;

        return view('account.notificationRequest2', compact('request'));
    }

    // Memperbarui status permintaan (accept, reject, atau done)
    public function updateStatusRequest(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected,done', // Validasi status yang diterima, termasuk "done"
        ]);

        // Temukan permintaan berdasarkan ID dan pastikan recycleorg yang login berhak mengubah status
        $wasteRequest = WasteRequest::where('id', $id)
            ->where('recycleorgID', Auth::id())  // Pastikan hanya recycleorg yang login yang bisa mengubah
            ->firstOrFail();

        // Perbarui status permintaan
        $wasteRequest->status = $request->status;

        // Jika statusnya "done", tambahkan poin ke user berdasarkan data waste_data
        if ($request->status === 'done') {
            // Menambahkan poin ke waste_data terkait dengan permintaan ini
            $wasteData = $wasteRequest->wasteData;  // Ambil relasi wasteData dari request ini

            // Jumlahkan poin dari semua waste_data yang terkait
            $totalPoints = $wasteData->sum('points');

            // Menambahkan total poin ke user
            $user = $wasteRequest->user;  // Ambil user yang terkait dengan waste request
            $user->points += $totalPoints;  // Tambahkan total poin ke user
            $user->save();
        }

        // Simpan perubahan status
        $wasteRequest->save();

        // Redirect kembali ke halaman detail permintaan dengan pesan sukses
        return redirect()->route('account.notificationRequest2', $id)
            ->with('success', 'Request status updated successfully.');
    }

    public function notificationReport()
    {
        // Ambil ID user yang sedang login
        $userId = Auth::id();

        // Data notifikasi poin yang didapatkan dari user tertentu
        $recyclingPoints = WasteData::with('wasteRequest')
            ->whereHas('wasteRequest', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Data notifikasi permintaan daur ulang dari user tertentu
        $recyclingRequests = WasteRequest::with('recycleOrg')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('account.notificationReport', compact('recyclingPoints', 'recyclingRequests'));
    }

    public function showNotificationRequestReport($id)
    {
        // Ambil permintaan berdasarkan ID dan pastikan user yang login adalah pembuat permintaan
        $request = WasteRequest::where('id', $id)
            ->where('user_id', Auth::id()) // Filter berdasarkan user yang login
            ->with(['categories', 'wasteData']) // Tambahkan wasteData dan categories ke relasi
            ->firstOrFail();

        // Hitung total berat dari wasteData terkait permintaan ini
        $totalWeight = $request->wasteData->sum('total_weight');

        $request->total_weight = $totalWeight;

        return view('account.notificationReport2', compact('request'));
    }
}
