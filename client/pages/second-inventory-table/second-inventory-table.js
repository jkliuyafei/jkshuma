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
    var that=this;
    util.checkAuth({
      success: function () {
        //执行api逻辑
        util.checkAuthTab(config.service.getAuthTab, function (res) {
         var secondGoods=wx.getStorageSync('secondGoods');
         var shareMessage = wx.getStorageSync('shareMessage')
         if(secondGoods.length==0){
           that.getSecondGoods();
         }else{
           that.setData({
             secondGoods: secondGoods,
             shareMessage: shareMessage
           })
         }
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
  myGetUserInfo: function (e) {
    var that = this;
    util.myGetUserInfo({
      userInfo: e,
      success: function () {
        //执行api逻辑
        that.dialog.hideDialog();
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
      fail: function () {
        console.log('未授权')
      }
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
    qcloud.request({
      url: config.service.secGoodsUrl,
      login:true,
      success: function (res) {
        that.setData({
          secondGoods: res.data.secondGoods,
          shareMessage: res.data.shareMessage
        })
        wx.setStorage({
          key: 'secondGoods',
          data: res.data.secondGoods,
        })
        wx.setStorage({
          key: 'shareMessage',
          data: res.data.shareMessage,
        })
        wx.hideLoading()
      }
    })
  },
})