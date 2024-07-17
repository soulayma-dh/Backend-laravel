<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Services\RoleService;

class AuthController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }
    protected $scope;
    protected $validRoles = ['superadmin', 'admin', 'tuteur', 'agent'];

    public function register(Request $request)
    {


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:tutor,admin',
            // Additional validation rules for admin role
            'maison_name' => 'required_if:role,admin|string|max:255',
            'maison_adresse' => 'required_if:role,admin|string|max:255',
            //'maison_fichier_enregistrement' => 'required_if:role,admin|file|mimes:pdf,jpeg,png,jpg|max:2048',
            // Additional validation rules for tutor role
            'id_resident' => 'required_if:role,tutor|string|exists:residents,_id',
            'id_maison' => 'required_if:role,tutor|string|exists:maisons,_id',
            ]);
            
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        $role = $this->roleService->assignRole($user, $request);
         
        
        return response()->json([
            'message' => 'Registration successful, awaiting approval'
        ], 201);

        /*
        if ($user) {

            $role = new Role([
                'role' => $request->role,
                'user_id' => $user->_id
            ]);

            $role->save();

            
            $token = $user->createToken('myToken');
            return response()->json([
                'message' => 'User registered successfully',
                "token" => $token->accessToken
            ], 201);

        } else {
            return response()->json(['error' => 'Failed to create user'], 500);
        }*/
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Vérifier si l'utilisateur a un rôle
            $userRole = $user->role()->first();

            //vérifier si le compte est approuvé 
            if ($userRole->is_pending) {
                return response()->json([
                    'message' => 'Your account is pending approval'
                ], 403);
            }

            $this->scope = $userRole ? $userRole->role : null;

            // Utiliser l'e-mail de l'utilisateur comme nom du scope
            $nameScope = $user->email;

            // Créer le jeton uniquement si le rôle est défini
            if ($this->scope) {
                $token = $user->createToken($nameScope, [$this->scope]);
                return response()->json([
                    "token" => $token->accessToken
                ]);
            } else {
                return response()->json([
                    "error" => "User role not found",
                ], 500);
            }
        } else {
            return response()->json([
                "error" => "Unauthorized",
            ], 401);
        }
    }





}



