<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $authUser = Auth::user();

        $vendorExists = Vendor::where('user_id', $authUser->id)->first();
        $urlVendorRegistaration = route('vendor-registration.create');
        if ($vendorExists) {
            $urlVendorRegistaration = route('vendor-registration.edit', $vendorExists->id);
        }

        return view('home', [
            'title' => 'Dashboard',
            'urlVendorRegistaration' => $urlVendorRegistaration,
        ]);
    }
}
