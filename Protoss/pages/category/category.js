import { Category } from 'category-model.js';
var category=new Category();  //实例化 home 的推荐页面
Page({
  data: {
    // transClassArr: ['tanslate0', 'tanslate1', 'tanslate2', 'tanslate3', 'tanslate4', 'tanslate5', 'tanslate6', 'tanslate7'],
    currentMenuIndex:0,
    loadingHidden:false,
    transDown:0,
    allCategoryDetail:[],
  },
  onLoad: function () {
    this._loadData();
  },

  /*加载所有数据*/
  _loadData:function(callback){
    var that = this;
    category.getAllCategory((categoryData)=>{

      that.setData({
        allCategoryArr: categoryData,
        loadingHidden: true,
        allCategoryDetail:categoryData,
      });

      that.getProductsByCategory(categoryData[0].id,(data)=>{
        var dataObj= {
          procucts: data,
          topImgUrl: categoryData[0].img_url,
          title: categoryData[0].name
        };

        that.setData({
          'allCategoryDetail[0].procucts': data,
          'allCategoryDetail[0].topImgUrl': categoryData[0].img_url,
          'allCategoryDetail[0].title': categoryData[0].name,
        });

        that.data.allCategoryDetail[0] = {
          procucts: data,
          topImgUrl: categoryData[0].img_url,
          title: categoryData[0].name
        };
        console.log(dataObj);
        console.log(categoryData[0]);
        
        that.setData({
          loadingHidden: true,
          categoryInfo0:dataObj
        });
        callback&& callback();
      });
    });
  },

  /*切换分类*/
  changeCategory:function(event){
    var index=category.getDataSet(event,'index'),
        id=category.getDataSet(event,'id')//获取data-set
    this.setData({
      currentMenuIndex:index,
      transDown:-100*index,
    });

    //如果数据是第一次请求
    if(!this.isLoadedData(index)) {
      var that=this;
      this.getProductsByCategory(id, (data)=> {
        that.setData(that.getDataObjForBind(index,data));
      });
    }
  },

  isLoadedData:function(index){
    if(this.data['categoryInfo'+index]){
      return true;
    }
    return false;
  },

  getDataObjForBind:function(index,data){
    var obj={},
      baseData = this.data.allCategoryArr[index];
    for (var i = 0; i < this.data.allCategoryArr.length; i++){
      // console.log(i);
      if (i == index){
        obj['categoryInfo' + i] = {
          procucts: data,
          topImgUrl: baseData.img_url,
          title: baseData.name
        };
        this.data.allCategoryDetail[i] = {
          procucts: data,
          topImgUrl: baseData.img_url,
          title: baseData.name
        };

        var setDataPorducts = 'allCategoryDetail[' + i + '].procucts';
        var setDataTopImgUrl = 'allCategoryDetail[' + i + '].topImgUrl';
        var setDataTitle = 'allCategoryDetail[' + i + '].title';
        this.setData({
          [setDataPorducts]: data,
          [setDataTopImgUrl]: baseData.img_url,
          [setDataTitle]: baseData.name
        });


        return obj;
      }
    }
  },

  getProductsByCategory:function(id,callback){
    category.getProductsByCategory(id,(data)=> {
      callback&&callback(data);
    });
  },

  /*跳转到商品详情*/
  onProductsItemTap: function (event) {
    var id = category.getDataSet(event, 'id');
    wx.navigateTo({
      url: '../product/product?id=' + id
    })
  },

  /*下拉刷新页面*/
  onPullDownRefresh: function(){
    this._loadData(()=>{
      wx.stopPullDownRefresh()
    });
  },

  //分享效果
  onShareAppMessage: function () {
    return {
      title: '零食商贩 Pretty Vendor',
      path: 'pages/category/category'
    }
  }

})