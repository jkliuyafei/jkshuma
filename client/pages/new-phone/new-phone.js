// pages/new-phone/new-phone.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')

Page({
  data: {
    newPhoneQuotation: [],
    curIndex: 0,
    toView: 'iphone',
    shareMessage: [],
    updateTime:''
  },
  onLoad: function (options) {
    var that=this;
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this
    util.checkAuthTab(config.service.getAuthTab, function (res) {
      that.getNewPhoneQuotation();
    })
    that.showTime()
  },

  //用户分享
  onShareAppMessage: function () {
    var that = this
    return {
      title: that.data.shareMessage.message,
      imageUrl: that.data.shareMessage.imageUrl
    }
  },
  switchTab(e) {
    this.setData({
      toView: e.target.dataset.id,
      curIndex: e.target.dataset.index
    })
  },
  getNewPhoneQuotation:function(){
    var that = this
    wx.showLoading({
      title: '报价更新中',
      mask: 'true',
    })
    qcloud.myRequest({
      url: config.service.phoneQuotation,
      login:true,
      success: function (res) {
        that.setData({
          newPhoneQuotation: res.data.data.newPhoneQuotation,
          shareMessage: res.data.data.shareMessage
        })
        wx.hideLoading()
      },
    })
  },
refreshQuotation:function(){
  var that = this
  that.getNewPhoneQuotation()
  that.showTime()
},
showTime:function(){
  var that = this
  var curDate=new Date()
  var month=curDate.getMonth()+1
  var date=curDate.getDate()
  var hours=curDate.getHours()
  var minutes=curDate.getMinutes()
  var curTime=month+'月'+date+'日'+hours+'点'+minutes+'分'
  that.setData({
    updateTime:curTime
  })
},


})