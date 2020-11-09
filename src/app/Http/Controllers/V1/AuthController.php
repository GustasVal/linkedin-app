<?php


namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    const LINKEDIN_OAUTH_LINK = 'https://www.linkedin.com/oauth/v2/authorization';

    public function requestAuthorizationCode()
    {
        $parameters = http_build_query([
            'response_type' => 'code',
            'client_id' => env('LINKEDIN_APP_CLIENT_ID'),
            'redirect_uri' => env('APP_URL') . '/api/auth/callback',
            'state' => uniqid(),
            'scope' => 'r_liteprofile r_emailaddress w_member_social'
        ]);

        return redirect()->away(self::LINKEDIN_OAUTH_LINK . '?' . $parameters);
    }
}
