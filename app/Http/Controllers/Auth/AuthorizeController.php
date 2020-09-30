<?php

namespace App\Http\Controllers\Auth;

use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorizeController extends Controller
{
    /**
     * The GuzzleHttp\Client instance.
     *
     * @var Client $client
     */
    protected $client;

    /**
     * Build the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('api-gateway.api_endpoint')
        ]);
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id'    => 'required',
        ]);

        if( $validator->fails() ) {
            return response()->json([
                'message' => 'No Client ID Provided.'
            ], 400);
        }

        try {
            $clientFetchReq = $this->client->get('oauth2', [
                'query_params' => [
                    'client_id' => $request->client_id
                ]
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'message' => sprintf("Unable to fetch the client details due to: %s.", $e->getMessage())
            ], 500);
        }

        $clientResponse = json_decode($clientFetchReq->getBody()->getContents(), true);

        dd($clientResponse);
    }
}
