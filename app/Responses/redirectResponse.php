<?php

namespace App\Responses;
use Redirect;

class redirectResponse
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handle(string $route, bool $success, string $message)
    {
        return $success
            ? Redirect::route($route)->with('success', $message)
            : Redirect::back()->withErrors($message);
    }
}
