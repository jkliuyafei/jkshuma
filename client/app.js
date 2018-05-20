//app.js
var qcloud = require('./vendor/wafer2-client-sdk/index')
var config = require('./config')
var util = require('./utils/util.js')
App({
  onLaunch: function () {
    var that=this;
    qcloud.setLoginUrl(config.service.myLoginUrl);
  }
})