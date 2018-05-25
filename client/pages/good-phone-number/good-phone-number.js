// pages/good-phone-number/good-phone-number.js
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
    operators: [
      { id: 'chinaMobile', name: '中国移动' },
      { id: 'chinaUnicom', name: '中国联通' },
      { id: 'chinaTelecom', name: '中国电信' }],
    curIndex: 0,
    toView: 'chinaMobile',
    tableHead: {
      numberIndex: '序号',
      phoneNumber: '靓号',
      qCellCore: '归属地',
      price: '价格',
      expensesDetail: '套餐内容'
    },
    shareMessage: '',
    chinaMobileNumber: [],
    chinaUnicomNumber: [],
    chinaTelecom: []
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
    var isShare = options.isShare
    if (isShare == 1) {
      that.setData({
        goHomeShow: false,
        serviceShow: true
      })
    }
    that.getGoodNumber()
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
    var shareMessageTitle = that.data.shareMessage
    return {
      title: shareMessageTitle,
      path: '/pages/good-phone-number/good-phone-number?isShare=1',
      imageUrl:'../../image/goodNum.png'
    }
  },
  switchOperators: function (e) {
    var that = this
    that.setData({
      curIndex: e.target.dataset.tableIndex,
      toView: e.target.dataset.id,
    })

  },
  getGoodNumber: function () {
    wx.showLoading({
      title: '号码更新中',
      mask: 'true',
    })
    var that = this
    qcloud.myRequest({
      url: config.service.goodNumberUrl,
      login: true,
      success: function (res) {
        that.setData({
          chinaMobileNumber: res.data.data.goodNumber[0].chinaMobileNumber,
          chinaUnicomNumber: res.data.data.goodNumber[1].chinaUnicomNumber,
          chinaTelecomNumber: res.data.data.goodNumber[2].chinaTelecomNumber,
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
  },

})