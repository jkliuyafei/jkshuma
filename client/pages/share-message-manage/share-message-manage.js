var config = require('../../config');
var qcloud = require('../../vendor/wafer2-client-sdk/index');
var util = require('../../utils/util.js')
// pages/share-message-manage/share-message-manage.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    array: ['美国', '中国', '巴西', '日本'],
    imageUrlArr:[]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
  },
  upLoadImage:function(){
    var that=this
    wx.chooseImage({
      count:9,
      sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success: function(res) {
        var localImageUrl = res.tempFilePaths
        var imageUrl=new Array()
        if (localImageUrl && localImageUrl.length) {
          wx.showLoading({
            title: '图片上传中',
            mask: 'true',
          })
          for (var i = 0; i < localImageUrl.length; i++) {
            wx.uploadFile({
              url: config.service.uploadShareImg,
              filePath: localImageUrl[i],
              name: 'file',
              success:function(res){
                res = JSON.parse(res.data)
                imageUrl.push(res.data.imgUrl)
                if(imageUrl.length==localImageUrl.length){
                  var imageUrlArr=that.data.imageUrlArr
                  imageUrlArr=imageUrl.concat(imageUrlArr)
                  that.setData({
                    imageUrlArr:imageUrlArr
                  })
                    wx.hideLoading()
                    qcloud.myRequest({
                      url: config.service.uploadShareImgUrl,
                      login: true,
                      data: { imageUrl: imageUrl},
                      header: {
                        'Content-Type': 'application/json'
                      },
                      method: 'POST',
                      success:function(res){
                        wx.showToast({
                          title: '图片上传成功',
                          mask: true,
                        })
                      },
                      fail:function(e){
                        
                      }
                    })
                }

              }
            })
          }
        }
      },
    })
  }

})