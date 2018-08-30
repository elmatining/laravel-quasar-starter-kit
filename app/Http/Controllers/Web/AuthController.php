<?php namespace App\Http\Controllers\Web;

use App\Services\SocialAccountService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginSocial(Request $request, SocialAccountService $service, $social)
    {
        $token = $request->header('X-Authorization');

        $user = $service->setOrGetUser($social, $token);

        if (auth()->attempt(['email' => $user->email, 'password' => $user->password])) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        /* Revoked previously created tokens & create a new one */
        $user->tokens()->delete();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;


        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();

        return response()->json([
            'message' => 'Authorized'
        ], 200, ['Authorization' => "Bearer {$tokenResult->accessToken}"]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response(['code' => 200, 'message' => 'You are successfully logged out'], 200);
    }

    public function getAuthenticated(Request $request)
    {
        return response()->json(['user' => $request->user()->load('profile')]);
    }
}
