<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class CustomerController extends Controller
{
    public function index()
    {
        return view('pages.Home');
    }

    public function showProfile()
    {
        return view('customer.account.my_account');
    }
    public function showAddress()
    {
        $user = auth::user();
        $provinces = Province::all();
        // $villages = Village::all();
        // $districts = District::all();
        $addresses = Address::where('user_id', $user->id)->get();
        return view('customer.account.address', compact(['addresses', 'provinces']));
    }
    public function updateAddress()
    {
        return back();
    }

    public function updatePhoto(Request $request)
    {
        $request->validate(['profile_photo' => 'required|mimes:png,jpg,png,webp']);

        $user = Auth::user();

        // hapus photo kalo ada
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('profile_photo')->store('profile', 'public');
        $user->update([
            'profile_photo' => $path,
        ]);
        return back()->with('success', 'Foto berhasil diupdate');
    }
    public function manageAccount()
    {
        return view('customer.account.manage_account');
    }

    public function updateManageAccount(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'username' => 'nullable|string|max:255|unique:users,username,' . auth()->id(), 'phone' => 'nullable|string|max:20', 'gender' => 'nullable|in:male,female,other', 'birth_date' => 'nullable|date']);
        $user = Auth::user();

        $user->update(['name' => $request->name, 'username' => $request->username, 'phone' => $request->phone, 'gender' => $request->gender, 'birth_date' => $request->birth_date]);
        return back()->with('success', 'Profile updated successfully');
    }
    // provinsi
    public function getCities($provinceCode)
    {
        return City::where('province_code', $provinceCode)->get();
    }
    // kecematan
    public function getDistricts($cityCodes)
    {
        return District::where('city_code', $cityCodes)->get();
    }
    // Desa
    public function getVillages($districtCode)
    {
        return Village::where('district_code', $districtCode)->get();
    }
    public function updateManageAddress(Request $request, $id)
    {
        $addres = Address::findOrFail($id);

        $addres->update([
            'receiver_name' => $request->receiver_name,
            'phone' => $request->phone,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'village' => $request->village,
            'postal_code' => $request->postal_code,

            'full_address' => $request->full_address,
        ]);

        return back()->with('success', 'Alamat berhasil diupdate');
    }
    public function storeAddress(Request $request)
    {
        $request->validate([
            'receiver_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'full_address' => 'required|string',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'postal_code' => 'nullable|string|max:10',
        ]);
        $user = Auth::user();

        Address::create([
            'user_id' => $user->id,
            'label' => null,
            'receiver_name' => $request->receiver_name,
            'phone' => $request->phone,

            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'village' => $request->village,

            'postal_code' => $request->postal_code,
            'full_address' => $request->full_address,
            'is_default' => false,
        ]);
        return back();
    }
    public function deleteAddress($id)
    {
        Address::findOrFail($id)->delete();
        return redirect()->route('customer.address');
    }
    public function defaultAddress($id)
    {
        $user = Auth::user();
        Address::where('user_id', $user->id)->update([
            'is_default' => false,
        ]);
        Address::where('id', $id)->update([
            'is_default' => true,
        ]);
        return back();
    }
}
