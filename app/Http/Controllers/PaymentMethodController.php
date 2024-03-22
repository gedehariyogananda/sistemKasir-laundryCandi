<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\UserPurchased;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    private $checkUser;
    private $payments;
    private $users;

    public function __construct()
    {
        $this->checkUser = User::latest()->first();
        $this->payments = PaymentMethod::all();
        $this->users = UserPurchased::with(['user', 'spesification']);
    }

    public function index()
    {
        $checkUser = $this->checkUser;
        $users = $this->users->where('user_id', $checkUser->id)->first();
        $payments = $this->payments;
        return view('checkout.index', compact('users', 'payments'));
    }

    public function update(Request $request)
    {
        $checkUser = $this->checkUser;
        $this->users->where('user_id', $checkUser->id)->update([
            'status_laundry' => "Success",
            'payment_method_id' => $request->payment_method_id,
        ]);

        return redirect()->route('purchased.index')->with('success', 'Data Berhasil Di Tambahkan');
    }
}
