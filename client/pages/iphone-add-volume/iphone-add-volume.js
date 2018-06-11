// pages/iphone-add-volume/iphone-add-volume.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
Page({

  /**
   * 页面的初始数据
   */
  data: {
    goHomeShow: true,
    serviceShow: false,
    iphoneAddVolume: [],
    shareMessage: [],
    tableHead: { model: '型号', volume32: '32G', volume64: '64G', volume128: '128G', volume256: '256G' }
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
    var isShare = options.isShare
    var qcId = options.qcId
    if (isShare == 1 || typeof (qcId) != 'undefined') {
      that.setData({
        goHomeShow: false,
        serviceShow: true
      })
    }
    util.getUserInfo(0, function (res) {
      that.getAddTable()
    })
    
   
  },
  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
    var that=this
   return{
     title:that.data.shareMessage.message,
     path: '/pages/iphone-add-volume/iphone-add-volume?isShare=1',
     imageUrl:that.data.shareMessage.imageUrl
   }
  },
  getAddTable: function () {
    var that = this
    wx.showLoading({
      title: '数据更新中',
      mask: 'true',
    })
    qcloud.myRequest({
      url: config.service.addVolumeUrl,
      login: true,
      success: function (res) {
        that.setData({
          iphoneAddVolume: res.data.data.iphoneAddVolume,
          shareMessage: res.data.data.shareMessage
        })
        wx.hideLoading()
      }
    })
  },
  goHome: function () {
    wx.switchTab({
      url: '/pages/second-hand/second-hand',
    })
  }

})