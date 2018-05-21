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
              options.success(res.openid)
              console.log(res.openid)
              console.log('登陆过程，这是访问服务器的输出')
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
        console.log('这是登陆过程检测session是否过期后，session的输出')
        console.log(session.openid)
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