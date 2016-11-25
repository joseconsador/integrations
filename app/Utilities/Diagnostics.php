<?php

namespace App\Utilities;

use App\Utilities\Contracts\RunsDiagnostics;

class Diagnostics
{
    const ALL_TESTS_PASS = 200;
    const OPTIONAL_FAILED = 299;
    const MANDATORY_FAILED = 503;
    /**
     * @var int
     */
    private $statusCode = 200;
    /**
     * @var array
     */
    private $checks = [];
    /**
     * @var array
     */
    private $results = [];
    /**
     * @var bool
     */
    private $success = true;

    /**
     * Adds an implementation of RunsDiagnostics to the checks to be performed.
     *
     * @param RunsDiagnostics $check
     */
    public function addCheck(RunsDiagnostics $check)
    {
        $this->checks[] = $check;
    }

    /**
     * Run all checks defined using addCheck()
     */
    public function runDiagnostics()
    {
        foreach ($this->checks as $check) {
            $result = $check->performCheck()->toArray();

            if ($result['success'] == false) {
                $this->success = false;

                if ($this->statusCode != self::MANDATORY_FAILED && ! $result['mandatory']) {
                    $this->statusCode = self::OPTIONAL_FAILED; // An optional check failed
                } else {
                    $this->statusCode = self::MANDATORY_FAILED; // A mandatory check failed
                }
            }

            $this->results[] = $result;
        }

        return $this->results;
    }

    /**
     * Return the status code based on the checks.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Return the results from all checks.
     *
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }
}
