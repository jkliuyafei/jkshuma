// pages/wx-test/wx-test.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
Page({

  /**
   * 页面的初始数据
   */
  data: {

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
        console.log('用户已经授权')
        util.checkAuthTab(config.service.getAuthTab, function (res) {
          console.log(res)
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

  },

  myGetUserInfo: function (e) {
    var that = this;
    util.myGetUserInfo({
      userInfo: e,
      success: function () {
        that.dialog.hideDialog();
        //执行api逻辑
        util.checkAuthTab(config.service.getAuthTab, function (res) {
          console.log(res)
        })
      },
      fail: function () {
      }
    })
  }
})