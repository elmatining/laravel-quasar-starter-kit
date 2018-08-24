<?php namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Services\PassportTokenizerService;
use App\Services\SocialAccountService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Laravel\Socialite\Facades\Socialite;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Cookie;

class AuthController extends Controller
{
    public function redirectToSocial($social)
    {
        try {
            return Socialite::with($social)->redirect();
        } catch (\InvalidArgumentException $e) {
            return view('app');
        }
    }

    public function handleSocialCallback(SocialAccountService $service, $social)
    {
        try {
//            $user = $service->setOrGetUser(Socialite::with($social));
            $user = User::find(1);
            auth()->login($user, true);

            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
//            $token = $user->createToken('gaztronaut CRM')->accessToken;

            return response()->json([
                'data' => [
                    'token' => urlencode($token),
                ]
            ]);

//            return response()->redirectTo(env('APP_MAIN_URL') . '/crm')
//                ->cookie('token', $user->token(), 30);
//            return redirect(env('APP_MAIN_URL') . '/crm')
//            return redirect('/');
//            return redirect('/')
//                ->withCookie(new Cookie(
//                    'token',
//                    $token,
//                    Carbon::now()->addMinute(30),
//                    '/',
//                    null,
//                    false,
//                    false,
//                    true
//                ));

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function logout()
    {
        Auth::logout();

        return view('app');
    }

    public function isAuthenticated(Request $request, ResourceServer $server, Encrypter $encrypter)
    {
//        dump($request->cookie(Passport::cookie()));
//        dump($encrypter->decrypt($request->cookie(Passport::cookie()), false));
//        $raw = explode(':', $encrypter->decrypt($request->cookie(Passport::cookie()), false));
//
//        try {
//            $decodedToken = JWT::decode(
//                $encrypter->decrypt($request->cookie(Passport::cookie()), false),
//                $encrypter->getKey(),
//                ['HS256']
//            );
//
//            dd($decodedToken);
//        } catch (\DomainException $e) {
//            dd($e->getMessage());
//        }
//
//
//        $psr = (new DiactorosFactory)->createRequest($request);
//        $psr = $server->validateAuthenticatedRequest($psr);
//        dd($psr);

        $token = urldecode($request->bearerToken());
        $request->headers->set( 'Authorization', 'Bearer ' . $token, true );

        return response()->json([
            'data' => [
                'user' => auth()->guard('api')->user(),
                'auth' => Auth::check()
            ]
        ]);
    }
}
