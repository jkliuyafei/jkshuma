//app.js
var qcloud = require('./vendor/wafer2-client-sdk/index')
var config = require('./config')
var util = require('./utils/util.js')
App({
  onLaunch: function (options) {
    qcloud.setLoginUrl(config.service.myLoginUrl);
    this.sceneData=options.scene
  },
  onShow:function(options){
    this.sceneData = options.scene
  },
  sceneData: ''
})