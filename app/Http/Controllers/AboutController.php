<?php

namespace App\Http\Controllers;

use App\Models\ShopProfile;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Ambil data dari tabel shop_profile
        $profile = ShopProfile::first(); // Atau gunakan method lain untuk mengambil data yang tepat

        // Kirim data ke view
        return view('about', compact('profile'));
    }
}
