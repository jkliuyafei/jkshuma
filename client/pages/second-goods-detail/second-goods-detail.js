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
    shareGoodsIndex: null
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
    var curIndex = options.curIndex
    var shareGoodsIndex = options.shareGoodsIndex
    if (typeof(shareGoodsIndex)!='undefined') {
      that.setData({
        shareGoodsIndex: shareGoodsIndex
      })
    }
    var secondGoods = wx.getStorageSync('secondGoods')
    if (secondGoods.length !== 0) {
      var curSecondGoods = secondGoods[curIndex]
      that.setData({
        curSecondGoods: curSecondGoods
      })
    }

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    this.dialog = this.selectComponent("#dialog");
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    var that = this;
    util.checkAuth({
      success: function () {
        //执行api逻辑
        util.checkAuthTab(config.service.getAuthTab, function (res) {
          var secondGoods = wx.getStorageSync('secondGoods');
          if (secondGoods.length == 0) {
            that.getSecondGoods(function (res) {
              var shareGoodsIndex=that.data.shareGoodsIndex;
              cnsole.log(shareGoodsIndex)
              console.log(res)
              that.setData({
                curSecondGoods:res[shareGoodsIndex]
              })
            })
          }
        })
      },
      fail: function () {
        that.dialog.showDialog();
      }
    })
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
    this.dialog.hideDialog();
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
    var that = this
    var shareGoodsIndex = that.data.curIndex
    var curSecondGoods = that.data.curSecondGoods
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
  myGetUserInfo: function (e) {
    var that = this;
    util.myGetUserInfo({
      userInfo: e,
      success: function () {
        //执行api逻辑
        that.dialog.hideDialog();
        util.checkAuthTab(config.service.getAuthTab, function (res) {
          var secondGoods = wx.getStorageSync('secondGoods');
          if (secondGoods.length == 0) {
            that.getSecondGoods(function (res) {
              var shareGoodsIndex = that.data.shareGoodsIndex;
              console.log(res)
              that.setData({
                curSecondGoods: res[shareGoodsIndex]
              })
            })
          }
        })
      },
      fail: function () {
        console.log('未授权')
      }
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