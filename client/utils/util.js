var qcloud = require('../vendor/wafer2-client-sdk/index')
var config = require('../config.js')
const formatTime = date => {
  const year = date.getFullYear()
  const month = date.getMonth() + 1
  const day = date.getDate()
  const hour = date.getHours()
  const minute = date.getMinutes()
  const second = date.getSeconds()

  return [year, month, day].map(formatNumber).join('/') + ' ' + [hour, minute, second].map(formatNumber).join(':')
}

const formatNumber = n => {
  n = n.toString()
  return n[1] ? n : '0' + n
}


// 显示繁忙提示
var showBusy = text => wx.showToast({
  title: text,
  icon: 'loading',
  duration: 10000
})

// 显示成功提示
var showSuccess = text => wx.showToast({
  title: text,
  icon: 'success'
})

// 显示失败提示
var showModel = (title, content) => {
  wx.hideToast();

  wx.showModal({
    title,
    content: JSON.stringify(content),
    showCancel: false
  })
}

//判断是否授权使用个人信息
var noop = function noop() { };
var options = {
  success: noop,
  fail: noop,
}
var checkAuth = (options) => {
  wx.getSetting({
    success(res) {
      if (!res.authSetting['scope.userInfo']) {
        options.fail();
      } else {
        options.success();
      }
    }
  })
}
//授权按钮判断是否授权使用公开信息了
var option = {
  userInfo: null,
  success: noop,
  fail: noop,
}
var myGetUserInfo = (option) => {
  if (option.userInfo.detail.detail.userInfo) {
    option.success();
  } else {
    option.fail();
  }
}
//获取userInfo得到openid和role，先判定本地有没有权缓存，有的话直接返回，没有的话网络请求,refresh参数决定是否刷新userInfo缓存,1代表刷新

var getUserInfo = (refresh, callback) => {
  if (refresh == 1) {
    qcloud.myRequest({
      url: config.service.getUserInfoUrl,
      login: true,
      success: function (res) {
        var userInfo = res.data.data;
        userInfo.userAuthObj = config.authTable[userInfo.role];
        wx.setStorageSync('userInfo', userInfo)
        callback(userInfo);
      }
    })
  } else {
    var userInfo = wx.getStorageSync('userInfo');
    if (userInfo.length == 0) {
      qcloud.myRequest({
        url: config.service.getUserInfoUrl,
        login: true,
        success: function (res) {
          var userInfo = res.data.data;
          userInfo.userAuthObj = config.authTable[userInfo.role];
          wx.setStorageSync('userInfo', userInfo)
          callback(userInfo);
        }
      })
    } else {
      callback(userInfo);
    }
  }
}

var extend = function extend(target) {
  var sources = Array.prototype.slice.call(arguments, 1);

  for (var i = 0; i < sources.length; i += 1) {
    var source = sources[i];
    for (var key in source) {
      if (source.hasOwnProperty(key)) {
        target[key] = source[key];
      }
    }
  }
  return target;
};

module.exports = { formatTime, showBusy, showSuccess, showModel, checkAuth, myGetUserInfo, getUserInfo, extend }
