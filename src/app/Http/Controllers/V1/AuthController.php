<?php


namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Models\Jwt;
use App\Models\LinkedinApi;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

class AuthController extends Controller
{
    public function authorizeClient(): RedirectResponse
    {
        $parameters = http_build_query([
            'response_type' => 'code',
            'client_id' => env('LINKEDIN_APP_CLIENT_ID'),
            'redirect_uri' => route('access-token'),
            'state' => LinkedinApi::STATE,
            'scope' => 'r_liteprofile r_emailaddress w_member_social'
        ]);

        return redirect()->away(LinkedinApi::OAUTH_LINK . '?' . $parameters);
    }

    public function getAccessToken(Request $request): JsonResponse
    {
        $data = $request->all();

        if ($request->has('error')) {
            return response()->json($data['error'], 400);
        }

        $response = Http::asForm()->post(LinkedinApi::ACCESS_TOKEN_LINK, [
            'grant_type' => 'authorization_code',
            'code' => $data['code'],
            'redirect_uri' => route('access-token'),
            'client_id' => env('LINKEDIN_APP_CLIENT_ID'),
            'client_secret' => env('LINKEDIN_APP_CLIENT_SECRET')
        ]);

        if ($response->status() === 401) {
            return response()->json($response->json(), 401);
        }

        $accessToken = $response->json();

        Session::put('linkedin_access', $accessToken['access_token']);

        $linkedinUser = Http::withToken($accessToken['access_token'])->get(LinkedinApi::PROFILE_LINK);

        if(!DB::table('users')->where('linkedin_id', $linkedinUser['id'])->first()) {
            $newUser = new User();
            $newUser->linkedin_id = $linkedinUser['id'];
            $newUser->name = $linkedinUser['localizedFirstName'];
            $newUser->save();
        }

        return response()->json([
            'jwt' => (new Jwt)->generateJwt(Session::getId()),
        ], 200);
    }
}
