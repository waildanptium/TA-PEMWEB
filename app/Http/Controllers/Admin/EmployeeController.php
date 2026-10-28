<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('admin.pegawai.index', [
            'employees' => User::whereIn('role', ['admin', 'kasir'])->orderBy('role')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:kasir,admin',
        ]);
        User::create($data);

        return back()->with('success', 'Akun pegawai dibuat.');
    }

    public function update(User $pegawai)
    {
        abort_if($pegawai->id === auth()->id(), 403, 'Tidak bisa menonaktifkan akun sendiri.');
        $pegawai->update(['is_active' => !$pegawai->is_active]);

        return back()->with('success', 'Status akun diubah.');
    }
}