<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Users\UserStoreRequest;
use App\Http\Requests\Dashboard\Users\UserUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{

    public function GetUsers(Request $request)
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::callback('item', function (Builder $query, $value) {
                    $query->where('name', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%")
                        ->orWhere('role', 'like', "%{$value}%");
                }),
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        return $users;
    }

    // Get Auth User
    public function authUser()
    {
        return Auth::user();
    }

    // Get Specific User
    public function getUser($id)
    {
        return User::findOrFail($id);
    }

    // Add User
    public function addUser(UserStoreRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        return response()->json([
            'user' => $user,
        ], 201);
    }

    // Edit User
    public function editUser(UserUpdateRequest $request, $id)
    {
        $request->validated();
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();
        return $user;
    }
    public function editProfile(UserUpdateRequest $request, $id)
    {
        $request->validated();
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return $user;
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return 'success delete';
    }
}
