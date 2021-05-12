/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function buttonFilter() {
    $(document).ready(function () {
        //botao de exibir filtro
        $("#filter_button").click(function () {
            $("#filter").slideToggle(600);
        });

    });
}

function confirmDelete() {
//    var confirmation = confirm('Você tem certeza que deseja apagar? Essa operação NÃO pode ser desfeita');
    if(!confirm("Você tem certeza que deseja apagar? Essa operação NÃO pode ser desfeita"))
      event.preventDefault();
//  
//  
//  
//    if (confirmation === true) {
//        txt = 'apagou';
//    } else {
//        txt = 'NAO apagou';
//    }
//    return txt;
}