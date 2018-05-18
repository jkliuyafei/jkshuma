var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
Page({

  /**
   * 页面的初始数据
   */
  data: {
    shareMessage: '',
    phoneRepairTable: [],
    curIndex: 0,
    modelDetailHead: {
      phoneModel: '型号', outsideScreenOriginal: '外屏(原装后压)', outsideScreenAssemble: '外屏(组装屏)',
      insideScreenOriginal: '总成(原装后压)', insideScreenAssemble: '总成(组装屏)', battery: '电池', phoneShell: '机壳', phoneModelOne: '型号',frontCamera: '前摄像头', backCamera: '后摄像头', phoneWinding: '开机/音量排线', sperker: '听筒/扬声器', tailePlug: '尾插', phoneUnclock: '解锁', phoneModelTwo: '型号'
    },
    toView: 'iphone'
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
          that.getRepairTab()
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
  switchTopTab: function (e) {
    var that = this
    that.setData({
      curIndex: e.target.dataset.index,
      toView: e.target.dataset.brandId
    })
  },
  getRepairTab:function(){
    var that = this
    wx.showLoading({
      title: '维修报价更新中',
      mask: 'true',
    })
    qcloud.request({
      url: config.service.phoneRepairUrl,
      login:true,
      success: function (res) {
        that.setData({
          phoneRepairTable: res.data.phoneRepairTable,
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
          that.getRepairTab()
        })
      },
      fail: function () {
        console.log('未授权')
      }
    })
  }


})