
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
    qcloud.myRequest({
      login:true,
      url: config.service.chooseBrandUrl,
      header: {
        'Content-Type': 'application/json'
      },
      success: function (res) {
       var res=res.data
        wx.hideLoading()
        that.setData({
          phoneModel: res.data,
        })

      }
    })
  },
 
  switchTab: function (e) {
    var that = this
    that.setData({
      curIndex: e.target.dataset.index,
      curBrandId: e.target.dataset.brandId,
      goodsBrand: e.target.dataset.brand,
    })
  },
  chooseModel: function (e) {
    var goodsBrand = this.data.goodsBrand
    var goodsModel = e.target.dataset.model
    var goodsParameter=new Object()
    var statusHint=new Object()
    goodsParameter.goodsBrand=goodsBrand
    goodsParameter.goodsModel=goodsModel
    goodsParameter.goodsColor=null
    goodsParameter.goodsColor=null
    statusHint.brandHint=true
    statusHint.parameterHint=false
    wx.setStorageSync('statusHint', statusHint)
    wx.setStorageSync('goodsParameter', goodsParameter)
    wx.navigateBack({

    })
  },

})