<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Se comenta para que en caso de que una solicitud http no sea de tipo json no retorne la ruta login, sino
        // la exception de tipo json.

        // if (! $request->expectsJson()) {
        //     return route('login');
        // }
    }
}
