// pages/second-choose-parameter/second-choose-parameter.js
var config = require('../../config.js');
var qcloud = require('../../vendor/wafer2-client-sdk/index')
Page({

  /**
   * 页面的初始数据
   */
  data: {
    goodsVolume: '',
    goodsColor: '',
    colorGroup: [],
    volumeGroup: [],
    curColorIndex: null,
    curVolumeIndex: null,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    var goodsModel = options.goodsModel
    qcloud.request({
      login: true,
      url: config.service.chooseParameterUrl + '?phoneModel=' + goodsModel,
      header: {
        'Content-Type': 'application/json'
      },
      success: function (res) {
        that.setData({
          colorGroup: res.data.colorGroup,
          volumeGroup: res.data.volumeGroup
        })

      }
    });

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

  chooseColor: function (e) {
    var that = this
    that.setData({
      curColorIndex: e.target.dataset.colorIndex,
      goodsColor: e.target.dataset.color,
    })
    if (that.data.goodsVolume.length !== 0) {
      that.chooseDone()
    }
  },
  chooseVolume: function (e) {
    var that = this
    that.setData({
      curVolumeIndex: e.target.dataset.volumeIndex,
      goodsVolume: e.target.dataset.volume,
    })
    if (that.data.goodsColor.length != 0) {
      that.chooseDone()
    }
  },
  chooseDone: function () {
    var that = this
    var upGoodsInfo=wx.getStorageSync('upGoodsInfo')
    var statusHint=wx.getStorageSync('statusHint')
    upGoodsInfo.goodsColor=that.data.goodsColor
    upGoodsInfo.goodsVolume=that.data.goodsVolume
    statusHint.parameterHint=true
    wx.setStorageSync('upGoodsInfo', upGoodsInfo)
    wx.setStorageSync('statusHint',statusHint)
    wx.navigateBack({
    })
  }
})