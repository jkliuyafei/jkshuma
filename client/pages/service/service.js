// pages/service/service.js
Page({
  data:{
    showOrNot:true,
  },
  onLoad:function(options){
    // 页面初始化 options为页面跳转所带来的参数
    var that = this
    wx.getStorage({
      key: 'userAuthTab',
      success: function (res) {
        var userAuthTab=res.data
        if(userAuthTab.shopManagerAuth==1){
          that.setData({
            showOrNot:false
          })
        }
      },
    })
  },
  onReady:function(){
    // 页面渲染完成
    
  },
  onShow:function(){
    // 页面显示
  },
  onHide:function(){
    // 页面隐藏
  },
  onUnload:function(){
    // 页面关闭
  },
  phoneRepair:function(){
    wx.navigateTo({
      url: '../phone-repair/phone-repair',

    })
  },
  phoneNumber:function(){
    wx.navigateTo({
      url: '../good-phone-number/good-phone-number',
    })
  },
  iphoneAddVolume:function(){
    wx.navigateTo({
      url: '../iphone-add-volume/iphone-add-volume',
    })
  },
  shopManage:function(){
    wx.navigateTo({
      url: '../shop-manage/shop-manage',
    })

  },
  wxTest:function(){
    wx.navigateTo({
      url: '../wx-test/wx-test',
    })
  },
  

})