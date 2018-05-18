// pages/second-choose-brand/second-choose-brand.js
var config = require('../../config.js');
var qcloud = require('../../vendor/wafer2-client-sdk/index')
Page({

  /**
   * 页面的初始数据
   */
  data: {
    phoneModel: [],
    curIndex: 0,
    curBrandId: 'iphone',
    goodsBrand: '苹果',
    goodsModel: '',
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
    wx.showLoading({
      title: '加载中...',
    })
    qcloud.request({
      login:true,
      url: config.service.chooseBrandUrl,
      header: {
        'Content-Type': 'application/json'
      },
      success: function (res) {
        wx.hideLoading()
        that.setData({
          phoneModel: res.data,
        })

      }
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

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
 
  switchTab: function (e) {
    var that = this
    that.setData({
      curIndex: e.target.dataset.index,
      curBrandId: e.target.dataset.brandId,
      goodsBrand: e.target.dataset.brand,
    })
  },
  chooseModel: function (e) {
    // var that = this
    this.setData({
      goodsModel: e.target.dataset.model,
    })
    var goodsBrand = this.data.goodsBrand
    var goodsModel = this.data.goodsModel
    var upGoodsInfo= wx.getStorageSync('upGoodsInfo')
    var statusHint=wx.getStorageSync('statusHint')
    upGoodsInfo.goodsBrand=goodsBrand
    upGoodsInfo.goodsModel=goodsModel
    upGoodsInfo.goodsColor=null
    upGoodsInfo.goodsVolume=null
    statusHint.brandHint=true
    statusHint.parameterHint=false
    wx.setStorageSync('statusHint', statusHint)
    wx.setStorageSync('upGoodsInfo', upGoodsInfo)
    wx.navigateBack({

    })
  },

})