<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('id')->get();
        $roles = Role::orderBy('name')->pluck('name');

        return view('admin.users', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate(['role' => ['required', 'in:admin,petugas,siswa']]);
        $user->syncRoles([$data['role']]);

        return back()->with('sukses', "Role {$user->name} diubah menjadi {$data['role']}.");
    }

    public function destroy(User $user)
    {
        abort_if($user->id === auth()->id(), 403, 'Tidak dapat menghapus akun sendiri.');
        $user->delete();

        return back()->with('sukses', 'Pengguna dihapus.');
    }
}