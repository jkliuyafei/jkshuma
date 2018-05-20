// pages/second-inventory-table/second-inventory-table.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
Page({

  /**
   * 页面的初始数据
   */
  data: {
      tableHeadItem:{goodsIndex:'序号',goodsBrand:'品牌',goodsModel:'型号',goodsColor:'颜色',goodsVolume:'容量',goodsImei:'设备标识',
      goodsPrice:'价格',goodsDetail:'详情'},
      secondGoods:[],
      shareMessage:null
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that=this
    util.checkAuthTab(config.service.getAuthTab, function (res) {
      var secondGoods = wx.getStorageSync('secondGoods');

      var shareMessage = wx.getStorageSync('shareMessage')
      if (secondGoods.length == 0) {
        that.getSecondGoods();
      } else {
        that.setData({
          secondGoods: secondGoods,
          shareMessage: shareMessage
        })
      }

    })

  },




  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
    that.getGoodsTable()
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
    var shareMessageTitle=that.data.shareMessage
      return{
        title:shareMessageTitle,
      }
  },
  seeGoodsDetail:function(e){
    var curIndex=e.currentTarget.dataset.index
    console.log(curIndex)
    wx.navigateTo({
      url: '../second-goods-detail/second-goods-detail?curIndex=' + curIndex,
    })
  },
  getSecondGoods: function () {
    var that = this
    wx.showLoading({
      title: '数据加载中，请稍后...',
      mask: 'true',
    })
    wx.removeStorageSync('secondGoods')
    wx.removeStorageSync('shareMessage')
    qcloud.myRequest({
      url: config.service.secGoodsUrl,
      login: true,
      success: function (res) {
        that.setData({
          secondGoods: res.data.data.secondGoods,
          shareMessage: res.data.data.shareMessage
        })
        wx.setStorage({
          key: 'secondGoods',
          data: res.data.data.secondGoods,
        })
        wx.setStorage({
          key: 'shareMessage',
          data: res.data.data.shareMessage,
        })
        wx.hideLoading()
      }
    })
  },
})