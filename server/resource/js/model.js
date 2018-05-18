$(document).ready(function(){
  $("button[name='handle_model']").click(function(){
	  var curId=$(this).data("id");
	  var msg="确定要操作该型号吗？"
	if(confirm(msg)==true){
		$.ajax({
			  type:"post",
			  data:"id="+curId,
			  url:"https://879515873.jkshuma.com/index.php/AdminModel/handle_model",
			  //url:"https://qcy6umy7.qcloud.la/index.php/AdminModel/handle_model",
			  success:function(){
				  window.location.reload();
			  },
			  error:function(){
				  alert("error");
			  }
		  })
	}else{
		alert("您取消了操作。")
	}
	  
  })
  $("button[name='add_model']").click(function(){
	  var newOrOld=$("input[name='newOrOld']").val();
	  var brand=$("select[name='phoneBrand']").val();
	  var model=$("input[name='model']").val();
	  if(newOrOld.length==0||brand.length==0||model.length==0){
		  alert("录入数据不完整，重新录入！");
			return false;
	  }else{
		  $("form[name='add_model_form']").submit();
	  }
  })
});
