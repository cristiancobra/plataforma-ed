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
            $pages = Page::where('url', $domain)
                    ->get();
            if ($pages == null) {
                echo "Você não possui landing page com este domínio configurado";
            } else {
        $path = $request->path();
        dd($path);
        if($path == '/') {
            $path = 'home';
        }else{
        $page = $pages->where('slug', $path);
        }

                
                return redirect()->route('page.public', compact('page'));
            }
        } else {
            echo "domínio nao autorizado";
        };
    }

}
