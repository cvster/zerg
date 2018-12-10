let App = getApp();

Page({

  /**
   * 页面的初始数据
   */
  data: {

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log('login.onload');
  },

  /**
   * 授权登录
   */
  authorLogin: function (e) {
    if (e.detail.errMsg !== 'getUserInfo:ok') {
      console.log('authorLogin failed')
      console.log(e.detail.errMsg)
      return false;
    }

    wx.showLoading({ title: "正在登录", mask: true });
    wx.login({
      success: function () {
        console.log('login ---------------------------');
      },
    })

    this._updateUserInfo(e.detail.rawData);
    wx.setStorageSync('userinfo', e.detail.rawData)
    wx.navigateBack();
  },


  /*更新用户信息到服务器*/
  _updateUserInfo: function (res) {
    var nickName = res.nickName;
    delete res.avatarUrl;  //将昵称去除
    delete res.nickName;  //将昵称去除
    var allParams = {
      url: 'user/wx_info',
      data: { nickname: nickName, extend: JSON.stringify(res) },
      type: 'post',
      sCallback: function (data) {
      }
    };
    App.request(allParams);
  },


})