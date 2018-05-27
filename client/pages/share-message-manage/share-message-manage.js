var config = require('../../config');
var qcloud = require('../../vendor/wafer2-client-sdk/index');
var util = require('../../utils/util.js')
var myUploadImage=require('../../utils/uploadImage.js')
var imageUrl = ''
var pageId = 0
var message = ''
Page({

  /**
   * 页面的初始数据
   */
  data: {
    pageNameText: '选择页面',
    imageUrlArr: [],
    messageArr: [],
    preImageSrc: '../../image/nothing.png',
    shareMessageHolder: '请填写推广语',
    inputValue:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
    that.getShareMessage()
  },
  upLoadImage: function () {
    var that = this
    wx.chooseImage({
      count: 9,
      sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success: function (res) {
        var localImageUrl = res.tempFilePaths
        var imageUrl = new Array()
        if (localImageUrl && localImageUrl.length) {
          wx.showLoading({
            title: '图片上传中',
            mask: 'true',
          })
          for (var i = 0; i < localImageUrl.length; i++) {
            myUploadImage.uploadImage({
              filePath: localImageUrl[i],
              formData: { folderName: '/shareImage/',imageIndex:i },
              success: function (res) {
               
                imageUrl.push(res.data.imgUrl)
                if (imageUrl.length == localImageUrl.length) {
                  qcloud.myRequest({
                    url: config.service.uploadShareImgUrl,
                    login: true,
                    data: { imageUrl: imageUrl },
                    header: {
                      'Content-Type': 'application/json'
                    },
                    method: 'POST',
                    success: function (res) {
                      that.getShareMessage()
                      wx.hideLoading()
                      wx.showToast({
                        title: '图片上传成功',
                        mask: true,
                      })

                    },
                    fail: function (e) {
                    }
                  })
                }
              },
              fail:function(e){
                
              }
            })
          }
        }
      },
    })
  },
  getShareMessage: function () {
    var that = this
    qcloud.myRequest({
      url: config.service.getShareMessage,
      login: true,
      success: function (res) {
        var res=res.data
        that.setData({
          imageUrlArr: res.data.imageArr,
          messageArr: res.data.messageArr
        })
      }
    })
  },
  choosePage: function (e) {
    var that = this
    var index = e.detail.value
    var messageArr = that.data.messageArr
    pageId = messageArr[index]['id']
    that.setData({
      preImageSrc: messageArr[index]['imageUrl'],
      pageNameText: messageArr[index]['pageName'],
      shareMessageHolder: messageArr[index]['message']
    })
  },
  chooseImage: function (e) {
    var that = this
    imageUrl = e.currentTarget.dataset.imageUrl
    that.setData({
      preImageSrc: e.currentTarget.dataset.imageUrl
    })
  },
  shareMessageInput: function (e) {
    message = e.detail.value
  },
  uploadInfo: function () {
    var that=this
    if (message.length == 0) {
      wx.showToast({
        title: '请填写推广语',
      })
    } else if (imageUrl.length == 0) {
      wx.showToast({
        title: '请选择图片',
      })
    } else if (pageId == 0) {
      wx.showToast({
        title: '请选择页面',
      })
    } else {
      wx.showLoading({
        title: '上传中...',
        mask: true,
      })
      qcloud.myRequest({
        url: config.service.uploadShareMessage,
        login: true,
        data: {
          id: pageId,
          imageUrl: imageUrl,
          message: message
        },
        header: {
          'Content-Type': 'application/json'
        },
        method: 'POST',
        success: function (res) {
          that.setData({
            inputValue: '',
            shareMessageHolder:message
          })
          that.getShareMessage()
          wx.hideLoading()
          pageId = 0
          message = ''
          imageUrl = ''
          
        },
        fail: function (e) {

        }
      })
    }
  }

})