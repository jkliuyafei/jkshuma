var utils = require('./utils');
var constants = require('./constants');
var Session = require('./session');
var noop = function noop() { };
var defaultOptions = {
  method: 'GET',
  success: noop,
  fail: noop,
  loginUrl: null,
};
var myLogin = function myLogin(options) {
  options = utils.extend({}, defaultOptions, options);
  wx.login({
    success: function (res) {
      var code = res.code;

      var header = {};
      header[constants.WX_HEADER_CODE] = code;

      wx.request({
        url: options.loginUrl,
        header: header,
        method: options.method,
        data: options.data,
        success: function (result) {
          options.success(result)
        }
      })
    }
  })
};
module.exports = {
  myLogin: myLogin,
};