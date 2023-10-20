<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class API_AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'login_guru', 'register', 'updateProfile', 'updateProfilePicture']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    public function login_guru(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nuptk' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        DB::beginTransaction();
        $user = User::create(
            array_merge(
                $validator->validated(),
                [
                    'password' => bcrypt($request->password),
                    'email_verified_at' => now()
                ]
            )
        );
        $user->assignRole('tamu');
        if ($user) {
            $biodata = Biodata::create([
                'id' => $user->id,
                'nama' => $request->name
            ]);
        }

        $value = array();
        if ($biodata) {
            DB::commit();

            $value['output'] = array(
                'message' => 'User successfully registered',
                'user' => $user
            );
            return response()->json([
                $value
            ], 201);
        } else {
            DB::rollBack();
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth('api')->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        $user = auth('api')->user();
        $bio = User::with('bio', 'roles')->where('id', $user->id)->first();

        if (!$bio) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json($bio);
    }

    public function updateProfile(Request $request)
    {
        // $user = auth('api')->user();
        

        $user = User::with('roles')->where('id', $request->user_id)->first();
        
        $this->validate($request, [
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg',            
        ]);

        if ($request->file('image')) {
            $path = $request->file('image')->store('/images/profile', ['disk' => 'my_files']);
        } else {
            $check = Biodata::where('id', $request->user_id)->first();
            if ($check) {
                $path = $check->profile_picture;
            } else {
                $path = NULL;
            }
        }

        if ($request->password == NULL or $request->password == '') {
            $password = $user->password;
        }else{
            $password = bcrypt($request->password);
        }

        
        if ($request->nama == NULL or $request->nama == '') {            
            $check = Biodata::where('id', $request->user_id)->first();            
            $nama = $check->nama;
        }else{            
            $nama = $request->nama;
        }

        $roleGuest = $user->hasRole('tamu');
    
        DB::beginTransaction();
        if ($roleGuest) {
            $updateBio = Biodata::where('id', $user->id)->update([
                'nama' => $nama,
                'profile_picture' => $path,
                'biografi' => $request->biografi
            ]);

            if ($updateBio) {
                $updateUser = User::where('id', $user->id)->update([
                    'name' => $nama,
                    'password' => $password
                ]);
            }
        }else{
            $updateBio = Biodata::where('id', $user->id)->update([               
                'profile_picture' => $path,
                'biografi' => $request->biografi
            ]);

            if ($updateBio) {
                $updateUser = User::where('id', $user->id)->update([                    
                    'password' => $password
                ]);
            }
        }

        

        $result = array();
        $base = url('/');
        if ($updateUser) {
            DB::commit();
            $result['message'] = 'success';
            $result['data'] = User::with('bio')->where('id', $user->id)->first();
            $result['data']->bio->profile_picture = $base . '/' . $result['data']->bio->profile_picture;
        } else {
            DB::rollBack();
            $result['message'] = 'failed';
        }
        return response()->json($result);
    }

    public function updateProfilePicture(Request $request)
    {
        
        $user = User::where('id', $request->user_id)->first();

        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        $path = $request->file('image')->store('/images/profile', ['disk' => 'my_files']);

        $data = Biodata::where('id', $user->id)->update([
            'profile_picture' => $path
        ]);

        if ($data) {
            $result = array();
            $result['message'] = 'success';

            $bio = Biodata::where('id', $user->id)->first();
            $base = url('/');
            $result['url_path'] = $base . '/' . $bio->profile_picture;
        }

        return response()->json($result);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }
}