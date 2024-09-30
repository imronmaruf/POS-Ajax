<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class UserDataController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dataUser = User::where('role', '!=', 'owner')->get();

            return DataTables::of($dataUser)
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

        return view('dashboard.data-user.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|email|unique:users',
            'role'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if (User::where('email', $request->email)->exists()) {
            return response()->json(['error' => 'Data already exists in the system'], 409);
        }

        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = Hash::make($request->name); // default password is name
            $user->save();

            DB::commit();

            return response()->json(['success' => 'User added successfully'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to save data.'], 500);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::findOrFail($id);

        try {
            DB::beginTransaction();

            $user->update($request->all());

            DB::commit();

            return response()->json(['success' => 'User data updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update data.'], 500);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => 'User deleted successfully']);
    }
}
