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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class Ms_UsersController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = User::with('roles', 'bio')->get();
            $roles = Role::where('name', '!=', 'tamu')->get();
            $roles_add = Role::whereNotIn('name', ['guru', 'tamu'])->get();
            $sekolah = Ms_DataSekolah::all();
            if ($request->ajax()) {
                return DataTables::of($user)
                    ->addColumn('aksi', function ($user) {
                        $result = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <button type="button" data-id="' . $user->id . '" data-name="' . $user->bio->nama . '" class="btn btn-info edit"><i class="fa fa-wrench"></i></button>
                <button type="button" data-id="' . $user->id . '" data-name="' . $user->bio->nama . '" class="btn btn-danger delete"><i class="fa fa-trash"></i></button>                
              </div>';
                        return $result;
                    })
                    ->addColumn('nama', function ($user) {
                        return $user->bio->nama;
                    })
                    ->addColumn('roles', function ($user) {
                        $result = '';
                        foreach ($user->roles as $roles) {
                            $result .= '<li>' . $roles->name . '</li>';
                        }
                        return $result;
                    })
                    ->rawColumns(['nama', 'aksi', 'roles'])
                    ->addIndexColumn()
                    ->make(true);
            }
            return view('master.user.index', compact('roles', 'sekolah', 'roles_add'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function user_role($id)
    {
        try {
            $get = User::where('id', $id)->first();
            $get = $get->getRoleNames();

            return response()->json($get);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function user_role_store(Request $request)
    {
        try {

            $user = User::with('bio')->where('id', $request->id)->first();
            $user->syncRoles([]);
            $count_roles = count($request->roles);
            $exe_count = 0;
            foreach ($request->roles as $role) {
                $user->assignRole($role);
                $exe_count += 1;
            }
            if ($count_roles == $exe_count) {
                return response()->json($user->bio->nama);
            } else {
                return response()->json(false);
            }


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function user_store(Request $request)
    {
        
            // dd($request->all());
            DB::beginTransaction();
            $validated = $request->validate([
                'email' => 'required|unique:users'
            ]);
            $exe_count = 0;
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'nuptk' => $request->nuptk
            ]);
            foreach ($request->newroles as $role) {
                $user->assignRole($role);
                $exe_count += 1;
            }

            // dd($exe_count);
            $biodata = Biodata::create([
                'id' => $user->id,
                'nama' =>$request->name,
                'nuptk' => $request->nuptk,
                'asal_satuan_pendidikan' => $request->asal_satuan_sekolah
            ]);

            if ($biodata) {
                DB::commit();
                return redirect('master/user')->with('success', 'Data berhasil disimpan.');
            } else {
                DB::rollBack();
                return redirect('master/user')->with('error', 'Data gagal disimpan.');
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
                ])->delete('http://103.242.124.108:3033/sync-users/'.$id);

                DB::commit();
                return response()->json($bio);
            }          

           
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
    }
}
