<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorRegistrationReview;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
{
    private $role;
    private $user;
    private $vendor;
    private $vendorRegistrationReview;

    public function __construct()
    {
        $this->role = new Role();
        $this->user = new User();
        $this->vendor = new Vendor();
        $this->vendorRegistrationReview = new VendorRegistrationReview();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $vendors = $this->vendor::query();

            return DataTables::of($vendors)
                ->addColumn('action', function ($vendor) {
                    return view('vendor-review.action', [
                        'id' => $vendor->id,
                    ]);
                })

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('vendor-review.index', [
            'title' => 'Vendor Review',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $authUser = Auth::user();

        try {
            $vendorRegistrationReview = $this->vendorRegistrationReview->create([
                'comment' => $request->comment,
                'reviewer_id' => $authUser->id,
                'vendor_id' => $id,
            ]);

            $vendor = $this->vendor
                ->find($id);

            $vendor->update([
                'status' => config('general.vendor_status.reject')
            ]);

            if ($vendorRegistrationReview) return redirect()->route('vendor-review.index')
                ->with('status', ['type' => 'success', 'message' => __("Komentar berhasil dilakukan.")]);
        } catch (Exception $e) {
            Log::error([
                'title' => 'vendor registration review',
                'message'   => $e->getMessage(),
            ]);

            return redirect()->route('vendor-review.index')
                ->with('status', ['type' => 'danger', 'message' => __("Komentar tidak berhasil dilakukan. Silahkan hubungi admin.")]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vendor = $this->vendor
            ->find($id);

        $vendorRegistrationReviews = $this->vendorRegistrationReview
            ->where('vendor_id', $vendor->id)
            ->latest()
            ->paginate(4);

        return view('vendor-review.show', [
            'title' => 'Detail Pengajuan Vendor',
            'vendor' => $vendor,
            'vendorRegistrationReviews' => $vendorRegistrationReviews,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $vendor = $this->vendor
                ->find($id);

            $authUser = Auth::user();

            $vendor->update([
                'reviewer_id' => $authUser->id,
                'status' => config('general.vendor_status.accepted')
            ]);

            $user = $this->user
                ->where('id', $vendor->user_id)
                ->first();

            DB::table('model_has_roles')
                ->where('model_id', $vendor->user_id)
                ->delete();

            $role = $this->role
                ->where('name', 'vendor')
                ->first();

            $user->assignRole($role);

            if ($vendor) return redirect()->route('vendor-review.index')
                ->with('status', ['type' => 'success', 'message' => __("Anda telah berhasil menyetujui vendor.")]);
        } catch (Exception $e) {
            Log::error([
                'title' => 'accepted vendor',
                'message'   => $e->getMessage(),
            ]);

            return redirect()->route('vendor-review.index')
                ->with('status', ['type' => 'danger', 'message' => __("Anda tidak berhasil menyetujui vendor. Silahkan hubungi admin.")]);
        }
    }
}
