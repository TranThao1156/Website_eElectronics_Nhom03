<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;

class NguoiDungController extends Controller
{
	// Lấy danh sách
	public function index()
	{
		$ds = NguoiDung::all();
		return response()->json($ds);
	}

	// Lấy chi tiết theo id
	public function show($id)
	{
		$nd = NguoiDung::findOrFail($id);
		return response()->json($nd);
	}

	// Tạo mới
	public function store(Request $request)
	{
		$data = $request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|email|unique:nguoi_dungs,email',
			'password' => 'required|string|min:6',
		]);

		// Nếu môi trường không dùng cast 'hashed', dùng bcrypt:
		$data['password'] = bcrypt($data['password']);

		$nd = NguoiDung::create($data);
		return response()->json($nd, 201);
	}

	// Cập nhật
	public function update(Request $request, $id)
	{
		$nd = NguoiDung::findOrFail($id);

		$data = $request->validate([
			'name' => 'sometimes|string|max:255',
			'email' => "sometimes|email|unique:nguoi_dungs,email,{$id}",
			'password' => 'sometimes|string|min:6',
		]);

		if (isset($data['password'])) {
			$data['password'] = bcrypt($data['password']);
		}

		$nd->update($data);
		return response()->json($nd);
	}

	// Xoá
	public function destroy($id)
	{
		$nd = NguoiDung::findOrFail($id);
		$nd->delete();
		return response()->noContent();
	}
}
