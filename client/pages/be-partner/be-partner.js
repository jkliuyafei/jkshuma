// pages/be-partner/be-partner.js
/**
 * 本页面的功能是超级管理员转发给兄弟店来开通兄弟店，角色仅为superAdmin时才会显示转发按钮；
 * 兄弟店通过分享的链接打开后，填写email,password,name,phoneNumber后提交，后台把用
 * 户角色从user变成partnerMerchant，然后通过util.getUserInfo(1,callback)函数刷新本地userinfo
 * 缓存；用户角色变成partnerMerchant后，如果再次打开超级管理员分享的小程序页面，此时通过缓存判断
 * 角色为partnerMerchant,然后隐藏提交按钮，防止重复提交；
 */
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
Page({

  /**
   * 页面的初始数据
   */
  data: {
  adminShare:true,
  openBtn:true
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var appInstance = getApp()
    var sceneData = appInstance.sceneData
    var that = this
    util.getUserInfo(0, function (res) {
      var userRole=res.role;
      if(userRole=='superAdmin'){
        that.setData({
          adminShare:false,
        })
      }
      //默认情况，用户成为合作商家
      if(userRole=='user'&&sceneData==1007){
        that.setData({
          openBtn:false,
        })
      }
      //特殊情况，超级管理员代理成为合作商家
      if (userRole == 'agent' && sceneData == 1007) {
        that.setData({
          openBtn: false,
        })
      }
    })
  },

  
})