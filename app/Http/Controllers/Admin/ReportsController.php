<?php

namespace App\Http\Controllers\Admin;
use Auth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\Program;
use App\Models\Session;
use App\Models\Candidate;
use Illuminate\Support\Facades\Log;

class ReportsController
{
    public function index()
    {
        $user = Auth::user();

        // Get oauth2 token using a POST request
        $curlPostToken = curl_init();
        curl_setopt_array($curlPostToken, array(
            CURLOPT_URL => "https://login.windows.net/common/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_PROXY => "",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POSTFIELDS => array(
                'grant_type'    => 'password',
                'scope'         => 'openid',
                'resource'      => 'https://analysis.windows.net/powerbi/api',
                'client_id'     => config('powerbi.applicationID'),
                'client_secret' => config('powerbi.clientSecret'),
                'username'      => config('powerbi.email'),
                'password'      => config('powerbi.password'),
            )
        ));
        $tokenResponse = curl_exec($curlPostToken);
        $tokenError = curl_error($curlPostToken);
        curl_close($curlPostToken);

        // decode result, and store the access_token in $embeddedToken variable:
        $tokenResult   = json_decode($tokenResponse, true);
        $token         = $tokenResult["access_token"];
        $embeddedToken = "Bearer "  . ' ' .  $token;

        // Use the token to get an embedded URL using a GET request
        $curlGetUrl = curl_init();
        curl_setopt_array($curlGetUrl, array(
            CURLOPT_URL            => "https://api.powerbi.com/v1.0/myorg/groups/". config('powerbi.workspaceID') ."/reports/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET",
            CURLOPT_PROXY => "",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => array(
                "Authorization: $embeddedToken",
                "Cache-Control: no-cache",
            ),
        ));
        $embedResponse = curl_exec($curlGetUrl);
        $embedError = curl_error($curlGetUrl);
        curl_close($curlGetUrl);

        if ($embedError) {
            Log::error("cURL Error #:" . $embedError);
            //FALTA mostrar error a usuario

        } else {
            $embedResponse = json_decode($embedResponse, true);
            //Add parameter to report to get only requested poll_id
            $embedUrl = $embedResponse['value'][0]['embedUrl'];
            return view('reports.index', compact('user', 'embedUrl', 'token'));
        }
    }
}
