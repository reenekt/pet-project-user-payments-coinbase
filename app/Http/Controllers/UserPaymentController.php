<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class UserPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return response()->json($user->payments()->with('user_from')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        throw new \BadMethodCallException('NOT IMPLEMENTED');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Payment $payment)
    {
        return response()->json([
            'user' => $user,
            'payment' => $payment->load('user_from'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Payment $payment)
    {
        throw new \BadMethodCallException('NOT IMPLEMENTED');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Payment $payment)
    {
        throw new \BadMethodCallException('NOT IMPLEMENTED');
    }
}
