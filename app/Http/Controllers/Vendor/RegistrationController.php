<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorRegistrationReview;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    private $businessFields;

    private $vendor;
    private $vendorRegistrationReview;

    public function __construct()
    {
        $businessFields = config('general.business_fields');
        sort($businessFields);
        $this->businessFields = $businessFields;

        $this->vendor = new Vendor();
        $this->vendorRegistrationReview = new VendorRegistrationReview();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor-registration.create', [
            'title' => 'Daftar Vendor',
            'businessFields' => $this->businessFields,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'telephone' => 'required|integer',
            'business_field' => ['required', 'string', Rule::in($this->businessFields)],
            'npwp' => 'required|integer',
            'address' => 'required|string',
            'website' => 'required|string',
            'description' => 'required|string',
        ]);

        try {
            $requestVendor = [
                'name' => $request->name,
                'telephone' => $request->telephone,
                'business_field' => $request->business_field,
                'npwp' => $request->npwp,
                'address' => $request->address,
                'website' => $request->website,
                'description' => $request->description,
                'status' => config('general.vendor_status.review'),
                'user_id' => Auth::user()->id,
            ];

            $vendor = $this->vendor->create($requestVendor);

            if ($vendor) return redirect()->route('home')
                ->with('status', ['type' => 'success', 'message' => __("Pengajuan perubahan akun berhasil.")]);
        } catch (Exception $e) {
            Log::error([
                'title' => 'vendor registration',
                'message'   => $e->getMessage(),
            ]);

            return redirect()->route('home')
                ->with('status', ['type' => 'danger', 'message' => __("Pengajuan perubahan akun belum berhasil. Silahkan hubungi Admin.")]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vendor = $this->vendor
            ->find($id);

        $vendorRegistrationReviews = $this->vendorRegistrationReview
            ->where('vendor_id', $vendor->id)
            ->latest()
            ->paginate(4);

        $btnUpdate = false;
        if ($vendor->status == config('general.vendor_status.opened')) {
            $btnUpdate = true;
        }

        $btnReject = false;
        if ($vendor->status == config('general.vendor_status.reject')) {
            $btnReject = true;
        }

        return view('vendor-registration.edit', [
            'title' => 'Detail Pengajuan Vendor',
            'businessFields' => $this->businessFields,
            'vendor' => $vendor,
            'vendorRegistrationReviews' => $vendorRegistrationReviews,
            'btnUpdate' => $btnUpdate,
            'btnReject' => $btnReject,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOpened(Request $request, string $id)
    {
        try {
            $vendor = $this->vendor
                ->find($id);

            $vendor->update([
                'status' => config('general.vendor_status.opened')
            ]);

            if ($vendor) return redirect()->back()
                ->with('status', ['type' => 'success', 'message' => __("Update status berhasil dilakukan.")]);
        } catch (Exception $e) {
            Log::error([
                'title' => 'vendor update opened',
                'message'   => $e->getMessage(),
            ]);

            return redirect()->back()
                ->with('status', ['type' => 'danger', 'message' => __("Update status tidak berhasil dilakukan. Silahkan hubungi admin.")]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'telephone' => 'required|integer',
            'business_field' => ['required', 'string', Rule::in($this->businessFields)],
            'npwp' => 'required|integer',
            'address' => 'required|string',
            'website' => 'required|string',
            'description' => 'required|string',
        ]);

        try {
            $requestVendor = [
                'name' => $request->name,
                'telephone' => $request->telephone,
                'business_field' => $request->business_field,
                'npwp' => $request->npwp,
                'address' => $request->address,
                'website' => $request->website,
                'description' => $request->description,
                'status' => config('general.vendor_status.review'),
            ];

            $vendor = $this->vendor->find($id);
            $vendor->update($requestVendor);

            if ($vendor) return redirect()->route('home')
                ->with('status', ['type' => 'success', 'message' => __("Pengajuan kembali perubahan akun berhasil.")]);
        } catch (Exception $e) {
            Log::error([
                'title' => 'update data vendor registration',
                'message'   => $e->getMessage(),
            ]);

            return redirect()->route('home')
                ->with('status', ['type' => 'danger', 'message' => __("Pengajuan kembali perubahan akun belum berhasil. Silahkan hubungi Admin.")]);
        }
    }
}
