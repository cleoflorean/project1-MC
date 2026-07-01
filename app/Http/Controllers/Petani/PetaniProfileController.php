<?php
namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\PetaniProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetaniProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        $profil = PetaniProfile::where('user_id', $user->id)->first();
        return view('Petani.profilpetani', compact('profil', 'user'));
    }

    public function update(Request $request) {
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Alamat'      => 'required|string',
            'NoTlp'       => 'required|string|max:20',
            'Bio'         => 'nullable|string',
            'FotoProfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $dataUpdate = $request->only(['NamaLengkap', 'Alamat', 'NoTlp', 'Bio']);

        if ($request->hasFile('FotoProfile')) {
            $file = $request->file('FotoProfile');
            $filename = time() . '_petani_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $dataUpdate['FotoProfile'] = 'uploads/profile/' . $filename;
        }

        PetaniProfile::updateOrCreate(['user_id' => Auth::id()], $dataUpdate);

        return redirect()->back()->with('success', 'Profil petani berhasil diperbarui!');
    }
}