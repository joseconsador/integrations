<?php

namespace App\Utilities\Contracts;

use App\Utilities\Diagnostics\DiagnosticCheckResponse;

interface RunsDiagnostics
{
    /**
     * @return DiagnosticCheckResponse
     */
    public function performCheck();
}
