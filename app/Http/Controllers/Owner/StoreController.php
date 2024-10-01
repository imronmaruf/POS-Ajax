<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use App\Models\Owner\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\StoreCategory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dataStore = Store::with(['category', 'owner'])->get();

            return DataTables::of($dataStore)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="d-flex gap-2 justify-content-center">
                                <button type="button" id="editData" class="btn btn-sm btn-success edit-item-btn" data-id="' . $row->id . '">Edit</button>
                                <button type="button" id="deleteData" class="btn btn-sm btn-danger remove-item-btn" data-id="' . $row->id . '">Remove</button>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $dataStoreCategory = StoreCategory::all();
        return view('dashboard.owner.stores.index', compact('dataStoreCategory'));
    }

    public function create()
    {
        $dataStoreCategory = StoreCategory::select('id', 'name')->get();
        return response()->json($dataStoreCategory, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'address'    => 'required',
            'logo'       => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:store_categories,id',
            'store_id'   => 'required|exists:stores,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if (Store::where('name', $request->name)->exists()) {
            return response()->json(['error' => 'Data already exists in the system'], 409);
        }

        try {
            DB::beginTransaction();

            $owner = User::where('role', 'owner')->first();
            if (!$owner) {
                return response()->json(['error' => 'Owner not found'], 404);
            }

            $logoPath = $request->file('logo')->store('logo', 'public');

            Store::create([
                'name' => $request->name,
                'owner_id' => $owner->id,
                'address' => $request->address,
                'logo' => $logoPath,
                'category_id' => $request->category_id,

            ]);

            DB::commit();
            return response()->json(['success' => 'Store added successfully'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to save data.'], 500);
        }
    }

    public function edit($id)
    {
        $dataStore = Store::with('category')->findOrFail($id);
        $categories = StoreCategory::select('id', 'name')->get();

        return response()->json([
            'store' => $dataStore,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'address'    => 'required',
            'logo'       => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:store_categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if (Store::where('name', $request->name)->where('id', '!=', $id)->exists()) {
            return response()->json(['error' => 'Data already exists in the system'], 409);
        }

        try {
            DB::beginTransaction();

            $dataStore = Store::findOrFail($id);
            $dataStore->update([
                'name' => $request->name,
                'address' => $request->address,
                'category_id' => $request->category_id,
            ]);

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logo', 'public');
                $dataStore->update(['logo' => $logoPath]);
            }

            DB::commit();
            return response()->json(['success' => 'Store updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update data.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $storeData = Store::findOrFail($id);
            $logoPath = public_path($storeData->logo);

            $storeData->delete();
            if (file_exists($logoPath)) {
                unlink($logoPath);
            }

            return response()->json(['success' => 'Store deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete store.'], 500);
        }
    }
}
