<?php

use Illuminate\Http\Request;
use Domain\Shared\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', function (Request $request) {
    $loginUserData = $request->validate([
        'email'=>'required|string|email',
        'password'=>'required|min:8'
    ]);
    $user = User::where('email',$loginUserData['email'])->first();
    if(!$user || !Hash::check($loginUserData['password'],$user->password)){
        return response()->json([
            'message' => 'Invalid Credentials'
        ],401);
    }
    $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
    return response()->json([
        'access_token' => $token,
    ]);
});
Route::middleware('auth:sanctum')->group(static function (): void {
    Route::prefix('contacts')->as('contacts')->group(base_path('routes/api/contacts.php'));
});


