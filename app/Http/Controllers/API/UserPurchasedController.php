<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPurchased;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UserPurchasedController extends Controller
{
    private $userPurchased;

    public function __construct()
    {
        $this->userPurchased = UserPurchased::with(['user', 'spesification', 'payment_method']);
    }

    // ---------------------------------------- GET DATA CUSTOMER -------------------------------------//
    public function getAllDataCustomer()
    {
        $dataUser = $this->userPurchased->get();
        $mappedData = $dataUser->map(function ($data) {
            return [
                'id' => $data->id,
                'noCustomer' => "#" . $data->user->no_pelanggan,
                'userPurchased' => $data->user->name,
                'spesification' => $data->spesification->spesifikasi_cuci,
                'quantity' => $data->quantity_laundry . "kg",
                'entryDate' => Carbon::parse($data->tanggal_pengajuan_laundry)->format('d M Y'),
                'exitDate' =>  Carbon::parse($data->tanggal_selesai_laundry)->format('d M Y'),
                'subTotal' => "Rp " . number_format($data->subtotal_laundry, 0, ',', '.'),
                'paymentMethod' => $data->payment_method ? $data->payment_method->payment_method_name : "Not Yet Purchased",
            ];
        });
        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Di Tampilkan',
            'data' => $mappedData,
        ], 202);
    }

    // ---------------------------------------- GET PRINT NOTE CUSTOMER BY ID -------------------------------------//
    public function getPrintNoteCustomer($id)
    {
        try {
            $dataUser = $this->userPurchased->where('id', $id)->first();
            $mappedData = [
                'noCustomer' => "#" . $dataUser->user->no_pelanggan,
                'userPurchased' => $dataUser->user->name,
                'spesification' => $dataUser->spesification->spesifikasi_cuci,
                'quantity' => $dataUser->quantity_laundry . "kg",
                'entryDate' => Carbon::parse($dataUser->tanggal_pengajuan_laundry)->format('d M Y'),
                'exitDate' =>  Carbon::parse($dataUser->tanggal_selesai_laundry)->format('d M Y'),
                'subTotal' => "Rp " . number_format($dataUser->subtotal_laundry, 0, ',', '.'),
                'paymentMethod' => $dataUser->payment_method ? $dataUser->payment_method->payment_method_name : "Not Yet Purchased",
            ];

            if ($mappedData) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data Berhasil Di Tampilkan',
                    'data' => $mappedData,
                ], 202);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Gagal Di Tampilkan',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data Gagal Di Tampilkan',
                'error' => $e->getMessage(),
            ], 404);
        }
    }


    // ---------------------------------------- INSERT DATA CUSTOMER -------------------------------------//

    public function insertDataCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'no_telp' => ['required', 'numeric', 'min:8'],
            'gender' => ['required', 'in:L,P'],
            'quantity_laundry' => ['required'],
            'tanggal_selesai_laundry' => ['required'],
            'alamat' => ['min:1'],
        ]);

        try {
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'error' => $validator->errors(),
                ]);
            } else {
                // insert data ke table user
                $userPurchased = User::create([
                    'no_pelanggan' => Str::random(10),
                    'name' => $request->name,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat ? $request->alamat : 'tanpa alamat',
                    'gender' => $request->gender,
                ]);

                // lgsung auto insert ambil id nya ke table user purchased
                $insertUserPurchased = UserPurchased::create([
                    'user_id' => $userPurchased->id,
                    'tanggal_selesai_laundry' => $request->tanggal_selesai_laundry,
                    'quantity_laundry' => $request->quantity_laundry,
                    'spesification_id' => $request->spesification_id,
                    'tanggal_pengajuan_laundry' => now(),
                ]);

                if ($userPurchased && $insertUserPurchased) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Data Berhasil Di Tambahkan',
                        'data' => $userPurchased,
                    ], 202);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data Gagal Di Tambahkan',
                    ], 404);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data Gagal Di Tambahkan',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    // ---------------------------------------- UPDATE DATA CUSTOMER -------------------------------------//
    public function updateOtherData(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'payment_method_id' => ['required'],
        ]);

        try {
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'error' => $validator->errors(),
                ]);
            } else {

                // userPurchased yang latest udah pasti akhir masuk == customer baru
                $updatePurchased = $this->userPurchased->latest()->first();

                // update data user purchased where user_id is dari id updatePurchased
                $doneProcess = $this->userPurchased->where('user_id', $updatePurchased->id)->update([
                    'status_laundry' => "Success",
                    'payment_method_id' => $request->payment_method_id,
                    // rumus harga subtotal harga/kilo * quality laundry
                    'subtotal_laundry' => $updatePurchased->spesification->hargakilo * $updatePurchased->quantity_laundry,
                ]);

                if ($doneProcess) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Data Berhasil Di update',
                    ], 202);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data Gagal Di update',
                    ], 404);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data Gagal Di update',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    // ---------------------------------------- DELETE DATA CUSTOMER -------------------------------------//
    public function destroyData($id)
    {
        $initDeleteUser = User::where('id', $id)->get();

        try {
            $deleteUser = User::where('id', $id)->delete();
            $deleteUserPurchased = UserPurchased::where('user_id', $id)->delete();

            if ($deleteUser && $deleteUserPurchased) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data Berhasil Di Hapus',
                    'dataDeleted' => $initDeleteUser,
                ], 202);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Gagal Di Hapus',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data Gagal Di Hapus',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
