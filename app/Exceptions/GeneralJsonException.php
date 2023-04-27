<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class GeneralJsonException extends Exception
{
    public function report()
    {
        # code...
    }

    public function render($request)
    {
        return new JsonResponse([
            "error" =>[
                "message" => $this->getMessage()
            ]
            ], $this->code);
    }
}
