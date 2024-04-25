<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        
        /**
         * @OA\Post(
         *      path="/api/users",
         *      summary="Cria usuário",
         *      @OA\Response(response=200, description="Usuário criado!")
         * )
         */
        $data = $request->all();
        $name = $data['name'];
        $username = $data['username'];
        $password = $data['password'];

        User::create([
            'name' => $name,
            'username' => $username,
            'password' => Hash::make($password)
        ]);

        return response()->json([
            "message" => "Usuário criado com sucesso!",
            200
        ]);
    }

    /**
     * @OA\Post(
     *      path="/api/login",
     *      summary="Autenticação",
     *      @OA\Response(response=200, description="Aunteticação efetuada!")
     * )
     */
    public function login(Request $request)
    {
        $user= User::where('username', $request->header('username'))->first();
        // print_r($data);
            if (!$user || !Hash::check($request->header('password'), $user->password)) {
                return response([
                    'message' => ['Credenciais inválidas.']
                ], 404);
            }
        
            $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
             return response()->json($token);
    }
}