<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Untuk transaksi

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('user')->latest()->paginate(10);
        return view('admin.karyawan.index', compact('karyawans')); // Buat view
    }

    public function create()
    {
        return view('admin.karyawan.create'); // Buat view
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'required|string|unique:karyawans,nip',
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'tanggal_masuk' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'karyawan',
            ]);

            $user->karyawan()->create([
                'nip' => $request->nip,
                'nama_lengkap' => $request->nama_lengkap,
                'jabatan' => $request->jabatan,
                'gaji_pokok' => $request->gaji_pokok,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);

            DB::commit();
            return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan karyawan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load('user');
        return view('admin.karyawan.show', compact('karyawan')); // Buat view
    }

    public function edit(Karyawan $karyawan)
    {
        $karyawan->load('user');
        return view('admin.karyawan.edit', compact('karyawan')); // Buat view
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $karyawan->user_id,
            // Password opsional saat update
            'password' => 'nullable|string|min:8|confirmed',
            'nip' => 'required|string|unique:karyawans,nip,' . $karyawan->id,
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'tanggal_masuk' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $karyawan->user->update($userData);

            $karyawan->update([
                'nip' => $request->nip,
                'nama_lengkap' => $request->nama_lengkap,
                'jabatan' => $request->jabatan,
                'gaji_pokok' => $request->gaji_pokok,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);

            DB::commit();
            return redirect()->route('admin.karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data karyawan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Karyawan $karyawan)
    {
        DB::beginTransaction();
        try {
            // User akan terhapus otomatis jika ada onDelete('cascade') di foreign key,
            // tapi lebih baik explicit.
            $karyawan->user->delete(); // Ini akan menghapus karyawan juga karena cascade
            // atau $karyawan->delete(); lalu $user->delete();
            DB::commit();
            return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.karyawan.index')->with('error', 'Gagal menghapus karyawan: ' . $e->getMessage());
        }
    }
}