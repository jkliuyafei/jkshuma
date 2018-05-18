$(document).ready(function(){
  $(".handle-btn").click(function(){
	  var curId=$(this).data("id");
	  var msg="确定要下架该商品吗？"
	if(confirm(msg)==true){
		$.ajax({
			  type:"post",
			  data:"id="+curId,
			  url:"https://879515873.jkshuma.com/index.php/AdminSecondGoods/handle_goods",
			  //url:"https://qcy6umy7.qcloud.la/index.php/AdminSecondGoods/handle_goods",
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
});
