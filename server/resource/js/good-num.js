$(document).ready(function(){
 // $(".costPriceCtrl").click(function(){
//	$(".cost-price").toggle();  
 // });
  $("#expen-form-submit").click(function(){
	  var tenant=$("select[name='expen-form-tenant']").val();
	  var operator=$("select[name='expen-form-operator']").val();
	  var qcellcore=$("select[name='expen-form-qCellCore']").val();
	  var price=$("input[name='expen-form-price']").val();
	  var costPrice=$("input[name='expen-form-costprice']").val();
	  var type=$("input[name='expen-form-type']").val();
	  var expense=$("textarea[name='expen-form-detail']").val();
	  if(tenant=="供应商"||operator=="运营商"||qcellcore=="归属地"||price.length==0||costPrice.length==0||type.length==0||expense.length==0){
		  alert("输入数据不完整！");
		  return false;
	  }else if(Number(price)<=Number(costPrice)){
		  alert("零售价怎么能小于成本价？返回修改！")
		  return false;
	  }else{
		  $("form[name='expen-form']").submit();
	  }
  });
  $("#add-form-submit").click(function(){
	  var expenseString=$("select[name='add-form-expense']").val();
	  var numsString=$("textarea[name='add-form-nums']").val();
	  if(expenseString=="选择套餐"||numsString.length==0){
		  alert("数据不完整！");
		  return false;
	  }else{
		  $("form[name='add-form-nums']").submit();
	  }
  });
  $("textarea[name='add-form-nums']").blur(function(){
	  var nums=$(this).val();
	  var repeatNum=[];
	  var wrongNum=[];
	  var repeatTemp=[];
	 var numArr=nums.split(",");
	 for(var i=0;i<numArr.length;i++){
		 var num=numArr[i];
		 if(num.length!=11&&num.length!=8){
			 wrongNum.push(num);
		 }else{
			 var result=$.inArray(num,repeatTemp);
			 if(result==-1){
				 repeatTemp.push(num);
			 }else{
				 repeatNum.push(num);
			 }
		 }
	 }
	 if(repeatNum.length>0||wrongNum.length>0){
		 alert("重复号码\n"+repeatNum.join(',')+"\n"+"错误号码\n"+wrongNum.join(','));
	 }
	 
  })
  $("select[name='add-form-operator']").change(function(){
	  $("select[name='add-form-expense']").empty();
	  var operator=$(this).val();
	  $.ajax({
		  type:"post",
		  data:"operator="+operator,
		  url:"https://879515873.jkshuma.com/index.php/AdminGoodNum/get_main_expense",
		  //url:"https://qcy6umy7.qcloud.la/index.php/AdminGoodNum/get_main_expense",
		  success:function(msg){
			 var msg=JSON.parse(msg);
			 var str;
			 for(var i=0;i<msg.length;i++){
				 var exString=JSON.stringify(msg[i]);
				 console.log(exString);
				 str+="<option value='"+exString+"'>"+"套餐"+msg[i]['id']+"</option>";
			 }
			 $("select[name='add-form-expense']").append(str);
			 
		  },
		  error:function(){
			  alert("error");
		  }
	  })
  });
  $("#chinaMobile").click(function(){
	  $("div[name='chinaUnicom']").hide();
	  $("div[name='chinaTelecom']").hide();
	  $("div[name='chinaMobile']").show();
  });
  $("#chinaUnicom").click(function(){
	  $("div[name='chinaUnicom']").show();
	  $("div[name='chinaTelecom']").hide();
	  $("div[name='chinaMobile']").hide();
  });
  $("#chinaTelecom").click(function(){
	  $("div[name='chinaUnicom']").hide();
	  $("div[name='chinaTelecom']").show();
	  $("div[name='chinaMobile']").hide();
  });
});
