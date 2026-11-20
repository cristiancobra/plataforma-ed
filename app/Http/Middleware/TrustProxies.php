<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array|string|null
     */
    protected $proxies;

    // $headers não é mais sobrescrito: o default do Illuminate\Http\Middleware\TrustProxies já
    // confia em todos os cabeçalhos X-Forwarded-* individualmente (equivalente ao antigo
    // HEADER_X_FORWARDED_ALL do fideloper/proxy, que não existe mais).
}
