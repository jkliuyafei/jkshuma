/**
 * 小程序配置文件
 */

// 此处主机域名修改成腾讯云解决方案分配的域名
var host = 'https://qcy6umy7.qcloud.la';
//var host='https://879515873.jkshuma.com';

var config = {

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
    //获取权限表
    getAuthTab:`${host}/weapp/AuthTab`,
    //获取二手机列表
    secGoodsUrl: `${host}/weapp/SecondGoods`,
    //发布二手机时，选取品牌型号
    chooseBrandUrl: `${host}/weapp/ChooseBrand`,
    //发布二手机时，选取品牌型号对应的内存颜色
    chooseParameterUrl: `${host}/weapp/ChooseParameter`,
    //二手商品上传图片
    uploadSecImgUrl: `${host}/weapp/UploadSecImg`,
    //上传二手商品信息
    uploadGoodsUrl: `${host}/weapp/UploadGoods`,
    //获取手机靓号
    goodNumberUrl: `${host}/weapp/GoodNum`,
    //获取加容量报价表
    addVolumeUrl: `${host}/weapp/AddVolume`,
    //获取维修报价
    phoneRepairUrl: `${host}/weapp/PhoneRepair`,
    //新机报价
    phoneQuotation: `${host}/weapp/NewPhone`
  },
};

module.exports = config;