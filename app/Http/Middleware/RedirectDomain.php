<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Page;

class RedirectDomain {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $domain = $request->server('SERVER_NAME');

        if ($domain == 'plataforma.empresadigital.net.br' OR $domain == '127.0.0.1') {
            return $next($request);
        }

        $allowedDomains = Page::allowedDomains();

        if (in_array($domain, $allowedDomains)) {
            $page = Page::where('url', $domain)
                    ->where('slug', 'home')
                    ->get();

            if ($page == null) {
                echo "Você não possui landing page com SLUG 'HOME' configurada com este domínio";
            } else {
        return redirect()->route('page.public', ['page' => $page]);
            }
        } else {
            echo "domínio nao autorizado";
        };
    }

}
