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
  var doLogin = () => {
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
            var data = result.data;
//成功响应了会话
            if (data && data.code === 0 && data.data.skey) {
              var res=data.data
              Session.set(res);
              options.success()
              console.log('login检测session失败，wx.login后重新获取的session')
              console.log(res)
            }else{
              console.log('响应成功但是没数据')
              res='未知错误'
              options.fail(res)
            }
           
          },
          fail: function (res) {
            console.log('wx.request失败！');
            options.fail(res);
          }
        })
      },
      fail: function (res) {
        console.log('wx.login失败！');
        options.fail(res);
      }
    })
  }
  var session = Session.get();

  if (session) {
    wx.checkSession({
      success: function () {
        options.success(session.openid);
        console.log('login检测session成功的session输出')
        console.log(session)
      },

      fail: function () {
        Session.clear();
        doLogin();
      },
    });
  } else {
    doLogin();
  }

};
var setLoginUrl = function (loginUrl) {
  defaultOptions.loginUrl = loginUrl;
};
module.exports = {
  myLogin: myLogin,
  setLoginUrl: setLoginUrl,
};