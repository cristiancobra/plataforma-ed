<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SiteCliente extends Controller {

    /**
     * Gera o link do site do cliente no Menu
     */
    
    public function EditarSite() {
        $url_cliente = Auth::user()->dominio;
        
        return view('editarsite', [
                'url_cliente' => $url_cliente
            ]);
               
    }
    
    public function PostarSite() {
        $url_cliente = Auth::user()->dominio;
        return Redirect('https://'.$url_cliente.'/wp-admin/post-new.php');
    }       
    }
         /**
        return Redirect('https://'.$url_cliente.'/wp-admin');
          * 
          * 
          * 
        if ($user->perfil == "administrador") {
            return view('admin/painel-admin', [
                'user' => $user
            ]);
        } else {
            return view('painel', [
                'user' => $user
            ]);
        }
    }
     */