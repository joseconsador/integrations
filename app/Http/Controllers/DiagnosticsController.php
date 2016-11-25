<?php

namespace App\Http\Controllers;

use App\Utilities\Diagnostics;
use App\Utilities\Diagnostics\ContentSecurePolicyCheck;
use App\Utilities\Diagnostics\SkypeTabLibCheck;
use App\Utilities\Diagnostics\XFrameOptionsCheck;
use App\Utilities\Diagnostics\MicrosoftTabLibCheck;
use GuzzleHttp\Client;

class DiagnosticsController extends Controller
{
    /**
     * @var Client Client
     */
    private $client;

    /**
     * DiagnosticsController constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Endpoint to say whether the app has started successfully.
     *
     * @return string
     */
    public function ping()
    {
        \Redis::ping();

        return 'ok';
    }

    /**
     * Checks if dependencies and configurations are all correct.
     *
     * @param Diagnostics $diagnostics
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function diagnostic(Diagnostics $diagnostics)
    {
        $diagnostics->runDiagnostics();

        $responseBody = [
            'success' => $diagnostics->getStatusCode() == Diagnostics::ALL_TESTS_PASS,
            'checks' => $diagnostics->getResults()
        ];

        return response()->json($responseBody, $diagnostics->getStatusCode());
    }
}
