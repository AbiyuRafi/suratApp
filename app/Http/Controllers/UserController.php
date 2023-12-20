<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function hitung()
    {
        $staff = User::where('role', 'staff')->count();
        return view('home', compact('staff'));
    }
    public function index()
    {
        $users = User::where('role', 'staff')->Paginate(7);
        return view('staff.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:staff,guru',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal harus terdiri dari 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib diisi.',
            'role.in' => 'Role harus berupa staff atau guru.',
        ]);

        $password = substr($request->name, 0, 3) . substr($request->email, 0, 3);
        $role = ($request->input('role') == 'guru') ? 'staff' : 'staff';

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $role,
        ]);

        return redirect()->route('staff.index')->with('success', 'Akun berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // ...
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $users = User::find($id);
        return view('staff.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $users = User::find($id);

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:staff,guru',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal harus terdiri dari 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib diisi.',
            'role.in' => 'Role harus berupa staff atau guru.',
        ]);

        if ($request->password) {
            $users->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $users->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);
        }

        return redirect()->route('staff.index')->with('success', 'Akun Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('staff.index')->with('success', 'Berhasil Menghapus Data');
    }

    /**
     * Display a listing of the resource.
     */
    public function indexGuru()
    {
        $users = User::where('role', 'guru')->simplePaginate(7);
        return view('guru.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createGuru()
    {
        return view('guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeGuru(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:guru,staff',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal harus terdiri dari 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib diisi.',
            'role.in' => 'Role harus berupa staff atau guru.',
        ]);

        $password = substr($request->name, 0, 3) . substr($request->email, 0, 3);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role,
        ]);

        return redirect()->route('guru.indexGuru')->with('success', 'Akun berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editGuru($id)
    {
        $user = User::find($id);
        return view('guru.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateGuru(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:guru,staff',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal harus terdiri dari 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib diisi.',
            'role.in' => 'Role harus berupa staff atau guru.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('guru.indexGuru')->with('success', 'Akun berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyGuru($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('guru.indexGuru')->with('success', 'Berhasil menghapus data');
    }
    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $user = $request->only(['email', 'password']);
        if (Auth::attempt($user)) {
            return redirect()->route('home');
        } else{
            return redirect()->back()->with('failed', 'Login Gagal Silahkan Coba Lagi');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda Telah logout');
    }
}
