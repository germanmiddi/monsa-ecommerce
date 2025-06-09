<?php

namespace App\Http\Controllers\Manager\Users;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentials;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('Manager/Users/Index', [
            'users' => $users
        ]);
    }

        public function list()
    {

        $length = request()->input('length');

        $column = request()->input('column') ? request()->input('column') : 'id';

        $query = User::query();


        if (request('search')) {
            $search = request('search');

            $query->where('name', 'LIKE', '%' . request('search') . '%');
            $query->orWhere('email', 'LIKE', '%' . request('search') . '%');
            $query->orWhere('email', 'LIKE', '%' . request('search') . '%');

            $query->orWhereHas('role', function ($roleQuery) use ($search) {
                $roleQuery->where('name', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy($column, 'asc')
            ->paginate($length)
            ->withQueryString()
            ->through(fn ($user) =>[
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->role ? [$user->role->name] : [],
                // 'group' => $user->group,
                'created_at' => $user->created_at
            ]);

    }

    public function listForSettings()
    {
        try {
            $users = User::orderBy('name', 'asc')
                ->get()
                ->map(function ($user) {
                    $roles = [];
                    try {
                        $roles = $user->role ? [$user->role->name] : [];
                    } catch (\Exception $e) {
                        $roles = ['Sin rol'];
                    }

                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'roles' => $roles,
                        'created_at' => $user->created_at
                    ];
                });

            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error loading users: ' . $e->getMessage(),
                'users' => []
            ], 500);
        }
    }

        public function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
        ]);

        $randomPassword = Str::random(10);

        $user = User::create([
            'name' => request()->input('name'),
            'email' => request()->input('email'),
            'password' => bcrypt($randomPassword),
            'role_id' => 1 // Asignar automáticamente role_id = 1
        ]);

        // Enviar email con credenciales
        try {
            Mail::to($user->email)->send(new UserCredentials($user, $randomPassword));
            $emailStatus = 'Email enviado correctamente';
        } catch (\Exception $e) {
            $emailStatus = 'Error al enviar email: ' . $e->getMessage();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario creado correctamente. ' . $emailStatus,
            'user' => $user,
            'generated_password' => $randomPassword
        ]);
    }

    public function checkUser(){
        $user = User::where('email', request()->input('email'))->first();
        if($user){
            return response()->json([
                'status' => 'error',
                'message' => 'Email already exists'
            ]);
        }else{
            return response()->json([
                'status' => 'success',
                'message' => 'Email is available'
            ]);
        }
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario actualizado correctamente',
            'user' => $user
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario eliminado correctamente'
        ]);
    }

    public function changePassword(Request $request, User $user)
    {
        $password = $request->input('password');

        // Si no se proporciona contraseña, generar una aleatoria
        if (empty($password)) {
            $password = Str::random(10);
        }

        $user->update([
            'password' => bcrypt($password)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Contraseña cambiada correctamente' . (empty($request->input('password')) ? '. Nueva contraseña: ' . $password : ''),
            'generated_password' => empty($request->input('password')) ? $password : null
        ]);
    }

}