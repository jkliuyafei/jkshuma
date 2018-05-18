// components/Dialog/dialog.js
Component({
  options: {
    multipleSlots: true // 在组件定义时的选项中启用多slot支持
  },
  /**
   * 组件的属性列表
   * 用于组件自定义设置
   */
  properties: {
   
  },

  /**
   * 私有数据,组件的初始数据
   * 可用于模版渲染
   */
  data: {
    // 弹窗显示控制
    dialogIsShow: false
  },

  /**
   * 组件的方法列表
   * 更新属性和数据的方法与更新页面数据的方法类似
   */
  methods: {
    /*
     * 公有方法
     */

    //隐藏弹框
    
    hideDialog() {
      this.setData({
        dialogIsShow: false
      });
    },
    //展示弹框
    showDialog() {
      this.setData({
        dialogIsShow: true
      })
    },
  
    getUserInfoEvent:function(e){
      var myEventDetail=e
      var myEventOption={}
      this.triggerEvent('myGetUserInfo',myEventDetail,myEventOption)
    }
    
  }
})

