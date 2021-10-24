<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate storing data
        $request->validate([
            'last_name' => ['required', 'string', 'min:2', 'max:255'],
            'first_name' => ['required', 'string', 'min:2', 'max:255'],
            'patronymic' => ['nullable', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'phone_number' => ['required', 'string', 'unique:users'],
            'birthdate' => ['required', 'date'],
            'password' => ['required', 'string', 'confirmed', 'min:8', 'max:128'],
        ]);

        // Create and persist new user
        $user = new User($request->only(
            'last_name',
            'first_name',
            'patronymic',
            'email',
            'phone_number',
            'birthdate',
            'password',
        ));

        $result = $user->saveOrFail();

        return response()->json([
            'result' => $result,
            'user' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Check if current user can update $user's data
        if (!auth('sanctum')->user()->is($user) && !auth('sanctum')->user()->tokenCan('admin')) {
            throw new AuthenticationException(
                'Unauthenticated.',
                ['sanctum']
            );
        }

        // Validate updating data
        $request->validate([
            'last_name' => ['required', 'string', 'min:2', 'max:255'],
            'first_name' => ['required', 'string', 'min:2', 'max:255'],
            'patronymic' => ['nullable', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'birthdate' => ['required', 'date'],
            'password' => ['nullable', 'string', 'confirmed', 'min:8', 'max:128'],
        ]);

        // Update user's data
        $user->last_name = $request->input('last_name');
        $user->first_name = $request->input('first_name');
        $user->patronymic = $request->input('patronymic');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->birthdate = $request->input('birthdate');

        if ($request->has('password')) {
            $user->password = $request->input('password');
        }

        $result = $user->updateOrFail();

        return response()->json([
            'result' => $result,
            'user' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Check if current user can delete $user
        if (!auth('sanctum')->user()->is($user) && !auth('sanctum')->user()->tokenCan('admin')) {
            throw new AuthenticationException(
                'Unauthenticated.',
                ['sanctum']
            );
        }

        // Delete all personal access tokens of user
        $user->tokens()->delete();

        // Delete user
        $result = $user->deleteOrFail();

        return response()->json([
            'result' => $result,
        ]);
    }
}
