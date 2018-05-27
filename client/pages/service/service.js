// pages/service/service.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
Page({
  data:{
    showOrNot:true,
  },
  onLoad:function(options){
    // 页面初始化 options为页面跳转所带来的参数
    var that = this
    util.checkAuthTab(config.service.getAuthTab, function (res) {
      if (res.shopManagerAuth == 1) {
        that.setData({
          showOrNot: false
        })
      }
    })
  },
  phoneRepair:function(){
    wx.navigateTo({
      url: '../phone-repair/phone-repair',

    })
  },
  phoneNumber:function(){
    wx.navigateTo({
      url: '../good-phone-number/good-phone-number',
    })
  },
  iphoneAddVolume:function(){
    wx.navigateTo({
      url: '../iphone-add-volume/iphone-add-volume',
    })
  },
  shopManage:function(){
    wx.navigateTo({
      url: '../shop-manage/shop-manage',
    })

  },
})