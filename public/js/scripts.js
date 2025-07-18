/******/ (() => { // webpackBootstrap
/*!*********************************!*\
  !*** ./resources/js/general.js ***!
  \*********************************/
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
;
window.formatCurrencyReal = function (fieldId) {
  var elemento = document.getElementById(fieldId);
  var valor = elemento.value;
  valor = valor + '';
  valor = parseInt(valor.replace(/[\D]+/g, ''));
  valor = valor + '';
  valor = valor.replace(/([0-9]{2})$/g, ",$1");
  if (valor.length > 6) {
    valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
  }
  elemento.value = valor;
  if (valor == 'NaN') elemento.value = '';
};
window.formatCurrencyRealAll = function (inputClass) {
  var elements = document.querySelectorAll(inputClass);
  elements.forEach(function (elemento) {
    var valor = elemento.value;
    valor = valor + '';
    valor = parseInt(valor.replace(/[\D]+/g, ''));
    valor = valor + '';
    valor = valor.replace(/([0-9]{2})$/g, ",$1");
    if (valor.length > 6) {
      valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    }
    elemento.value = valor;
    if (valor == 'NaN') elemento.value = '';
  });
};
window.buttonOpenBox = function (inputClass) {
  var elements = document.querySelectorAll(inputClass);
  elements.forEach(function (elemento) {
    var valor = elemento.value;
    valor = valor + '';
    valor = parseInt(valor.replace(/[\D]+/g, ''));
    valor = valor + '';
    valor = valor.replace(/([0-9]{2})$/g, ",$1");
    if (valor.length > 6) {
      valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    }
    elemento.value = valor;
    if (valor == 'NaN') elemento.value = '';
  });
};
window.loadProjectStagesJson = function (changeId, targetId, url, targetOptionSelected) {
  //    function loadRoteirosSimuladosOrderListJson(
  //	changeId,
  //	targetId,
  //	url,
  //	targetOptionSelected
  //) {
  //alert('teste');
  var changeableElement = document.getElementById(changeId);
  var targetElement = document.getElementById(targetId);
  var removeOptions = function removeOptions() {
    // remove options except empty (first, 0)
    while (targetElement.options.length > 1) {
      targetElement.remove(1);
    }
  };
  var runXhrRequest = function runXhrRequest() {
    if (changeableElement.value) {
      var xhr = new XMLHttpRequest();
      xhr.responseType = 'json';
      xhr.open('GET', url + '/' + changeableElement.value, true);
      xhr.onload = function () {
        removeOptions();

        // add options to select element
        for (var index in xhr.response) {
          console.log(xhr.response[index]);
          var newOption = new Option(xhr.response[index].name, xhr.response[index].id);
          targetElement.add(newOption);
        }
        if (targetOptionSelected) {
          if (targetElement.querySelector('[value="' + targetOptionSelected + '"]')) {
            targetElement.value = targetOptionSelected;
          } else {
            targetElement.value = '';
          }

          // select only first time
          targetOptionSelected = false;
        }
      };
      xhr.send();
    } else {
      removeOptions();
    }
  };
  runXhrRequest();
  changeableElement.onchange = runXhrRequest;
};

// Oculta/mostra linha de formulário a partir de clique em botao
window.toogleAddForm = function (target) {
  var slideUp = function slideUp(target, duration) {
    target.style.transitionProperty = 'height, margin, padding'; /* [1.1] */
    target.style.transitionDuration = duration + 'ms'; /* [1.2] */
    target.style.boxSizing = 'border-box'; /* [2] */
    target.style.height = target.offsetHeight + 'px'; /* [3] */

    target.style.height = 0; /* [4] */
    target.style.paddingTop = 0; /* [5.1] */
    target.style.paddingBottom = 0; /* [5.2] */
    target.style.marginTop = 0; /* [6.1] */
    target.style.marginBottom = 0; /* [7.2] */
    target.style.overflow = 'hidden'; /* [7] */

    window.setTimeout(function () {
      target.style.display = 'none'; /* [8] */
      target.style.removeProperty('height'); /* [9] */
      target.style.removeProperty('padding-top'); /* [10.1] */
      target.style.removeProperty('padding-bottom'); /* [10.2] */
      target.style.removeProperty('margin-top'); /* [11.1] */
      target.style.removeProperty('margin-bottom'); /* [11.2] */
      target.style.removeProperty('overflow'); /* [12] */
      target.style.removeProperty('transition-duration'); /* [13.1] */
      target.style.removeProperty('transition-property'); /* [13.2] */
    }, duration);
  };
  var slideDown = function slideDown(target, duration) {
    target.style.removeProperty('display'); /* [1] */
    var display = window.getComputedStyle(target).display;
    if (display === 'none') {
      /* [2] */
      display = 'block';
    }
    target.style.display = display;
    var height = target.offsetHeight; /* [3] */
    target.style.height = 0; /* [4] */
    target.style.paddingTop = 0; /* [5.1] */
    target.style.paddingBottom = 0; /* [5.2] */
    target.style.marginTop = 0; /* [6.1] */
    target.style.marginBottom = 0; /* [6.2] */
    target.style.overflow = 'hidden'; /* [7] */

    target.style.boxSizing = 'border-box'; /* [8] */
    target.style.transitionProperty = "height, margin, padding"; /* [9.1] */
    target.style.transitionDuration = duration + 'ms'; /* [9.2] */
    target.style.height = height + 'px'; /* [10] */
    target.style.removeProperty('padding-top'); /* [11.1] */
    target.style.removeProperty('padding-bottom'); /* [11.2] */
    target.style.removeProperty('margin-top'); /* [12.1] */
    target.style.removeProperty('margin-bottom'); /* [12.2] */

    window.setTimeout(function () {
      target.style.removeProperty('height'); /* [13] */
      target.style.removeProperty('overflow'); /* [14] */
      target.style.removeProperty('transition-duration'); /* [15.1] */
      target.style.removeProperty('transition-property'); /* [15.2] */
    }, duration);
  };
  var slideToggle = function slideToggle(target) {
    var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 200;
    if (window.getComputedStyle(target).display === 'none') {
      return slideDown(target, duration);
    } else {
      return slideUp(target, duration);
    }
  };
  slideToggle(document.getElementById(target), 200);
};
/******/ })()
;