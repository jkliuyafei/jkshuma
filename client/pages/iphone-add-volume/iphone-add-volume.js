// pages/iphone-add-volume/iphone-add-volume.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
Page({

  /**
   * 页面的初始数据
   */
  data: {
      iphoneAddVolume:[],
      shareMessage:'',
      tableHead:{model:'型号',volume32:'32G',volume64:'64G',volume128:'128G',volume256:'256G'}
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
          that.getAddTable()
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
    var shareMessageTitle = that.data.shareMessage
    return {
      title: shareMessageTitle,
    }
  
  },
  getAddTable:function(){
    var that = this
    wx.showLoading({
      title: '数据更新中',
      mask: 'true',
    })
    qcloud.request({
      url: config.service.addVolumeUrl,
      login:true,
      success: function (res) {
        that.setData({
          iphoneAddVolume: res.data.iphoneAddVolume,
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
          that.getAddTable()
        })
      },
      fail: function () {
        console.log('未授权')
      }
    })
  }
})