<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\StoreCategory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StoreCategoriesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dataStoreCategory = StoreCategory::select('name', 'id', 'created_at')
                ->get()
                ->map(function ($dataStoreCategory) {
                    $dataStoreCategory->created_at = Carbon::parse($dataStoreCategory->created_at)->format('d M Y');
                    return $dataStoreCategory;
                });

            return DataTables::of($dataStoreCategory)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="d-flex gap-2">
                            <button type="button" id="editData" class="btn btn-sm btn-success edit-item-btn" data-id="' . $row->id . '">Edit</button>
                            <button type="button" id="deleteData" class="btn btn-sm btn-danger remove-item-btn" data-id="' . $row->id . '">Remove</button>
                        </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.owner.store-categories.index');
    }


    public function create()
    {
        $dataStoreCategory = StoreCategory::select('id', 'name')->get();
        return response(json_encode($dataStoreCategory), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if (StoreCategory::where('name', $request->name)->exists()) {
            return response()->json(['error' => 'Data already exists in the system'], 409);
        }

        try {
            DB::beginTransaction();

            $dataStoreCategory = new StoreCategory();
            $dataStoreCategory->name = $request->name;
            $dataStoreCategory->save();

            DB::commit();

            return response()->json(['success' => 'Store Category  added successfully'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to save data.'], 500);
        }
    }

    public function edit($id)
    {
        $dataStoreCategory = StoreCategory::findOrFail($id);
        return response()->json($dataStoreCategory);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if (StoreCategory::where('name', $request->name)->exists()) {
            return response()->json(['error' => 'Data already exists in the system'], 409);
        }

        $storeCategory = StoreCategory::findOrFail($id);

        try {
            DB::beginTransaction();
            $storeCategory->update($request->all());
            DB::commit();
            return response()->json(['success' => 'Store category updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update data.'], 500);
        }
    }

    public function destroy($id)
    {
        $storeCategory = StoreCategory::findOrFail($id);
        $storeCategory->delete();
        return response()->json(['success' => 'Store category deleted successfully']);
    }
}
