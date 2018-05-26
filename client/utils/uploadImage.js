var util=require('./util.js')
var config=require('../config.js')
var noop = function noop() { };
var defaultOptions = {
  url: config.service.uploadImage,
  filePath:null,
  name: 'file',
  formData:{},
  success: noop,
  fail: noop,
}
var uploadImage=(options)=>{
  options = util.extend({}, defaultOptions, options);
  wx.uploadFile({
    url: options.url,
    filePath: options.filePath,
    name: options.name,
    formData:options.formData,
    success:function(res){
      res = JSON.parse(res.data)
      options.success(res)
    },
    fail:function(e){
      options.fail(e)
    }
  })
}
module.exports = { uploadImage,}