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
    qcloud.myRequest({
      login: true,
      url: config.service.chooseParameterUrl + '?phoneModel=' + goodsModel,
      header: {
        'Content-Type': 'application/json'
      },
      success: function (res) {
        var res=res.data
        that.setData({
          colorGroup: res.data.colorGroup,
          volumeGroup: res.data.volumeGroup
        })

      }
    });

  },


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
    var goodsParameter=wx.getStorageSync('goodsParameter')
    var statusHint=wx.getStorageSync('statusHint')
    goodsParameter.goodsColor=that.data.goodsColor
    goodsParameter.goodsVolume=that.data.goodsVolume
    statusHint.parameterHint=true
    wx.setStorageSync('goodsParameter', goodsParameter)
    wx.setStorageSync('statusHint',statusHint)
    wx.navigateBack({
    })
  }
})