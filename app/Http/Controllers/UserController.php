<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:10',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show( string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( string $id)
    {
        $users = User::find($id);
        return view('admin.users.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id )
    {
            $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ],[
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password Wajib diisi',
            'role.required' => 'Wajib isi Role',
        ]);

        $updateUser = User::where('id', $id)->update([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        ]);

        if($updateUser) {
            return redirect()->route('admin.users.index')->with('success', 'Berhasil mengubah data user!');
        } else {
            return redirect()->back()->with('failed', 'Gagal mengubah data user!');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dipindahkan ke sampah!');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email:dns',
            'password' => 'required|min:3'
        ], [
            'first_name.required' => "Nama depan wajib diisi",
            'first_name.min' => 'Nama depan minimal 3 huruf',
            'last_name.required' => 'Nama belakang wajib diisi',
            'last_name.min' => 'Nama belakang minimal 3 huruf',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 3 karakter',
        ]);

        $createUser = User::create([
            'name' => $request->first_name . " " . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        if ($createUser) {
            return redirect()->route('login')->with('success', 'Silahkan login!');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        }
    }

    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        $data = $request->only(['email', 'password']);

        if (Auth::attempt($data)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil login!');
            } elseif(Auth::user()->role == 'staff') {
                return redirect()->route('staff.dashboard')->with('success', 'Berhasil login!');
            }else{
                return redirect()->route('home')->with('success', 'Berhasil Login!');
            }
        } else {
            return redirect()->back()->with('error', 'Gagal login! Pastikan email dan password sesuai');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('logout', 'Berhasil logout! Silahkan login kembali untuk akses lengkap');
    }

    public function export()
    {
        //nama file yng akan di unduh
        $fileNama = 'data-petugas.xlsx';
        //proses unduh
        return Excel::download(new UserExport, $fileNama);
    }

    public function trash()
    {
        $userTrash = User::onlyTrashed()->get();
        return view('admin.users.trash', compact('userTrash'));
    }

        public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->restore();
        return redirect()->route('admin.users.index')->with('success', 'Berhasil mengembalikan data');
    }

    public function deletePermanent($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->forceDelete();
        return redirect()->back()->with('success', 'Berhasil menghapus data secara permanen!');
    }

   public function datatables()
{
    $user = User::query();

    return DataTables::of($user)
        ->addIndexColumn()
        ->addColumn('roleBadge', function ($user) {
            if ($user->role == 'admin') {
                return '<span class="badge bg-primary">Admin</span>';
            } elseif ($user->role == 'staff') {
                return '<span class="badge bg-success">Staff</span>';
            } else {
                return '<span class="badge bg-secondary">User</span>';
            }
        })
        ->addColumn('buttons', function ($user) {
            $btnEdit = '<a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-sm btn-outline-warning me-1">
                            <i class="fas fa-edit"></i>
                        </a>';
            $btnDelete = '<form action="' . route('admin.users.delete', $user->id) . '" method="POST" style="display:inline-block">'
                . csrf_field() . method_field('DELETE') . '
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Hapus pengguna ini?\')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>';

            return '<div class="d-flex justify-content-center">' . $btnEdit . $btnDelete . '</div>';
        })
        ->rawColumns(['roleBadge', 'buttons'])
        ->make(true);
    }
}
