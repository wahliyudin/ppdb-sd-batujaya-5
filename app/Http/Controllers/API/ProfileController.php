<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequestUpdate;
use App\Http\Requests\ProfileRequestUpdate;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function updateProfile(ProfileRequestUpdate $request)
    {
        try {
            User::find($request->id)->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Profile berhasil diubah',
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ? $code = 400 : $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }

    public function updatePassword(PasswordRequestUpdate $request)
    {
        try {
            $user = User::find($request->id);
            if (Hash::check($request->password, $user->password)) {
                $user->update([
                    'password' => $request->new_password
                ]);
            } else {
                throw new Exception('Password Tidak cocok!', 400);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil diubah',
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ? $code = 400 : $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }
}
