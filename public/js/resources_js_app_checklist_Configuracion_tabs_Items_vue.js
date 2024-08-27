"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_app_checklist_Configuracion_tabs_Items_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/app/checklist/Configuracion/tabs/Items.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/app/checklist/Configuracion/tabs/Items.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! sweetalert2 */ "./node_modules/sweetalert2/dist/sweetalert2.all.js");
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(sweetalert2__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_simpleTable_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/components/simpleTable.vue */ "./resources/js/components/simpleTable.vue");
/* harmony import */ var _components_modalComponent_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/components/modalComponent.vue */ "./resources/js/components/modalComponent.vue");
/* harmony import */ var _components_Form_Select2_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/components/Form/Select2.vue */ "./resources/js/components/Form/Select2.vue");
/* harmony import */ var _components_paginate_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @/components/paginate.vue */ "./resources/js/components/paginate.vue");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Select2: _components_Form_Select2_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
    simpleTable: _components_simpleTable_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    BootstrapModal: _components_modalComponent_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    paginate: _components_paginate_vue__WEBPACK_IMPORTED_MODULE_4__["default"]
  },
  data: function data() {
    return {
      items: [],
      itemsPaginate: [],
      tipos: [],
      id: 0,
      name: '',
      description: '',
      type_id: '',
      file: '',
      columns: [{
        title: 'ID',
        field: 'id'
      }, {
        title: 'Nombre',
        field: 'name'
      }, {
        title: 'Descripción',
        field: 'description'
      }, {
        title: 'Tipo',
        field: 'type.name'
      }, {
        title: 'Acciones',
        field: 'acciones'
      }],
      criticalArea: [{
        key: 'approved',
        value: 'Aprobado'
      }, {
        key: 'approved with observation',
        value: 'Aprobado con observaciones'
      }, {
        key: 'refused',
        value: 'Rechazado'
      }],
      prioridad: '',
      prioridades: [{
        key: 'baja',
        value: 'Baja'
      }, {
        key: 'media',
        value: 'Media'
      }, {
        key: 'alta',
        value: 'Alta'
      }],
      responsibles_id: 0,
      responsibles: [],
      workers: [],
      areas: [],
      area_id: '',
      is_attachement: false,
      is_seats: false,
      is_tripulacion: false,
      is_conteo: false,
      is_observation: false,
      respuestas: '',
      requerido: '',
      field_id: 0,
      filtro_tipo_id: 0
    };
  },
  methods: {
    getAreas: function getAreas() {
      var _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var _yield$axios$get, data, status;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _context.next = 3;
              return axios.get('/areas');
            case 3:
              _yield$axios$get = _context.sent;
              data = _yield$axios$get.data;
              status = _yield$axios$get.status;
              // replace '/areas' with your actual API endpoint
              if (status === 200) {
                _this.areas = data;
              }
              _context.next = 12;
              break;
            case 9:
              _context.prev = 9;
              _context.t0 = _context["catch"](0);
              console.log(_context.t0);
            case 12:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 9]]);
      }))();
    },
    cargarItems: function cargarItems() {
      var _arguments = arguments,
        _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var page, url, _yield$axios$get2, data, status;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              page = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : 1;
              _context2.prev = 1;
              url = '/checklist/item';
              if (page > 1) {
                url = url + '?page=' + page;
              }
              if (_this2.filtro_tipo_id !== 0) {
                url = '/checklist/item?filtro[type_id]=' + _this2.filtro_tipo_id;
              }
              _context2.next = 7;
              return axios.get(url);
            case 7:
              _yield$axios$get2 = _context2.sent;
              data = _yield$axios$get2.data;
              status = _yield$axios$get2.status;
              if (status === 200) {
                _this2.items = data.data;
                _this2.itemsPaginate = data;
              }
              _context2.next = 16;
              break;
            case 13:
              _context2.prev = 13;
              _context2.t0 = _context2["catch"](1);
              console.log(_context2.t0);
            case 16:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[1, 13]]);
      }))();
    },
    addResponsibles: function addResponsibles() {
      var _this3 = this;
      var worker = this.workers.find(function (worker) {
        return worker.id === _this3.responsibles_id;
      });
      if (worker) {
        this.responsibles.push(worker);
      }
      console.log(this.responsibles);
    },
    removeResponsible: function removeResponsible(id) {
      var _this4 = this;
      sweetalert2__WEBPACK_IMPORTED_MODULE_0___default().fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, bórralo!'
      }).then(function (result) {
        if (result.isConfirmed) {
          _this4.responsibles = _this4.responsibles.filter(function (worker) {
            return worker.id !== id;
          });
          console.log(_this4.responsibles);
          sweetalert2__WEBPACK_IMPORTED_MODULE_0___default().fire('¡Eliminado!', 'El responsable ha sido eliminado.', 'success');
        }
      });
    },
    getWorkers: function getWorkers() {
      var _this5 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        var _yield$axios$get3, data, status;
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              _context3.prev = 0;
              _context3.next = 3;
              return axios.get('/lista-trabajadores');
            case 3:
              _yield$axios$get3 = _context3.sent;
              data = _yield$axios$get3.data;
              status = _yield$axios$get3.status;
              if (status === 200) {
                _this5.workers = data;
              }
              _context3.next = 12;
              break;
            case 9:
              _context3.prev = 9;
              _context3.t0 = _context3["catch"](0);
              console.log(_context3.t0);
            case 12:
            case "end":
              return _context3.stop();
          }
        }, _callee3, null, [[0, 9]]);
      }))();
    },
    getTipos: function getTipos() {
      var _this6 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        var _yield$axios$get4, data, status;
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              _context4.prev = 0;
              _context4.next = 3;
              return axios.get('/checklist/tipo');
            case 3:
              _yield$axios$get4 = _context4.sent;
              data = _yield$axios$get4.data;
              status = _yield$axios$get4.status;
              if (status === 200) {
                _this6.tipos = data;
              }
              _context4.next = 12;
              break;
            case 9:
              _context4.prev = 9;
              _context4.t0 = _context4["catch"](0);
              console.log(_context4.t0);
            case 12:
            case "end":
              return _context4.stop();
          }
        }, _callee4, null, [[0, 9]]);
      }))();
    },
    openModal: function openModal() {
      var _this7 = this;
      var idValue = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      this.id = idValue;
      if (idValue == 0) {
        this.name = '';
        this.description = '';
        this.type_id = '';
        this.responsibles = [];
      } else {
        var item = this.items.find(function (item) {
          return item.id === _this7.id;
        });
        console.log(item);
        this.name = item.name;
        this.description = item.description;
        this.type_id = item.type_id;
        this.is_observation = item.is_observations === 'si' ? true : false;
        this.is_attachement = item.is_attachement === 'si' ? true : false;
        this.is_seats = item.is_seats === 'si' ? true : false;
        this.is_tripulacion = item.is_tripulacion === 'si' ? true : false;
        this.is_conteo = item.is_conteo === 'si' ? true : false;
        this.respuestas = item.field.options;
        this.requerido = item.critical;
        this.prioridad = item.prioridad;
        this.area_id = item.area_id;
        this.field_id = item.field.id ? item.field.id : 0;
        this.responsibles = item.responsables.map(function (responsable) {
          return responsable.trabajador;
        });
      }
      $('#ItemModalAdd').modal('show');
    },
    guardarItem: function guardarItem() {
      var _this8 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee5() {
        var method, url, responsables;
        return _regeneratorRuntime().wrap(function _callee5$(_context5) {
          while (1) switch (_context5.prev = _context5.next) {
            case 0:
              method = axios.post;
              url = _this8.id == 0 ? '/checklist/item' : '/checklist/item/' + _this8.id; //JSON.stringify(this.responsibles)
              responsables = JSON.stringify(_this8.responsibles);
              _context5.next = 5;
              return method(url, {
                name: _this8.name,
                description: _this8.description,
                type_id: _this8.type_id,
                is_observations: _this8.is_observations ? 'si' : 'no',
                is_attachement: _this8.is_attachement ? 'si' : 'no',
                is_seats: _this8.is_seats ? 'si' : 'no',
                is_tripulacion: _this8.is_tripulacion ? 'si' : 'no',
                is_conteo: _this8.is_conteo ? 'si' : 'no',
                options: _this8.respuestas,
                critical: _this8.requerido,
                prioridad: _this8.prioridad,
                area_id: _this8.area_id,
                field_id: _this8.field_id,
                responsibles: responsables
              }).then(function (res) {
                sweetalert2__WEBPACK_IMPORTED_MODULE_0___default().fire({
                  icon: 'success',
                  title: '¡Éxito!',
                  text: _this8.id == 0 ? 'Item creado exitosamente' : 'Item editado exitosamente'
                });
                _this8.cargarItems();
                _this8.name = '';
                _this8.description = '';
                _this8.type_id = '';
                _this8.responsibles = [];
                _this8.prioridad = '';
                _this8.respuestas = '';
                _this8.requerido = '';
                _this8.area_id = 0;
                $('#ItemModalAdd').modal('hide');
              })["catch"](function (error) {
                sweetalert2__WEBPACK_IMPORTED_MODULE_0___default().fire({
                  icon: 'error',
                  title: '¡Error!',
                  text: 'Error al enviar el formulario'
                });
              });
            case 5:
            case "end":
              return _context5.stop();
          }
        }, _callee5);
      }))();
    },
    eliminarItem: function eliminarItem(id) {
      var _this9 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee6() {
        return _regeneratorRuntime().wrap(function _callee6$(_context6) {
          while (1) switch (_context6.prev = _context6.next) {
            case 0:
              sweetalert2__WEBPACK_IMPORTED_MODULE_0___default().fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, bórralo!'
              }).then(function (result) {
                if (result.isConfirmed) {
                  axios["delete"]('/checklist/item/' + id).then(function (res) {
                    sweetalert2__WEBPACK_IMPORTED_MODULE_0___default().fire({
                      icon: 'success',
                      title: '¡Éxito!',
                      text: 'Item eliminado exitosamente'
                    });
                    _this9.cargarItems();
                  })["catch"](function (error) {
                    sweetalert2__WEBPACK_IMPORTED_MODULE_0___default().fire({
                      icon: 'error',
                      title: '¡Error!',
                      text: 'Error al eliminar'
                    });
                  });
                }
              });
            case 1:
            case "end":
              return _context6.stop();
          }
        }, _callee6);
      }))();
    },
    closeModal: function closeModal() {
      this.id = 0;
      this.name = '';
      this.description = '';
      this.type_id = '';
      $('#ItemModalAdd').modal('hide');
    },
    abirImportModal: function abirImportModal() {
      $('#itemImport').modal('show');
    },
    closeImportModal: function closeImportModal() {
      this.file = '';
      $('#itemImport').modal('hide');
    },
    handleFileUpload: function handleFileUpload(event) {
      this.file = event.target.files[0];
    },
    importarItem: function importarItem() {
      var _this10 = this;
      var formData = new FormData();
      formData.append('file', this.file);
      axios.post('/checklist/import-items', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then(function (res) {
        sweetalert2__WEBPACK_IMPORTED_MODULE_0___default().fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Item importado exitosamente'
        });
        _this10.cargarItems();
        $('#itemImport').modal('hide');
      })["catch"](function (error) {
        sweetalert2__WEBPACK_IMPORTED_MODULE_0___default().fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al importar'
        });
      });
    }
  },
  mounted: function mounted() {
    this.cargarItems();
    this.getTipos();
    this.getWorkers();
    this.getAreas();
  }
});

/***/ }),

/***/ "./resources/js/app/checklist/Configuracion/tabs/Items.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/app/checklist/Configuracion/tabs/Items.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Items_vue_vue_type_template_id_b4b04b68_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Items.vue?vue&type=template&id=b4b04b68&scoped=true& */ "./resources/js/app/checklist/Configuracion/tabs/Items.vue?vue&type=template&id=b4b04b68&scoped=true&");
/* harmony import */ var _Items_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Items.vue?vue&type=script&lang=js& */ "./resources/js/app/checklist/Configuracion/tabs/Items.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Items_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Items_vue_vue_type_template_id_b4b04b68_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Items_vue_vue_type_template_id_b4b04b68_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "b4b04b68",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/app/checklist/Configuracion/tabs/Items.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/app/checklist/Configuracion/tabs/Items.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/app/checklist/Configuracion/tabs/Items.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Items_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Items.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/app/checklist/Configuracion/tabs/Items.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Items_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/app/checklist/Configuracion/tabs/Items.vue?vue&type=template&id=b4b04b68&scoped=true&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/app/checklist/Configuracion/tabs/Items.vue?vue&type=template&id=b4b04b68&scoped=true& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Items_vue_vue_type_template_id_b4b04b68_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Items_vue_vue_type_template_id_b4b04b68_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Items_vue_vue_type_template_id_b4b04b68_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Items.vue?vue&type=template&id=b4b04b68&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/app/checklist/Configuracion/tabs/Items.vue?vue&type=template&id=b4b04b68&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/app/checklist/Configuracion/tabs/Items.vue?vue&type=template&id=b4b04b68&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/app/checklist/Configuracion/tabs/Items.vue?vue&type=template&id=b4b04b68&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "col-lg-11 mx-auto" },
    [
      _c("div", { staticClass: "row mt-5" }, [
        _c("div", { staticClass: "col-md-6" }, [
          _c("div", { staticClass: "btn-group" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-success btn-sm",
                attrs: { type: "button" },
                on: {
                  click: function ($event) {
                    return _vm.openModal(0)
                  },
                },
              },
              [_c("i", { staticClass: "fa fa-plus" }), _vm._v(" Agregar ")]
            ),
          ]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-6" }, [
          _c(
            "div",
            {
              staticClass:
                "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
            },
            [
              _c(
                "select",
                {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.filtro_tipo_id,
                      expression: "filtro_tipo_id",
                    },
                  ],
                  staticClass: "form-select form-select-solid",
                  attrs: { id: "type_id" },
                  on: {
                    change: [
                      function ($event) {
                        var $$selectedVal = Array.prototype.filter
                          .call($event.target.options, function (o) {
                            return o.selected
                          })
                          .map(function (o) {
                            var val = "_value" in o ? o._value : o.value
                            return val
                          })
                        _vm.filtro_tipo_id = $event.target.multiple
                          ? $$selectedVal
                          : $$selectedVal[0]
                      },
                      function ($event) {
                        return _vm.cargarItems()
                      },
                    ],
                  },
                },
                [
                  _vm._v("\n                    >\n                        "),
                  _vm._l(_vm.tipos, function (tipo) {
                    return _c("option", { domProps: { value: tipo.id } }, [
                      _vm._v(_vm._s(tipo.name)),
                    ])
                  }),
                ],
                2
              ),
            ]
          ),
        ]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row mt-3" }, [
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c("simpleTable", {
              attrs: { data: _vm.items, columns: _vm.columns },
              on: { delete: _vm.eliminarItem, edit: _vm.openModal },
            }),
          ],
          1
        ),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-md-11" },
          [
            _c("paginate", {
              attrs: {
                pagination: _vm.itemsPaginate,
                onPageChange: _vm.cargarItems,
              },
            }),
          ],
          1
        ),
      ]),
      _vm._v(" "),
      _c("BootstrapModal", {
        attrs: {
          id: "ItemModalAdd",
          title: "Agregar Item",
          customClass: "modal-dialog-centered mw-650px",
          hideCloseButton: false,
          onCloseButton: _vm.closeModal,
        },
        scopedSlots: _vm._u([
          {
            key: "body",
            fn: function () {
              return [
                _c(
                  "div",
                  {
                    staticClass:
                      "form fv-plugins-bootstrap5 fv-plugins-framework",
                  },
                  [
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("Nombre Item")]
                        ),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.name,
                              expression: "name",
                            },
                          ],
                          staticClass: "form-control form-control-solid",
                          attrs: { type: "text", id: "name" },
                          domProps: { value: _vm.name },
                          on: {
                            input: function ($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.name = $event.target.value
                            },
                          },
                        }),
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("Descripción Item")]
                        ),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.description,
                              expression: "description",
                            },
                          ],
                          staticClass: "form-control form-control-solid",
                          attrs: { type: "text", id: "description" },
                          domProps: { value: _vm.description },
                          on: {
                            input: function ($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.description = $event.target.value
                            },
                          },
                        }),
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("Tipo")]
                        ),
                        _vm._v(" "),
                        _c(
                          "select",
                          {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.type_id,
                                expression: "type_id",
                              },
                            ],
                            staticClass: "form-select form-select-solid",
                            attrs: { id: "type_id" },
                            on: {
                              change: function ($event) {
                                var $$selectedVal = Array.prototype.filter
                                  .call($event.target.options, function (o) {
                                    return o.selected
                                  })
                                  .map(function (o) {
                                    var val = "_value" in o ? o._value : o.value
                                    return val
                                  })
                                _vm.type_id = $event.target.multiple
                                  ? $$selectedVal
                                  : $$selectedVal[0]
                              },
                            },
                          },
                          _vm._l(_vm.tipos, function (tipo) {
                            return _c(
                              "option",
                              { domProps: { value: tipo.id } },
                              [_vm._v(_vm._s(tipo.name))]
                            )
                          }),
                          0
                        ),
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("Área")]
                        ),
                        _vm._v(" "),
                        _c(
                          "select",
                          {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.area_id,
                                expression: "area_id",
                              },
                            ],
                            staticClass: "form-select form-select-solid",
                            attrs: { id: "area_id" },
                            on: {
                              change: function ($event) {
                                var $$selectedVal = Array.prototype.filter
                                  .call($event.target.options, function (o) {
                                    return o.selected
                                  })
                                  .map(function (o) {
                                    var val = "_value" in o ? o._value : o.value
                                    return val
                                  })
                                _vm.area_id = $event.target.multiple
                                  ? $$selectedVal
                                  : $$selectedVal[0]
                              },
                            },
                          },
                          _vm._l(_vm.areas, function (area) {
                            return _c(
                              "option",
                              { domProps: { value: area.id } },
                              [_vm._v(_vm._s(area.descripcion_area))]
                            )
                          }),
                          0
                        ),
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("Item con observaciones")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass:
                              "form-check form-switch form-check-custom form-check-solid",
                          },
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.is_observation,
                                  expression: "is_observation",
                                },
                              ],
                              staticClass: "form-check-input",
                              attrs: {
                                type: "checkbox",
                                id: "tiene_discapacidad",
                              },
                              domProps: {
                                checked: Array.isArray(_vm.is_observation)
                                  ? _vm._i(_vm.is_observation, null) > -1
                                  : _vm.is_observation,
                              },
                              on: {
                                change: function ($event) {
                                  var $$a = _vm.is_observation,
                                    $$el = $event.target,
                                    $$c = $$el.checked ? true : false
                                  if (Array.isArray($$a)) {
                                    var $$v = null,
                                      $$i = _vm._i($$a, $$v)
                                    if ($$el.checked) {
                                      $$i < 0 &&
                                        (_vm.is_observation = $$a.concat([$$v]))
                                    } else {
                                      $$i > -1 &&
                                        (_vm.is_observation = $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1)))
                                    }
                                  } else {
                                    _vm.is_observation = $$c
                                  }
                                },
                              },
                            }),
                            _vm._v(" "),
                            _c("label", {
                              staticClass:
                                "form-check-label fw-semibold text-gray-400 ms-3",
                              attrs: { for: "status" },
                            }),
                          ]
                        ),
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("¿Lleva adjuntos?")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass:
                              "form-check form-switch form-check-custom form-check-solid",
                          },
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.is_attachement,
                                  expression: "is_attachement",
                                },
                              ],
                              staticClass: "form-check-input",
                              attrs: {
                                type: "checkbox",
                                id: "tiene_discapacidad",
                              },
                              domProps: {
                                checked: Array.isArray(_vm.is_attachement)
                                  ? _vm._i(_vm.is_attachement, null) > -1
                                  : _vm.is_attachement,
                              },
                              on: {
                                change: function ($event) {
                                  var $$a = _vm.is_attachement,
                                    $$el = $event.target,
                                    $$c = $$el.checked ? true : false
                                  if (Array.isArray($$a)) {
                                    var $$v = null,
                                      $$i = _vm._i($$a, $$v)
                                    if ($$el.checked) {
                                      $$i < 0 &&
                                        (_vm.is_attachement = $$a.concat([$$v]))
                                    } else {
                                      $$i > -1 &&
                                        (_vm.is_attachement = $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1)))
                                    }
                                  } else {
                                    _vm.is_attachement = $$c
                                  }
                                },
                              },
                            }),
                            _vm._v(" "),
                            _c("label", {
                              staticClass:
                                "form-check-label fw-semibold text-gray-400 ms-3",
                              attrs: { for: "status" },
                            }),
                          ]
                        ),
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("¿Posee Conteo de asientos?")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass:
                              "form-check form-switch form-check-custom form-check-solid",
                          },
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.is_seats,
                                  expression: "is_seats",
                                },
                              ],
                              staticClass: "form-check-input",
                              attrs: {
                                type: "checkbox",
                                id: "tiene_discapacidad",
                              },
                              domProps: {
                                checked: Array.isArray(_vm.is_seats)
                                  ? _vm._i(_vm.is_seats, null) > -1
                                  : _vm.is_seats,
                              },
                              on: {
                                change: function ($event) {
                                  var $$a = _vm.is_seats,
                                    $$el = $event.target,
                                    $$c = $$el.checked ? true : false
                                  if (Array.isArray($$a)) {
                                    var $$v = null,
                                      $$i = _vm._i($$a, $$v)
                                    if ($$el.checked) {
                                      $$i < 0 &&
                                        (_vm.is_seats = $$a.concat([$$v]))
                                    } else {
                                      $$i > -1 &&
                                        (_vm.is_seats = $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1)))
                                    }
                                  } else {
                                    _vm.is_seats = $$c
                                  }
                                },
                              },
                            }),
                            _vm._v(" "),
                            _c("label", {
                              staticClass:
                                "form-check-label fw-semibold text-gray-400 ms-3",
                              attrs: { for: "status" },
                            }),
                          ]
                        ),
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("¿Chequeo de tripulacion?")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass:
                              "form-check form-switch form-check-custom form-check-solid",
                          },
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.is_tripulacion,
                                  expression: "is_tripulacion",
                                },
                              ],
                              staticClass: "form-check-input",
                              attrs: {
                                type: "checkbox",
                                id: "tiene_discapacidad",
                              },
                              domProps: {
                                checked: Array.isArray(_vm.is_tripulacion)
                                  ? _vm._i(_vm.is_tripulacion, null) > -1
                                  : _vm.is_tripulacion,
                              },
                              on: {
                                change: function ($event) {
                                  var $$a = _vm.is_tripulacion,
                                    $$el = $event.target,
                                    $$c = $$el.checked ? true : false
                                  if (Array.isArray($$a)) {
                                    var $$v = null,
                                      $$i = _vm._i($$a, $$v)
                                    if ($$el.checked) {
                                      $$i < 0 &&
                                        (_vm.is_tripulacion = $$a.concat([$$v]))
                                    } else {
                                      $$i > -1 &&
                                        (_vm.is_tripulacion = $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1)))
                                    }
                                  } else {
                                    _vm.is_tripulacion = $$c
                                  }
                                },
                              },
                            }),
                            _vm._v(" "),
                            _c("label", {
                              staticClass:
                                "form-check-label fw-semibold text-gray-400 ms-3",
                              attrs: { for: "status" },
                            }),
                          ]
                        ),
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("¿Conteo de objecto de bus?")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass:
                              "form-check form-switch form-check-custom form-check-solid",
                          },
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.is_conteo,
                                  expression: "is_conteo",
                                },
                              ],
                              staticClass: "form-check-input",
                              attrs: {
                                type: "checkbox",
                                id: "tiene_discapacidad",
                              },
                              domProps: {
                                checked: Array.isArray(_vm.is_conteo)
                                  ? _vm._i(_vm.is_conteo, null) > -1
                                  : _vm.is_conteo,
                              },
                              on: {
                                change: function ($event) {
                                  var $$a = _vm.is_conteo,
                                    $$el = $event.target,
                                    $$c = $$el.checked ? true : false
                                  if (Array.isArray($$a)) {
                                    var $$v = null,
                                      $$i = _vm._i($$a, $$v)
                                    if ($$el.checked) {
                                      $$i < 0 &&
                                        (_vm.is_conteo = $$a.concat([$$v]))
                                    } else {
                                      $$i > -1 &&
                                        (_vm.is_conteo = $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1)))
                                    }
                                  } else {
                                    _vm.is_conteo = $$c
                                  }
                                },
                              },
                            }),
                            _vm._v(" "),
                            _c("label", {
                              staticClass:
                                "form-check-label fw-semibold text-gray-400 ms-3",
                              attrs: { for: "status" },
                            }),
                          ]
                        ),
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("Respuestas")]
                        ),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.respuestas,
                              expression: "respuestas",
                            },
                          ],
                          staticClass: "form-control form-control-solid",
                          attrs: {
                            type: "text",
                            id: "respuestas",
                            placeholder: "SI,NO,NA",
                          },
                          domProps: { value: _vm.respuestas },
                          on: {
                            input: function ($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.respuestas = $event.target.value
                            },
                          },
                        }),
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("Requerido")]
                        ),
                        _vm._v(" "),
                        _c(
                          "select",
                          {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.requerido,
                                expression: "requerido",
                              },
                            ],
                            staticClass: "form-select form-select-solid",
                            attrs: { id: "requerido" },
                            on: {
                              change: function ($event) {
                                var $$selectedVal = Array.prototype.filter
                                  .call($event.target.options, function (o) {
                                    return o.selected
                                  })
                                  .map(function (o) {
                                    var val = "_value" in o ? o._value : o.value
                                    return val
                                  })
                                _vm.requerido = $event.target.multiple
                                  ? $$selectedVal
                                  : $$selectedVal[0]
                              },
                            },
                          },
                          _vm._l(_vm.criticalArea, function (critical) {
                            return _c(
                              "option",
                              { domProps: { value: critical.key } },
                              [_vm._v(_vm._s(critical.value))]
                            )
                          }),
                          0
                        ),
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("Prioridad")]
                        ),
                        _vm._v(" "),
                        _c(
                          "select",
                          {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.prioridad,
                                expression: "prioridad",
                              },
                            ],
                            staticClass: "form-select form-select-solid",
                            attrs: { id: "requerido" },
                            on: {
                              change: function ($event) {
                                var $$selectedVal = Array.prototype.filter
                                  .call($event.target.options, function (o) {
                                    return o.selected
                                  })
                                  .map(function (o) {
                                    var val = "_value" in o ? o._value : o.value
                                    return val
                                  })
                                _vm.prioridad = $event.target.multiple
                                  ? $$selectedVal
                                  : $$selectedVal[0]
                              },
                            },
                          },
                          _vm._l(_vm.prioridades, function (prioridad) {
                            return _c(
                              "option",
                              { domProps: { value: prioridad.key } },
                              [_vm._v(_vm._s(prioridad.value))]
                            )
                          }),
                          0
                        ),
                      ]
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "row mb-8" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-md-6 fv-row fv-plugins-icon-container",
                        },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "fs-6 fw-semibold mb-2",
                              attrs: { for: "" },
                            },
                            [_vm._v("Responsables")]
                          ),
                          _vm._v(" "),
                          _c(
                            "select-2",
                            {
                              attrs: {
                                dataType: "number",
                                modalId: "ItemModalAdd",
                              },
                              model: {
                                value: _vm.responsibles_id,
                                callback: function ($$v) {
                                  _vm.responsibles_id = $$v
                                },
                                expression: "responsibles_id",
                              },
                            },
                            _vm._l(_vm.workers, function (ref, index) {
                              var id = ref.id
                              var rut = ref.rut
                              var primer_nombre = ref.primer_nombre
                              var segundo_nombre = ref.segundo_nombre
                              var primer_apellido = ref.primer_apellido
                              var segundo_apellido = ref.segundo_apellido
                              return _c("option", { domProps: { value: id } }, [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(
                                      rut +
                                        " " +
                                        primer_nombre +
                                        " " +
                                        segundo_nombre +
                                        " " +
                                        primer_apellido +
                                        " " +
                                        segundo_apellido
                                    ) +
                                    "\n                                "
                                ),
                              ])
                            }),
                            0
                          ),
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-md-6 fv-row fv-plugins-icon-container mt-7",
                        },
                        [
                          _c(
                            "button",
                            {
                              staticClass: "btn btn-sm btn-primary",
                              on: { click: _vm.addResponsibles },
                            },
                            [
                              _c("i", { staticClass: "fa fa-plus" }),
                              _vm._v(
                                "\n                                Agregar\n                            "
                              ),
                            ]
                          ),
                        ]
                      ),
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-md-12" }, [
                      _c(
                        "table",
                        {
                          staticClass:
                            "table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9",
                        },
                        [
                          _c("thead", [
                            _c(
                              "tr",
                              {
                                staticClass:
                                  "text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0",
                              },
                              [
                                _c("th", [_vm._v("RUT")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Nombre")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Acciones")]),
                              ]
                            ),
                          ]),
                          _vm._v(" "),
                          _c(
                            "tbody",
                            { ref: "sortable" },
                            _vm._l(_vm.responsibles, function (ref, index) {
                              var id = ref.id
                              var rut = ref.rut
                              var primer_nombre = ref.primer_nombre
                              var segundo_nombre = ref.segundo_nombre
                              var primer_apellido = ref.primer_apellido
                              var segundo_apellido = ref.segundo_apellido
                              return _c("tr", [
                                _c("td", [_vm._v(_vm._s(rut))]),
                                _vm._v(" "),
                                _c("td", [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(
                                        primer_nombre +
                                          " " +
                                          segundo_nombre +
                                          " " +
                                          primer_apellido +
                                          " " +
                                          segundo_apellido
                                      ) +
                                      "\n                                "
                                  ),
                                ]),
                                _vm._v(" "),
                                _c("td", [
                                  _c("div", { staticClass: "btn-group" }, [
                                    _c(
                                      "button",
                                      {
                                        staticClass: "btn btn-danger btn-sm",
                                        on: {
                                          click: function ($event) {
                                            $event.preventDefault()
                                            return _vm.removeResponsible(id)
                                          },
                                        },
                                      },
                                      [_c("i", { staticClass: "fa fa-trash" })]
                                    ),
                                  ]),
                                ]),
                              ])
                            }),
                            0
                          ),
                        ]
                      ),
                    ]),
                  ]
                ),
              ]
            },
            proxy: true,
          },
          {
            key: "footer",
            fn: function () {
              return [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-primary btn-sm",
                    attrs: { type: "button" },
                    on: {
                      click: function ($event) {
                        $event.preventDefault()
                        return _vm.guardarItem()
                      },
                    },
                  },
                  [_vm._v("\n                    Guardar\n                ")]
                ),
              ]
            },
            proxy: true,
          },
        ]),
      }),
      _vm._v(" "),
      _c("BootstrapModal", {
        attrs: {
          id: "itemImport",
          title: "Importar Item",
          customClass: "modal-dialog-centered mw-650px",
          hideCloseButton: false,
          onCloseButton: _vm.closeImportModal,
        },
        scopedSlots: _vm._u([
          {
            key: "body",
            fn: function () {
              return [
                _c(
                  "div",
                  {
                    staticClass:
                      "form fv-plugins-bootstrap5 fv-plugins-framework",
                  },
                  [
                    _c(
                      "div",
                      {
                        staticClass:
                          "d-flex flex-column mb-8 fv-row fv-plugins-icon-container",
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "fs-6 fw-semibold mb-2",
                            attrs: { for: "" },
                          },
                          [_vm._v("Archivo")]
                        ),
                        _vm._v(" "),
                        _c("input", {
                          staticClass: "form-control form-control-solid",
                          attrs: { type: "file", id: "file" },
                          on: { change: _vm.handleFileUpload },
                        }),
                      ]
                    ),
                  ]
                ),
              ]
            },
            proxy: true,
          },
          {
            key: "footer",
            fn: function () {
              return [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-primary btn-sm",
                    attrs: { type: "button" },
                    on: {
                      click: function ($event) {
                        $event.preventDefault()
                        return _vm.importarItem()
                      },
                    },
                  },
                  [_vm._v("\n                    Importar\n                ")]
                ),
              ]
            },
            proxy: true,
          },
        ]),
      }),
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);