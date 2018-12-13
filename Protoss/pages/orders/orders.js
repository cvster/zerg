// pages/orders/orders.js
let App = getApp();

Page({

  /**
   * 页面的初始数据
   */
  data: {
    pageIndex: 1,
    loadingHidden:true,
    dataType: 'all',
    orderArr: [],
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /*生命周期函数--监听页面初次渲染完成*/
  onReady: function () {

  },

  /*生命周期函数--监听页面显示*/
  onShow: function () {
    var flag = wx.getStorageSync('newOrder');
    console.log(flag);
    if(flag)
      this.refreshOrders();
  },


  refreshOrders: function(){
    this.getOrders();
    this.data.isLoadedAll = false;  //是否加载完全
    this.data.pageIndex = 1;
    wx.stopPullDownRefresh();
    wx.setStorageSync('newOrder',false);  //更新标志位
  },

  /*获得所有订单,pageIndex 从1开始*/
  getOrders: function() {
    var that = this;
    var allParams = {
      url: 'order/by_user',
      data: { page: this.data.pageIndex },
      type: 'get',
      sCallback: function (res) {
        //1 未支付  2，已支付  3，已发货，4已支付，但库存不足
          var data = res.data;
          that.setData({
            loadingHidden: true
          });
          if (data.length > 0) {
            that.data.orderArr.push.apply(that.data.orderArr, res.data);  //数组合并
            that.setData({
              orderArr: that.data.orderArr
            });
          } else {
            that.data.isLoadedAll = true;  //已经全部加载完毕
            that.data.pageIndex = 1;
          }
      }
    };
    App.request(allParams);
  },
  


  /*显示订单的具体信息*/
  showOrderDetailInfo: function (event) {
    // var id = order.getDataSet(event, 'id');
    wx.navigateTo({
      url: '../login/login'
    });
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

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})