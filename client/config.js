/**
 * 小程序配置文件
 */

// 此处主机域名修改成腾讯云解决方案分配的域名
var host = 'https://qcy6umy7.qcloud.la';
//var host='https://879515873.jkshuma.com';

//角色权限表
var authTable = [];
authTable['superAdmin'] = { uploadAuth: 1,shopManageAuth:1 };
authTable['partnerMerchant'] = { uploadAuth: 1, shopManageAuth: 1};
authTable['normalMerchant'] = { uploadAuth: 0, shopManageAuth: 0};
authTable['agent'] = { uploadAuth: 0, shopManageAuth: 0};
authTable['user'] = { uploadAuth: 0, shopManageAuth: 0};

var config = {
authTable:authTable,
  // 下面的地址配合云端 Demo 工作
  service: {
    host,

    // 登录地址，用于建立会话
    loginUrl: `${host}/weapp/login`,
    //我自己的登陆接口
    myLoginUrl: `${host}/weapp/myLogin`,
    // 测试的请求地址，用于测试会话
    requestUrl: `${host}/weapp/myUser`,

    // 测试的信道服务地址
    tunnelUrl: `${host}/weapp/tunnel`,

    // 上传图片接口
    uploadUrl: `${host}/weapp/upload`,
    //获取用户信息包括openid和role
    getUserInfoUrl:`${host}/weapp/GetUserInfo`,
    //获取二手机列表
    secGoodsUrl: `${host}/weapp/SecondGoods`,
    //二手商品详情
    secGoodsDetailUrl: `${host}/weapp/SecondGoodsDetail`,
    //发布二手机时，选取品牌型号
    chooseBrandUrl: `${host}/weapp/ChooseBrand`,
    //发布二手机时，选取品牌型号对应的内存颜色
    chooseParameterUrl: `${host}/weapp/ChooseParameter`,
    //上传图片接口
    uploadImage:`${host}/weapp/UploadImage`,
    //上传二手商品信息
    uploadGoodsUrl: `${host}/weapp/UploadGoods`,
    //获取手机靓号
    goodNumberUrl: `${host}/weapp/GoodNum`,
    //获取加容量报价表
    addVolumeUrl: `${host}/weapp/AddVolume`,
    //获取维修报价
    phoneRepairUrl: `${host}/weapp/PhoneRepair`,
    //新机报价
    phoneQuotation: `${host}/weapp/NewPhone`,
    //上传分享页图片url地址
    uploadShareImgUrl:`${host}/weapp/UploadShareImgUrl`,
    //获取分享页面的所有信息和图片
    getShareMessage: `${host}/weapp/GetShareMessage`,
    //更新分享信息推广语和图片
    uploadShareMessage:`${host}/weapp/UploadShareMessage`,
    //获取具体某个页面的share信息，比如二手机库存页面
    getPageShare: `${host}/weapp/GetPageShare`
  },
};

module.exports = config;