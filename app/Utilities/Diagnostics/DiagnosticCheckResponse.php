<?php

namespace App\Utilities\Diagnostics;

use Illuminate\Contracts\Support\Arrayable;

class DiagnosticCheckResponse implements Arrayable
{
    public $name;
    public $success;
    public $mandatory;
    public $resource;
    public $message;

    /**
     * DiagnosticCheckResponse constructor
     *
     * @param string $name
     * @param boolean $success
     * @param boolean $mandatory
     * @param string $resource
     * @param string $message
     */
    public function __construct($name, $success, $mandatory, $resource = '', $message = '')
    {
        if (! $success && empty($message)) {
            $message = "Dependency for $resource could not be resolved.";
        }

        $this->name = $name;
        $this->success = $success;
        $this->mandatory = $mandatory;
        $this->resource = $resource;
        $this->message = (! $success) ? $message : '';
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'success' => $this->success,
            'mandatory' => $this->mandatory,
            'resource' => $this->resource,
            'message' => $this->message
        ];
    }
}
