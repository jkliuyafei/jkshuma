// pages/second-hand/second-hand.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
Page({
  data: {
    secondGoods: [],
    shareMessage: null,
    curIndex: 0,
    btnShowOrNot: true
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    var that = this
    util.checkAuthTab(config.service.getAuthTab, function (res) {
      if (res.uploadAuth == 1) {
        that.setData({
          btnShowOrNot: false
        })
      }
      that.getSecondGoods(); 
    })
  },
  onShow: function () {
    // 页面显示,根据缓存判断是不是从发布页面过来的，是的话就刷新页面
    var that = this
    var referOrNot = wx.getStorageSync('up_refer')
    if (referOrNot == 1) {
      that.getSecondGoods();
      wx.setStorageSync('up_refer', 0);
    }
  },
  /**
 * 用户点击右上角分享
 */
  onShareAppMessage: function () {
    var that = this
    var shareMessageTitle = that.data.shareMessage
    return {
      title: shareMessageTitle,
    }
  },
  //发布按钮，点击进入发布界面
  uploadGoods: function () {
    wx.navigateTo({
      url: '../second-upload-goods/second-upload-goods',
    })
  },
  //点击进入报价表
  goodsInventoryTable: function () {
    wx.navigateTo({
      url: '../second-inventory-table/second-inventory-table',
    })
  },
  //查看大图
  seeBigImage(e) {
    var curImage = e.currentTarget.dataset.image
    var curIndex = e.currentTarget.dataset.imageIndex
    wx.previewImage({
      current: curImage[curIndex],
      urls: curImage,
    })
  },
  //查看商品详情
  seeGoodsDetail(e) {
    var curIndex = e.currentTarget.dataset.index
    wx.navigateTo({
      url: '../second-goods-detail/second-goods-detail?curIndex=' + curIndex,
    })
  },
  //获取二手商品列表
  getSecondGoods: function () {
    var that = this
    wx.showLoading({
      title: '数据加载中，请稍后...',
      mask: 'true',
    })
    wx.removeStorageSync('secondGoods')
    wx.removeStorageSync('shareMessage')
    qcloud.myRequest({
      url: config.service.secGoodsUrl,
      login: true,
      success: function (res) {
        that.setData({
          secondGoods: res.data.data.secondGoods,
          shareMessage: res.data.data.shareMessage
        })
        wx.setStorage({
          key: 'secondGoods',
          data: res.data.data.secondGoods,
        })
        wx.setStorage({
          key: 'shareMessage',
          data: res.data.data.shareMessage,
        })
        wx.hideLoading()
      }
    })
  }
})