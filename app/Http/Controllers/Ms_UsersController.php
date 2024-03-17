<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class Ms_UsersController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Fetch users with their roles and bio information
            $users = User::with('roles', 'bio')->get();

            // Fetch roles excluding 'tamu'
            $roles = Role::where('name', '!=', 'tamu')->get();

            // Fetch roles for adding, excluding 'tamu' and 'nonaktif'
            $rolesToAdd = Role::whereNotIn('name', ['tamu', 'nonaktif'])->get();

            // Fetch school data
            $schools = Ms_DataSekolah::all();

            // Check if the request is AJAX
            if ($request->ajax()) {
                return DataTables::of($users)
                    ->addColumn('aksi', function ($user) {
                        // Generate action buttons for each user
                        return '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                            <button type="button" title="Ubah Peran" data-id="' . $user->id . '" data-name="' . $user->bio->nama . '" class="btn btn-info edit"><i class="fa fa-wrench"></i></button>
                            <button type="button" title="Hapus" data-id="' . $user->id . '" data-name="' . $user->bio->nama . '" class="btn btn-danger delete"><i class="fa fa-trash"></i></button>   
                            <button type="button" title="Login As" data-id="' . $user->id . '" data-name="' . $user->bio->nama . '" class="btn btn-primary login-as"><i class="fa fa-arrow-right"></i></button>                  
                        </div>';
                    })
                    ->addColumn('nuptk', function ($user) {
                        // Get NUPTK from bio information
                        return $user->bio->nuptk;
                    })
                    ->addColumn('nama', function ($user) {
                        // Get name from bio information
                        return $user->bio->nama;
                    })
                    ->addColumn('roles', function ($user) {
                        // Generate role list for each user
                        $result = '';
                        foreach ($user->roles as $role) {
                            $result .= '<li>' . $role->name . '</li>';
                        }
                        return $result;
                    })
                    ->rawColumns(['nama', 'aksi', 'roles'])
                    ->addIndexColumn()
                    ->make(true);
            }
            // If not AJAX, return the view with necessary data
            return view('master.user.index', compact('roles', 'schools', 'rolesToAdd'));
        } catch (\Exception $e) {
            // Return error message if exception occurs
            return $e->getMessage();
        }
    }

    public function user_role($id)
    {
        try {
            // Get the user by ID
            $user = User::findOrFail($id);

            // Get the role names associated with the user
            $roleNames = $user->getRoleNames();

            // Return the role names as JSON response
            return response()->json($roleNames);
        } catch (\Exception $e) {
            // Return error message if an exception occurs
            return $e->getMessage();
        }
    }
    public function user_role_store(Request $request)
    {
        try {
            // Retrieve the user with associated bio by ID
            $user = User::with('bio')->findOrFail($request->id);

            // Remove all existing roles assigned to the user
            $user->syncRoles([]);

            // Assign new roles to the user based on the request
            foreach ($request->roles as $role) {
                $user->assignRole($role);
            }

            // Check if the number of roles assigned matches the count of requested roles
            $countRoles = count($request->roles);
            $executedCount = count($user->roles);

            // Return the user's name if all roles were successfully assigned
            // Otherwise, return false
            return response()->json($countRoles === $executedCount ? $user->bio->nama : false);
        } catch (\Exception $e) {
            // Return error message if an exception occurs
            return $e->getMessage();
        }
    }
    public function user_store(Request $request)
    {
        try {
            // Begin transaction
            DB::beginTransaction();

            // Validate email uniqueness
            $validated = $request->validate([
                'email' => 'required|unique:users'
            ]);

            // Create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'nuptk' => $request->nuptk
            ]);

            // Assign roles to the new user
            $exe_count = 0;
            foreach ($request->newroles as $role) {
                $user->assignRole($role);
                $exe_count += 1;
            }

            // Create new biodata
            $biodata = Biodata::create([
                'id' => $user->id,
                'nama' => $request->name,
                'nuptk' => $request->nuptk,
                'asal_satuan_pendidikan' => $request->asal_satuan_sekolah
            ]);

            // Sync user with external system if 'guru' role is assigned
            if (in_array('guru', $request->newroles)) {
                $check = Http::withHeaders([
                    'client_secret' => 'haloguru_secretkey',
                ])->get('http://103.242.124.108:3033/sync-users/' . $biodata->id);

                // If user is not found, insert into external system
                if ($check['message'] == "User not found") {
                    $asal_sekolah = Ms_DataSekolah::where('npsn', $request->asal_satuan_sekolah)->first();
                    $password = '12345678';

                    $parr = [
                        'id' => $biodata->id,
                        'email' => $request->email,
                        'nama' => $request->name,
                        'password' => $password,
                        'roleId' => 'gtk',
                        'foto' => null,
                        'biografi' => null,
                        'firebase_token' => null,
                        'gtk' => [
                            'nip_nuptk' => $request->nuptk,
                            'mata_pelajaran' => null,
                            'media_pembelajaran' => [],
                            'pangkat' => NULL,
                            'golongan' => null,
                            'jabatan' => null,
                            'unit_kerja' => $asal_sekolah->nama,
                            'riwayat_pendidikan' => NULL,
                        ]
                    ];

                    $send = Http::withHeaders([
                        'client_secret' => 'haloguru_secretkey',
                    ])->post('http://103.242.124.108:3033/sync-users', $parr);
                    $insertHaloGuru = true;
                } else {
                    $insertHaloGuru = false;
                }
            }

            // Commit transaction if successful
            if ($insertHaloGuru) {
                DB::commit();
                return redirect('master/user')->with('success', 'Data berhasil disimpan.');
            } else {
                // Roll back transaction if unsuccessful
                DB::rollBack();
                return redirect('master/user')->with('error', 'Data gagal disimpan.');
            }
        } catch (\Exception $e) {
            // Return error message if an exception occurs
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $user = User::where('id', $id)->delete();
            if ($user) {
                $bio = Biodata::where('id', $id)->delete();
            }

            if ($bio) {
                $send = Http::withHeaders([
                    'client_secret' => 'haloguru_secretkey',
                ])->delete('http://103.242.124.108:3033/sync-users/' . $id);

                DB::commit();
                return response()->json($bio);
            }


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
    }

    public function loginas(Request $request, $id)
    {
        // Find user by ID
        $user = User::find($id);

        if ($user) {
            // Log out current user
            Auth::logout();
            // Log in as the found user
            Auth::loginUsingId($user->id);
            // Regenerate session
            $request->session()->regenerate();

            // Return success response
            return response()->json(true);
        } else {
            // Log out current user
            Auth::logout();
            // Return failure response
            return response()->json(false);
        }

    }
}
