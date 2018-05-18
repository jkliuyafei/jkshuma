// pages/good-phone-number/good-phone-number.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
Page({

  /**
   * 页面的初始数据
   */
  data: {
    operators: [
      { id: 'chinaMobile', name: '中国移动' },
      { id: 'chinaUnicom', name: '中国联通' },
      { id: 'chinaTelecom', name: '中国电信' }],
    curIndex: 0,
    toView: 'chinaMobile',
    tableHead: {
      numberIndex: '序号',
      phoneNumber: '靓号',
      qCellCore:'归属地',
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
    var that = this
    util.checkAuth({
      success: function () {
        //执行api逻辑

        util.checkAuthTab(config.service.getAuthTab, function (res) {
          that.getGoodNumber()
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
this.dialog.hideDialog()
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
    var shareMessageTitle = that.data.shareMessage
    return {
      title: shareMessageTitle,
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
    qcloud.request({
      url: config.service.goodNumberUrl,
      login:true,
      success: function (res) { 
        that.setData({
          chinaMobileNumber: res.data.goodNumber[0].chinaMobileNumber,
          chinaUnicomNumber:res.data.goodNumber[1].chinaUnicomNumber,
          chinaTelecomNumber:res.data.goodNumber[2].chinaTelecomNumber,
          shareMessage: res.data.shareMessage
        })
        wx.hideLoading()
      }
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
          that.getGoodNumber()
        })
      },
      fail: function () {
        console.log('未授权')
      }
    })
  }
})