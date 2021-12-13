/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/general.js":
/*!*********************************!*\
  !*** ./resources/js/general.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

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

window.formatCurrencyReal = function () {
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
  if (valor == 'NaN') elemento.value = '';
}; //};


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
        removeOptions(); // add options to select element

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
          } // select only first time


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

/***/ }),

/***/ 1:
/*!***************************************!*\
  !*** multi ./resources/js/general.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /srv/http/plataforma-ed/resources/js/general.js */"./resources/js/general.js");


/***/ })

/******/ });