//index.js
//获取应用实例
const app = getApp()

Page({
  data: {
    motto: 'Hello World',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo')
  },
  //事件处理函数
  bindViewTap: function() {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  onLoad: function () {
    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    } else if (this.data.canIUse){
      // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
      // 所以此处加入 callback 以防止这种情况
      app.userInfoReadyCallback = res => {
        this.setData({
          userInfo: res.userInfo,
          hasUserInfo: true
        })
      }
    } else {
      // 在没有 open-type=getUserInfo 版本的兼容处理
      wx.getUserInfo({
        success: res => {
          app.globalData.userInfo = res.userInfo
          this.setData({
            userInfo: res.userInfo,
            hasUserInfo: true
          })
        }
      })
    }
  },
  getUserInfo: function(e) {
    app.globalData.userInfo = e.detail.userInfo
    this.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
  },
  /**
   * 点击事件
   */
  clickUp:function(obj){
    this.setData({something:'........'});
    var that = this;
   //发送请求
    wx.request({
      url: 'https://www.zhiyu8023.com/wx_program.php',
      data:{
        sign: 'gaozi_smallProgram_Test_001',
        service:'Test',
        method:'index',
      },
      method:'POST',
      header:{
        'content-type':'application/x-www-form-urlencoded',
      },
      success: function(json){
        console.log(json.data.sign);
        that.setData({ sign: json.data.sign});
        //this.setData({ sign: json.sign})
      }

    })
  }
})
