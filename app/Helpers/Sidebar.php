<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists('createSidebarItem')) {

// cria um botao com simbolo de OLHO para adicionar visualizar um model
    function createSidebarItem() {
        echo "
         <div class='dropdown'>
            <button class='dropdown-btn dropdown-toggle' type='button' id='dropdownMenuButtonFinanceiro' data-bs-toggle='dropdown' aria-expanded='false'>
                <i class='fas fa-money-bill'></i>
                <span class='d-none d-xl-inline'>FINANCEIRO</span>
            </button>
            <ul class='dropdown-menu bg-primary' aria-labelledby='dropdownMenuButtonFinanceiro'>
                <li class='nav-item'>
                    <a class='dropdown-item link-light' href='{{route('invoice.index')}}'>
                        <i class='fas fa-receipt ms-0 me-1'></i>
                        <span class='d-xl-inline'>FATURAS</span>
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='dropdown-item link-light' href='{{route('bankAccount.index')}}'>
                        <i class='fas fa-piggy-bank ms-0 me-1'></i>
                        <span class='d-xl-inline'>CONTAS BANCÁRIAS</span>
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='dropdown-item link-light' href='{{route('transaction.index')}}'>
                        <i class='fas fa-sync-alt ms-0 me-1'></i>
                        <span class='d-xl-inline'>FLUXO DE CAIXA</span>
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='dropdown-item link-light' href='{{route('company.index', ['typeCompanies' => 'fornecedor'])}}'>
                        <i class='fas fa-truck ms-0 me-1'></i>
                        <span class='d-xl-inline'>FORNECEDORES</span>
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='dropdown-item link-light' href='{{route('product.index', ['variation' => 'despesa'])}}'>
                        <i class='fas fa-boxes ms-0 me-1'></i>
                        <span class='d-xl-inline'>ITENS DE DESPESA</span>
                    </a>
                </li>
            </ul>
        </div>           
";
    }

}