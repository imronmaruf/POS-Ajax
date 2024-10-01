<?php

namespace App\Http\Controllers\Admin;

use App\Models\Owner\Store;
use Illuminate\Http\Request;
use App\Models\Owner\Product;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();

            if ($user->role === 'admin') {
                $dataProduct = Product::with('store')->where('store_id', $user->store_id)->get();
            } else {
                $dataProduct = Product::with('store')->get();
            }

            return DataTables::of($dataProduct)
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

        return view('dashboard.admin.product.index');
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->role === 'owner') {
            $dataStore = Store::select('id', 'name')->get();
            return response()->json($dataStore, 200);
        }

        return response()->json([], 200);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->where(function ($query) use ($request) {
                    return $query->where('store_id', $request->store_id);
                }),
            ],
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if ($user->role === 'owner') {
            $rules['store_id'] = 'required|exists:stores,id';
        }


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $imagePath = $request->file('image')->store('product', 'public');

        try {
            DB::beginTransaction();

            $product = new Product();
            $product->name = $request->name;
            $product->category = $request->category;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->image = $imagePath;

            if ($user->role === 'admin') {
                $product->store_id = $user->store_id;
            } else {
                $product->store_id = $request->store_id;
            }

            $product->save();

            DB::commit();

            return response()->json(['success' => 'Product added successfully'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to save data.'], 500);
        }
    }

    public function edit($id)
    {
        $user = auth()->user();
        $dataProduct = Product::with('store')->findOrFail($id);

        if ($user->role === 'owner') {
            $store = Store::select('id', 'name')->get();
        } else {
            $store = [];
        }

        return response()->json([
            'product' => $dataProduct,
            'store' => $store
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $dataProduct = Product::findOrFail($id);

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($dataProduct->id)->where(function ($query) use ($request) {
                    return $query->where('store_id', $request->store_id);
                }),
            ],
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if ($user->role === 'owner') {
            $rules['store_id'] = 'required|exists:stores,id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            if ($user->role === 'owner') {
                $dataProduct->store_id = $request->store_id;
            }

            $dataProduct->name = $request->name;
            $dataProduct->category = $request->category;
            $dataProduct->price = $request->price;
            $dataProduct->stock = $request->stock;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('product', 'public');
                $dataProduct->image = $imagePath;
            }

            $dataProduct->save();

            DB::commit();
            return response()->json(['success' => 'Product updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update data.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $dataProduct = Product::findOrFail($id);
            $imagePath = public_path($dataProduct->image);

            $dataProduct->delete();
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            return response()->json(['success' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product.'], 500);
        }
    }
}
