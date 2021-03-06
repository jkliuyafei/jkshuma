var constants = require('./lib/constants');
var login = require('./lib/login');
var myLogin=require('./lib/myLogin');
var myRequest=require('./lib/myRequest');
var Session = require('./lib/session');
var request = require('./lib/request');
var Tunnel = require('./lib/tunnel');

var authHeader = function() {
  return request.buildAuthHeader(Session.get());
}

var exports = module.exports = {
    login: login.login,
    setLoginUrl: myLogin.setLoginUrl,
    LoginError: login.LoginError,
    myLogin:myLogin.myLogin,
    myRequest:myRequest.request,
    clearSession: Session.clear,
    request: request.request,
    RequestError: request.RequestError,
    authHeader: authHeader,
    Tunnel: Tunnel,
};

// 导出错误类型码
Object.keys(constants).forEach(function (key) {
    if (key.indexOf('ERR_') === 0) {
        exports[key] = constants[key];
    }
});