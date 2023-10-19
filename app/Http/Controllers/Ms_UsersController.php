<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;

class Ms_UsersController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = User::with('roles','bio')->get();
            $roles = Role::all();            
        if ($request->ajax()) {
            return DataTables::of($user)
            ->addColumn('aksi', function ($user) {
                $result = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <button type="button" data-id="'.$user->id.'" data-name="'.$user->bio->nama.'" class="btn btn-info edit"><i class="fa fa-wrench"></i></button>
                <button type="button" data-id="'.$user->id.'" class="btn btn-danger delete"><i class="fa fa-trash"></i></button>                
              </div>';
                return $result;
            })
            ->addColumn('nama', function ($user) {
                return $user->bio->nama;
            })
            ->addColumn('roles', function ($user) {
                $result = '';
                foreach ($user->roles as $roles) {
                    $result .= '<li>'.$roles->name.'</li>';
                }
                return $result;
            })
                ->rawColumns(['nama','aksi','roles'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('master.user.index', compact('roles'));
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
}
