<?php

namespace App\Http\Middleware;

use Closure;

class RedirectDomain {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $domain = $request->server("SERVER_NAME");
        $allowedDomains = ['tudovegano2.com.br'];
//dd($domain);
        if ($domain == 'plataforma.empresadigital.net.br' OR $domain == '127.0.0.1') {
            return $next($request);
        } elseif (in_array($domain, $allowedDomains)) {
            $page = Page::find('url', $domain);
            dd($domain);
            return redirect()->route('page.public', compact('page'));
        } else {
            echo "domínio nao autorizado";
        };

    }

}
