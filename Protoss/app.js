//app.js
import { Token } from 'utils/token.js';

App({
  onLaunch: function () {
    var token = new Token();
    token.verify();
  },

  onShow:function(){
  
  },

  /**
   * 检查是否登录，没有登录则跳转到登录页面
   */
  checkLogin:function(){
    var userinfo = wx.getStorageSync('userinfo');
    //navigateTo,redirectTo
    if (!userinfo) {
      wx.navigateTo({
        url: '/pages/login/login'
      });
    }
  },



  //http 请求类, 当noRefech为true时，不做未授权重试机制
  request:function(params, noRefetch) {
    var that = this,
      url = Config.restUrl + params.url;
    if (url.indexOf("?") > -1)
      url = url + '&' + Config.debugUrl;
    else
      url = url + '?' + Config.debugUrl;
    if (!params.type) {
      params.type = 'get';
    }
    /*不需要再次组装地址*/
    if (params.setUpUrl == false) {
      url = params.url;
    }
    wx.request({
      url: url,
      data: params.data,
      method: params.type,
      header: {
        'content-type': 'application/json',
        'token': wx.getStorageSync('token')
      },
      success: function (res) {

        // 判断以2（2xx)开头的状态码为正确
        // 异常不要返回到回调中，就在request中处理，记录日志并showToast一个统一的错误即可
        var code = res.statusCode.toString();
        var startChar = code.charAt(0);
        if (startChar == '2') {
          params.sCallback && params.sCallback(res.data);
        } else {
          if (code == '401') {
            if (!noRefetch) {
              that._refetch(params);
            }
          }
          that._processError(res);
          params.eCallback && params.eCallback(res.data);
        }
      },
      fail: function (err) {
        //wx.hideNavigationBarLoading();
        that._processError(err);
        // params.eCallback && params.eCallback(err);
      }
    });
  },

    _processError:function(err) {
    console.log(err);
  },

    _refetch:function(param) {
    var token = new Token();
    token.getTokenFromServer((token) => {
      this.request(param, true);
    });
  },

})