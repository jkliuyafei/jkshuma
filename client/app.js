//app.js
var qcloud = require('./vendor/wafer2-client-sdk/index')
var config = require('./config')
var util = require('./utils/util.js')
App({
  onLaunch: function () {
    var that=this;
    qcloud.setLoginUrl(config.service.loginUrl);
   
  },
  //登录成功后获取用户权限表
  getAuthTab: function () {
    var that = this
    console.log('获取权限表')
    var options = {
      url: config.service.getAuthTab,
      login: true,
      success(res) {
        var userAuthTable = res.data.data
        console.log(userAuthTable)
        wx.setStorageSync('userAuthTab', userAuthTable)
      }
    }
    qcloud.request(options)
  },
})