var config = require('../../config');
var qcloud = require('../../vendor/wafer2-client-sdk/index');
var util = require('../../utils/util.js')
var successCount = 0;//图片上传成功个数，用于和本地图片数比对；
//获取应用实例
Page({

  /**
   * 页面的初始数据
   */
  data: {
    //存储商品信息的对象
    upGoodsInfo:null,
    //品牌参数提示信息是否显示
    statusHint:'',
    describeFocus: false,
    priceFocus: false,
    //上传图片 遮罩层是否隐藏的状态
    imageUploadHint: [true, true, true, true, true, true, true, true, true],
    //图片在cos上的访问路径
    imageAccessUrl:[]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    /**
     * 每次页面加载，访问本地缓存空间，然后setData数据
     */
   // var upGoodsInfo=wx.getStorageSync('upGoodsInfo')
    wx.getStorage({
      key: 'upGoodsInfo',
      success: function(res) {
        that.setData({
          upGoodsInfo:res.data
        })
      },
      fail:function(res){
        var upGoodsInfo=new Object()
        wx.setStorageSync('upGoodsInfo', upGoodsInfo)
      }
    })
    wx.getStorage({
      key: 'statusHint',
      success: function(res) {
        that.setData({
          statusHint:statusHint
        })
      },
      fail:function(){
         var statusHint=new Object()
        wx.setStorageSync('statusHint', statusHint)
      }
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    var that = this
    var upGoodsInfo = wx.getStorageSync('upGoodsInfo')
    var statusHint = wx.getStorageSync('statusHint')
    that.setData({
      upGoodsInfo: upGoodsInfo,
      statusHint: statusHint,
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


  //标题完成或者失去焦点，setData并更新缓存
  goodsTitleInput: function (e) {
    var that = this
    var upGoodsInfo=that.data.upGoodsInfo
    upGoodsInfo.goodsTitle=e.detail.value
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
    wx.setStorageSync('upGoodsInfo', upGoodsInfo)

  },
  //设备标识完成或失去焦点,setData并更新缓存
  goodsImeiInput: function (e) {
    var that = this 
    var upGoodsInfo=that.data.upGoodsInfo
    upGoodsInfo.goodsImei=e.detail.value
    that.setData({
      priceFocus: true,
      upGoodsInfo: upGoodsInfo
    })
    wx.setStorageSync('upGoodsInfo', upGoodsInfo)
  },
  //价格完成或失去焦点
  goodsPriceInput: function (e) {
    var that = this
    var upGoodsInfo=that.data.upGoodsInfo
    upGoodsInfo.goodsPrice = e.detail.value
    that.setData({
      upGoodsInfo: upGoodsInfo
    })
    wx.setStorageSync('upGoodsInfo', upGoodsInfo)
  },
  /**
   * 添加图片，先把图片遮罩层隐藏，选取图片成功后setData localImageSrc数组，然后把数组缓存
   */
  addImage: function () {
    var that = this;
    var upGoodsInfo=that.data.upGoodsInfo
    that.setData({
      imageUploadHint: [true, true, true, true, true, true, true, true, true]
    })
    wx.chooseImage({
      count: 9, // 默认9
      sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success: function (res) {
        var localImageUrl=res.tempFilePaths
        upGoodsInfo.localImageUrl=localImageUrl
        that.setData({
          upGoodsInfo: upGoodsInfo
        });
        wx.setStorageSync('upGoodsInfo', upGoodsInfo)
      },
    });
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
    var upGoodsInfo = that.data.upGoodsInfo
    var goodsModel=upGoodsInfo.goodsModel
    console.log(goodsModel)
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

  //发布按钮响应函数
  uploadGoods: function () {
    var that = this
    var upGoodsInfo=that.data.upGoodsInfo
    if (upGoodsInfo.goodsTitle && upGoodsInfo.goodsDescribe && upGoodsInfo.goodsBrand && upGoodsInfo.goodsModel && upGoodsInfo.goodsColor && upGoodsInfo.goodsVolume && upGoodsInfo.goodsPrice && upGoodsInfo.goodsImei && upGoodsInfo.localImageUrl.length) {
      that.uploadImage(upGoodsInfo)
    } else {
      wx.showToast({
        title: '请完善商品信息',
      })
    }

  },
  //图片上传，先打开图片遮罩层，然后调用自定义图片上传函数，进行单个图片上传
  uploadImage: function (upGoodsInfo) {
    var that = this
    var localImageSrc=upGoodsInfo.localImageUrl
    var imageUploadHint = [false, false, false, false, false, false, false, false, false,]
    that.setData({
      imageUploadHint: imageUploadHint
    })
    if (localImageSrc && localImageSrc.length) {
      wx.showToast({
        title: '商品上传中',
        mask: true,
      })
      for (var i = 0; i < localImageSrc.length; i++) {
        that.myUploadImage(localImageSrc[i], i, localImageSrc.length)//参数：当前图片路径，当前图片路径index，图片总个数
      }
    }
  },
  //自定义上传图片，
  myUploadImage: function (uploadUrl, i, localLength) {//图片本地路径，当前图片的顺序index，图片总个数
    var that = this
    //   var file = uploadUrl.split("//")[1].split("/");
    //   var fileName = file[file.length - 1].split(".")[0];//从本地路径中，提取文件名
    //使用sdk自带upload函数上传图片
    wx.uploadFile({
      url: config.service.uploadSecImgUrl,
      filePath: uploadUrl,
      name: 'file',
      success: function (res) {
        res = JSON.parse(res.data)
        
        var imageUploadHint = that.data.imageUploadHint
        var imageAccessUrl = that.data.imageAccessUrl
        imageUploadHint[i] = true//关闭当前图片的遮罩层
        var imageName=res.data.name
        var imageUrl =res.data.imgUrl
        imageAccessUrl[i] = imageUrl//把获得的accessUrl存入当前index对应下标的数组
        that.setData({
          imageUploadHint: imageUploadHint,
          imageAccessUrl: imageAccessUrl,
        })
        /**
         * 上传成功后，成功计数加1，然后比对总图片个数，如果相等，说明全部图片上传完成。然后清零成功个数计数器,最后调用商品信息上传函数
         */
        successCount += 1
        if (successCount == localLength) {
          successCount = 0
          that.uploadAllInfo()
        }
        wx.showToast({
          title: '图片上传成功',
        })
      },
      fail: function (e) {
        wx.showToast({
          title: '图片上传失败',
        })
      }
    })
  },
  //所有信息上传服务器
  uploadAllInfo: function () {
    var that = this
    var upGoodsInfo= that.data.upGoodsInfo
    var imageAccessUrl=that.data.imageAccessUrl
    upGoodsInfo.imageAccessUrl=imageAccessUrl
    //把url数组拼接成一个字符串用",,"作为分隔符，后端php在分割成数组
    //var goodsAccessUrlString = goodsAccessUrl.join(",,")
    //var goodsHandleUrlString = goodsHandleUrl.join(",,")
    
      qcloud.request({
        login:true,
        url: config.service.uploadGoodsUrl,
        data: {
          upGoodsInfo: JSON.stringify(upGoodsInfo)
        },
        header: {
          'Content-Type': 'application/json'
        },
        method: 'POST',
        success: function (res) {
          console.log(res)
          that.goodsRemoveStorage()
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

  },
  //清空本地缓存数据
  goodsRemoveStorage: function () {
    wx.removeStorageSync('upGoodsInfo')
    wx.removeStorageSync('statusHint')
  }
})










