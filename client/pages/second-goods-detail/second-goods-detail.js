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
    if (typeof (shareGoodsId) == 'undefined') {
      var secondGoods = wx.getStorageSync('secondGoods')
      if (secondGoods.length !== 0) {
        var curSecondGoods = secondGoods[curIndex]
        
        that.setData({
          curSecondGoods: curSecondGoods
        })
      }
    } else {
      that.getGoodsDetail(shareGoodsId,function(res){
        that.setData({
          curSecondGoods: res
        })
      })
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
    var shareGoodsId = curSecondGoods['id']
    var shareMessage = curSecondGoods.goodsTitle + '只要' + curSecondGoods.goodsPrice + '元!'
    return {
      title: shareMessage,
      path: '/pages/second-goods-detail/second-goods-detail?shareGoodsId='+shareGoodsId
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

  //根据goodsId获取当前分享过来商品的详细信息
  getGoodsDetail: function (goodsId,callback) {
    wx.showLoading({
      title: '数据加载中...',
      mask: 'true',
    })
    
    qcloud.myRequest({
      url: config.service.secGoodsDetailUrl,
      login: true,
      data: { goodsId: goodsId },
      method: 'POST',
      success: function (res) {
        wx.hideLoading()
        
        callback(res.data.data)
      },
      fail: function (e) {
        console.log(e)
      }
    })

  }
})