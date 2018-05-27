var config = require('../../config');
var qcloud = require('../../vendor/wafer2-client-sdk/index');
var util = require('../../utils/util.js')
var myUploadImage = require('../../utils/uploadImage.js')

Page({
  data: {
    //存储商品信息的对象
    upGoodsInfo: {},
    //品牌参数提示信息是否显示
    statusHint: [],
    describeFocus: false,
    priceFocus: false,
    //上传图片 遮罩层是否隐藏的状态
    imageUploadHint: [true, true, true, true, true, true, true, true, true],
    //本地图片路径
    localImageUrl: [],
    goodsParameter: []
  },
  onShow: function () {
    var that = this
    var goodsParameter = wx.getStorageSync('goodsParameter')
    var statusHint = wx.getStorageSync('statusHint')
    that.setData({
      goodsParameter: goodsParameter,
      statusHint: statusHint
    })
  },
  addImage: function () {
    var that = this
    var imageUploadHint = [true, true, true, true, true, true, true, true, true]
    that.setData({
      imageUploadHint: imageUploadHint
    })
    wx.chooseImage({
      count: 9, // 默认9
      sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success: function (res) {
        var localImageUrl = res.tempFilePaths
        that.setData({
          localImageUrl: localImageUrl
        })

      },
    });
  },
  uploadImage: function (callback) {
    var that = this
    var localImageUrl = that.data.localImageUrl
    var imageUploadHint = [false, false, false, false, false, false, false, false, false,]
    that.setData({
      imageUploadHint: imageUploadHint
    })
    var imageUrl = new Array()
    if (localImageUrl && localImageUrl.length) {
      for (var i = 0; i < localImageUrl.length; i++) {
        myUploadImage.uploadImage({
          filePath: localImageUrl[i],
          formData: { folderName: '/secondGoodsImg/',imageIndex:i },
          success: function (res) {
            var tempArr=new Object()
            var imageIndex=res.data.imageIndex
            var cosImageUrl=res.data.imgUrl
            imageUploadHint[imageIndex] = true//关闭当前图片的遮罩层
            tempArr.imageUrl=cosImageUrl
            tempArr.imageIndex=imageIndex
            imageUrl.push(tempArr)//把上传成功后cos上的图片链接push到imageUrl二维数组
            that.setData({
              imageUploadHint: imageUploadHint
            })
            //cos返回的图片链接等于本地的图片链接个数时，说明所有图片已经都上传成功了
            if (imageUrl.length == localImageUrl.length) {
              callback(imageUrl)
            }
          },
          fail: function (e) {
           
          }
        })
      }
    } else {
      wx.showToast({
        title: '还未选择图片',
      })
    }
  },
  //选取品牌
  chooseBrand: function () {
    wx.navigateTo({
      url: '../second-choose-brand/second-choose-brand',
    })
  },
  //选取手机参数
  chooseParameter: function () {
    var that = this
    var goodsParameter = that.data.goodsParameter
    var goodsModel = goodsParameter.goodsModel
    if (goodsModel !== undefined) {
      wx.navigateTo({
        url: '../second-choose-parameter/second-choose-parameter?goodsModel=' + goodsModel,
      })
    } else {
      wx.showToast({
        title: '请先选择商品型号',
      })
    }
  },
  //设备标识完成或失去焦点,setData并更新缓存
  goodsImeiInput: function (e) {
    var that = this
    var upGoodsInfo = that.data.upGoodsInfo
    upGoodsInfo.goodsImei = e.detail.value
    that.setData({
      priceFocus: true,
      upGoodsInfo: upGoodsInfo
    })
  },
  //价格完成或失去焦点
  goodsPriceInput: function (e) {
    var that = this
    var upGoodsInfo = that.data.upGoodsInfo
    upGoodsInfo.goodsPrice = e.detail.value
    that.setData({
      upGoodsInfo: upGoodsInfo
    })
  },
  //标题完成或者失去焦点，setData并更新缓存
  goodsTitleInput: function (e) {
    var that = this
    var upGoodsInfo = that.data.upGoodsInfo
    upGoodsInfo.goodsTitle = e.detail.value
    wx.setStorageSync('upGoodsInfo', upGoodsInfo)
    that.setData({
      describeFocus: true,
      upGoodsInfo: upGoodsInfo
    })

  },
  //描述完成或失去焦点,setData并更新缓存
  goodsDescribeInput: function (e) {
    var that = this
    var upGoodsInfo = that.data.upGoodsInfo
    upGoodsInfo.goodsDescribe = e.detail.value
    that.setData({
      upGoodsInfo: upGoodsInfo
    })
  },

  //上传商品信息
  uploadGoods: function () {
    var that = this
    var localImageUrl = that.data.localImageUrl
    var upGoodsInfo = that.data.upGoodsInfo
    var goodsParameter = that.data.goodsParameter
    if (upGoodsInfo.goodsTitle && upGoodsInfo.goodsDescribe && goodsParameter.goodsBrand && goodsParameter.goodsModel && goodsParameter.goodsColor && goodsParameter.goodsVolume && upGoodsInfo.goodsPrice && upGoodsInfo.goodsImei && localImageUrl.length) {
      that.uploadImage(function (res) {
        qcloud.myRequest({
          login:true,
          url: config.service.uploadGoodsUrl,
          data:{
                imageUrl:res,
                goodsParameter:goodsParameter,
                upGoodsInfo:upGoodsInfo
          },
          header: {
            'Content-Type': 'application/json'
          },
          method: 'POST',
          success:function(res){
            that.goodsClean()
            wx.showModal({
              title: '上传成功',
              content: '商品已经成功上传',
              showCancel: false,
              success: function (res) {
                if (res.confirm) {
                  wx.setStorageSync('up_refer', 1)
                  wx.navigateBack({
                  })
                }
              }
            })
          }
        })

      })
    } else {
      wx.showToast({
        title: '请完善商品信息',
      })
    }
  },
  //清空本地缓存数据
  goodsClean: function () {
    wx.removeStorageSync('goodsParameter')
    wx.removeStorageSync('statusHint')
  }

})