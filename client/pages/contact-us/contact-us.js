// pages/contact-us/contact-us.js
var config = require('../../config.js');
Page({
  data: {
    shopPhoto: ['http://jkshuma-1253513251.cos.ap-guangzhou.myqcloud.com/second-goods/secondGoodsImg/69b8fe4da6add0eaf9a69748f63b9b55-tmp_dbf629b964e5e24c8b667819f88754e8.jpg',
      'http://jkshuma-1253513251.cos.ap-guangzhou.myqcloud.com/second-goods/secondGoodsImg/b6b5b6b9c5cc47929fd0c08de1b9af1c-tmp_a71b78eb1f223ead7d14745317071962.jpg',
      'http://jkshuma-1253513251.cos.ap-guangzhou.myqcloud.com/second-goods/secondGoodsImg/c463d5ac780fc30089be1804f7529996-tmp_41ef6038e2658bf231efa56445a2fe57.jpg',
      'http://jkshuma-1253513251.cos.ap-guangzhou.myqcloud.com/second-goods/secondGoodsImg/ed48cc4632921b75679078db2787ad11-tmp_cc1c1bb13d07c30c0457d25db2da2444.jpg',
    'http://jkshuma-1253513251.cos.ap-guangzhou.myqcloud.com/second-goods/secondGoodsImg/cbe56ccb36e6d2ccd39b19d2c537927b-tmp_3b81ac91f3e519646fae0f31358a531b.jpg'],
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数

  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
  },
  onHide: function () {
    // 页面隐藏
  },
  onUnload: function () {
    // 页面关闭
  },
  formSubmit: function (e) {

  },

  makePhoneCall: function () {
    wx.makePhoneCall({
      phoneNumber: '17785115730',
    })
  },
  showShopLocation: function () {
      wx.openLocation({
        latitude: 26.573450639141093,
        longitude: 106.7125550251,
        scale:28,
        name:'极客数码和丰店',
        address:'贵州省贵阳市南明区中华南路25号和丰通讯商城二楼22号极客数码'
      })
  },
  seeBigPhoto:function(e){
    var that = this
    var shopPhoto=that.data.shopPhoto
    var curIndex=e.currentTarget.dataset.index
    wx.previewImage({
      current:shopPhoto[curIndex],
      urls: shopPhoto,
    })
  }

})