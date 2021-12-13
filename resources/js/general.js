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
};


window.formatCurrencyReal = function() {

//        $('[name=totalPrice]').maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});

        var elemento = document.getElementById('totalPrice');
        var valor = elemento.value;
        

        valor = valor + '';
        valor = parseInt(valor.replace(/[\D]+/g, ''));
        valor = valor + '';
        valor = valor.replace(/([0-9]{2})$/g, ",$1");

        if (valor.length > 6) {
            valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
        }

        elemento.value = valor;
        if(valor == 'NaN') elemento.value = '';
        
    };

//};

window.loadProjectStagesJson = function(
	changeId,
	targetId,
	url,
	targetOptionSelected
                ) {
//    function loadRoteirosSimuladosOrderListJson(
//	changeId,
//	targetId,
//	url,
//	targetOptionSelected
//) {
//alert('teste');
	var changeableElement = document.getElementById(changeId);
	var targetElement = document.getElementById(targetId);
	
	var removeOptions = function() {
		// remove options except empty (first, 0)
		while (targetElement.options.length > 1) {
			targetElement.remove(1);
		}
	};
	
	var runXhrRequest = function() {
		if(changeableElement.value) {
			var xhr = new XMLHttpRequest();

			xhr.responseType = 'json';
			xhr.open('GET', url + '/' + changeableElement.value, true);
			xhr.onload = function() {
				removeOptions();
				
				// add options to select element
				for(var index in xhr.response) {
                                    console.log(xhr.response[index]);
					var newOption = new Option(
						xhr.response[index].name,
						xhr.response[index].id
					);
					targetElement.add(newOption);
				}
				
				if(targetOptionSelected) {
					if (
						targetElement.querySelector('[value="' + targetOptionSelected + '"]')
					) {
						targetElement.value = targetOptionSelected;
					}
					else {
						targetElement.value = '';
					}
					
					// select only first time
					targetOptionSelected = false;
				}
			};
			xhr.send();
		}
		else {
			removeOptions();
		}
	};
	
	runXhrRequest();
	
	changeableElement.onchange = runXhrRequest;
};

        