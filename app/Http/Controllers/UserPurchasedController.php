<?php

namespace App\Http\Controllers;

use App\Models\Spesification;
use App\Models\User;
use App\Models\UserPurchased;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserPurchasedController extends Controller
{

    private $userPurchased;
    private $spesifications;
    private $checkUser;

    public function __construct()
    {
        $this->userPurchased = UserPurchased::with(['user', 'spesification']);
        $this->spesifications = Spesification::all();
        $this->checkUser = User::latest()->first();
    }

    public function index()
    {
        $userPurchaseds = $this->userPurchased->get();
        return view('purchased.index', compact('userPurchaseds'));
    }

    public function create()
    {
        $spesifications = $this->spesifications;
        return view('purchased.create', compact('spesifications'));
    }

    public function created()
    {
        $spesifications = $this->spesifications;
        $checkUser = $this->checkUser;
        $userPurchaseds = $this->userPurchased->where('user_id', $checkUser->id)->get();

        return view('purchased._create', compact('spesifications', 'userPurchaseds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'no_telp' => ['required', 'min:3'],
            'gender' => ['required', 'min:1'],
            'quantity_laundry' => ['required'],
            'tanggal_selesai_laundry' => ['required'],
        ]);

        if ($request->alamat) {
            $request['alamat'] = $request->alamat;
        } else {
            $request['alamat'] = 'tanpa alamat';
        }

        $usersDatas = User::create([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'gender' => $request->gender,
            'no_pelanggan' => Str::random(10),
            'alamat' => $request->alamat,
        ]);

        UserPurchased::create([
            'user_id' => $usersDatas->id,
            'spesification_id' => $request->spesification_id,
            'quantity_laundry' => $request->quantity_laundry,
            'tanggal_pengajuan_laundry' => now(),
            'tanggal_selesai_laundry' => $request->tanggal_selesai_laundry,
            'payment_method_id' => $request->payment_method_id,
            'status_laundry' => 'pending',
            'subtotal_laundry' => '0',
        ]);

        $test = UserPurchased::latest()->first();
        UserPurchased::with(['user', 'spesification'])->where('user_id', $test->user_id)->update([
            'subtotal_laundry' => $test->spesification->hargakilo * $test->quantity_laundry,
        ]);

        return redirect('data-customer/entry-data/created')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit()
    {
        $id = $this->checkUser;
        $spesifications = $this->spesifications;
        $bind = $this->userPurchased->where('user_id', $id->id)->first();
        $userPurchaseds = $this->userPurchased->where('user_id', $id->id)->get();
        return view('purchased._create', compact('spesifications', 'bind', 'userPurchaseds'));
    }

    public function update(Request $request)
    {
        $id = $this->checkUser;
        UserPurchased::where('user_id', $id->id)->update([
            'spesification_id' => $request->spesification_id,
            'quantity_laundry' => $request->quantity_laundry,
            'tanggal_pengajuan_laundry' => now(),
            'tanggal_selesai_laundry' => $request->tanggal_selesai_laundry,
            'payment_method_id' => $request->payment_method_id,
            'status_laundry' => 'pending',
        ]);

        $afterCheck = UserPurchased::latest()->first();
        UserPurchased::with(['user', 'spesification'])->where('user_id', $afterCheck->user_id)->update([
            'subtotal_laundry' => $afterCheck->spesification->hargakilo * $afterCheck->quantity_laundry,
        ]);

        User::where('id', $id->id)->update([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
        ]);
        return redirect('data-customer/entry-data/created')->with('success', 'Data Customer Berhasil Di Update');
    }

    public function destroyPemesanan($id)
    {
        UserPurchased::where('user_id', $id)->update([
            'spesification_id' => null,
            'quantity_laundry' => null,
            'tanggal_pengajuan_laundry' => null,
            'tanggal_selesai_laundry' => null,
            'payment_method_id' => null,
            'status_laundry' => null,
        ]);

        User::where('id', $id)->update([
            'alamat' => null,
        ]);

        return redirect('/data-customer/entry-data/pemesanan')->with('success', 'Pemesanan User Berhasil Di Clear');
    }

    public function nota($id)
    {
        $userPurchased = UserPurchased::with(['user', 'spesification', 'payment_method'])->where('user_id', $id)->first();
        return view('nota.index', compact('userPurchased'));
    }

    public function destroy($id)
    {
        UserPurchased::where('user_id', $id)->delete();
        User::where('id', $id)->delete();
        return redirect('/data-customer/entry-data')->with('success', 'Data Berhasil Di Hapus');
    }
}
