// pages/new-phone/new-phone.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')

Page({
  data: {
    newPhoneQuotation: [],
    curIndex: 0,
    toView: 'iphone',
    shareMessage: '',
    updateTime:''
  },
  onLoad: function (options) {
    var that=this;
    // 页面初始化 options为页面跳转所带来的参数 
    that.showTime()
  },
  onReady: function () {
    // 页面渲染完成
    this.dialog = this.selectComponent("#dialog");
  },
  onShow: function () {
    // 页面显示
    var that = this
    util.checkAuth({
      success: function () {
        //执行api逻辑
       
        util.checkAuthTab(config.service.getAuthTab, function (res) {
          that.getNewPhoneQuotation()
        })
        
      },
      fail: function () {
        that.dialog.showDialog();
      }
    })

  },
  onHide: function () {
    // 页面隐藏
    this.dialog.hideDialog();
  },
  onUnload: function () {
    // 页面关闭
  },
  //用户分享
  onShareAppMessage: function () {
    var that = this
    var shareMessageTitle = that.data.shareMessage
    return {
      title: shareMessageTitle,
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
    qcloud.request({
      url: config.service.phoneQuotation,
      login:true,
      success: function (res) {
        that.setData({
          newPhoneQuotation: res.data.newPhoneQuotation,
          shareMessage: res.data.shareMessage
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
myGetUserInfo: function (e) {
  var that = this;
  util.myGetUserInfo({
    userInfo: e,
    success: function () {
      //执行api逻辑
      that.dialog.hideDialog();
      util.checkAuthTab(config.service.getAuthTab, function (res) {
        that.getNewPhoneQuotation()
      })
    },
    fail: function () {
      console.log('未授权')
    }
  })
}

})