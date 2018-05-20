// pages/second-goods-detail/second-goods-detail.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
Page({

  /**
   * 页面的初始数据
   */
  data: {
    curIndex: null,
    curSecondGoods: null,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
    var shareGoodsId = options.shareGoodsId
    var curIndex = options.curIndex
    if(typeof(shareGoodsId)=='undefined'){
      var secondGoods = wx.getStorageSync('secondGoods')
      if (secondGoods.length !== 0) {
        var curSecondGoods = secondGoods[curIndex]
        console.log(curSecondGoods)
        that.setData({
          curSecondGoods: curSecondGoods
        })
      }
    }
    


    

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },


  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
    var that = this
    var curSecondGoods = that.data.curSecondGoods
    var shareGoodsId=curSecondGoods['goodsId']
    var shareMessage = curSecondGoods.goodsTitle + '只要' + curSecondGoods.goodsPrice + '元!'
    return {
      title: shareMessage,
      path: '/pages/second-goods-detail/second-goods-detail?shareGoodsIndex=' + shareGoodsIndex
    }
  },
  seeBigImage: function (e) {
    var that = this
    var imageUrl = Array()
    var curIndex = e.currentTarget.dataset.index
    var curSecondGoods = that.data.curSecondGoods
    var imageUrl = curSecondGoods.goodsImage
    wx.previewImage({
      urls: imageUrl,
      current: imageUrl[curIndex],
    })
  },

  //获取二手商品列表
  getSecondGoods: function (callback) {
    var that = this
    wx.showLoading({
      title: '数据加载中，请稍后...',
      mask: 'true',
    })
    wx.removeStorageSync('secondGoods')
    wx.removeStorageSync('shareMessage')
    qcloud.request({
      url: config.service.secGoodsUrl,
      login: true,
      success: function (res) {
        wx.setStorage({
          key: 'secondGoods',
          data: res.data.secondGoods,
        })
        wx.setStorage({
          key: 'shareMessage',
          data: res.data.shareMessage,
        })
        callback(res.data.secondGoods)
        wx.hideLoading()
      }
    })
  },
})