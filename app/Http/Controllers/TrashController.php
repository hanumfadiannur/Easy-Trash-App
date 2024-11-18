<?php

namespace App\Http\Controllers;

use App\Models\CategoryWasteData;
use App\Models\User;
use App\Models\WasteCategory;
use App\Models\WasteData;
use App\Models\WasteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TrashController extends Controller
{
    public function locationRO()
    {
        $user = Auth::user(); // Directly fetch the authenticated user

        // Get the user location or recycling organization location based on the role
        $mapData = $user->role === 'user' ? $user->mapsUser : ($user->role === 'recycleorg' ? $user->mapsRecycleOrg : null);

        // Eager load the related recycling organizations and their map data
        $recycleOrgs = User::where('role', 'recycleorg')
            ->with('mapsRecycleOrg') // Eager load the mapsRecycleOrg relationship
            ->get();

        // Pass all necessary data to the view
        return view('maps', [
            'userLocation' => $user->mapsUser,  // User's location data
            'recycleOrgs' => $recycleOrgs,      // List of recycling organizations
            'mapData' => $mapData,              // Map data based on role
            'user' => $user                     // The authenticated user
        ]);
    }

    public function createWasteRequest(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'recycleorg_id' => 'required|exists:users,id',  // Ensure that the recycleorg exists
        ]);

        // Create a new waste request
        $wasteRequest = new WasteRequest();
        $wasteRequest->user_id = Auth::id();  // User ID from authenticated user
        $wasteRequest->recycleorgID = $validated['recycleorg_id'];  // Selected recycling organization ID
        $wasteRequest->status = 'pending';  // Default status
        $wasteRequest->expiryDate = Carbon::now()->addDays(2);  // Set expiry date to 2 days from now
        $wasteRequest->save();  // Save the waste request to the database


        return redirect()->route('inputWeight', ['wasteRequestID' => $wasteRequest->id])
            ->with('success', 'Waste request created successfully.');
    }

    public function inputWeight(Request $request)
    {
        $wasteRequestID = $request->query('wasteRequestID');
        $categories = WasteCategory::all();  // Get waste categories
        return view('inputWeight', compact('wasteRequestID', 'categories'));
    }

    public function storeData(Request $request)
    {
        // Ambil data dari form
        $wasteRequestID = $request->input('wasteRequestID');
        $categories = json_decode($request->input('categories'), true); // Decode JSON as array

        //dd($categories);
        // Validasi data
        $request->validate([
            'categories' => 'required',
            'categories.*.category_id' => 'required|exists:waste_category,id',
            'categories.*.weight' => 'required|integer|min:0',
        ]);



        // Proses penyimpanan data ke tabel waste_data
        $totalWeight = array_sum(array_column($categories, 'weight')); // Correct access to 'categories'
        $points = $totalWeight * 100;

        // Simpan ke tabel waste_data
        $wasteData = WasteData::create([
            'wasteRequestID' => $wasteRequestID,
            'userID' => Auth::id(),
            'total_weight' => $totalWeight,
            'points' => $points,
        ]);

        // Simpan data kategori dan berat ke tabel category_waste_data
        foreach ($categories as $category) {
            CategoryWasteData::create([
                'wasteDataID' => $wasteData->id,
                'categoryID' => $category['category_id'],
                'weight' => $category['weight'],
            ]);
        }

        // Redirect ke route homeUser setelah data berhasil disimpan
        return redirect()->route('home.homeUser')->with('success', 'Data berhasil disimpan');
    }
}
