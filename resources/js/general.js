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
//
//
//    function loadRoteirosSimuladosOrderListJson(
//	changeId,
//	targetId,
//	url,
//	targetOptionSelected
//) {
//	var changeableElement = document.getElementById(changeId);
//	var targetElement = document.getElementById(targetId);
//	
//	var removeOptions = function() {
//		// remove options except empty (first, 0)
//		while (targetElement.options.length > 1) {
//			targetElement.remove(1);
//		}
//	};
//	
//	var runXhrRequest = function() {
//		if(changeableElement.value) {
//			var xhr = new XMLHttpRequest();
//
//			xhr.responseType = 'json';
//			xhr.open('GET', url + '/' + changeableElement.value, true);
//			xhr.onload = function() {
//				removeOptions();
//				
//				// add options to select element
//				for(var index in xhr.response) {
//					var newOption = new Option(
//						xhr.response[index],
//						index
//					);
//					targetElement.add(newOption);
//				}
//				
//				if(targetOptionSelected) {
//					if (
//						targetElement.querySelector('[value="' + targetOptionSelected + '"]')
//					) {
//						targetElement.value = targetOptionSelected;
//					}
//					else {
//						targetElement.value = '';
//					}
//					
//					// select only first time
//					targetOptionSelected = false;
//				}
//			};
//			xhr.send();
//		}
//		else {
//			removeOptions();
//		}
//	};
//	
//	runXhrRequest();
//	
//	changeableElement.onchange = runXhrRequest;
//}

    