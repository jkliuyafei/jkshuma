<div class="main-wrap">
	<div class="re-menu-wrap">
		<div class="re-menu-item" id="retail-btn">零售报价</div>
		<div class="re-menu-item" id="cost-btn">成本报价</div>
	</div>
	<div class="content-wrap">
		<div class="add-model-wrap">
		<form action="<?php echo site_url('AdminRepair/add_model')?>" method="post">
		<!-- 选择品牌开始 -->
			<label for="brand">品牌</label> <select name="phoneBrand"
				class="phone-brand" id="phone-brand">
				<option>选择品牌</option>
<?php foreach($allBrand as $brand_item):?>
		<option value="<?php echo $brand_item['brand'];?>"><?php echo $brand_item['brand'];?></option>
		<?php endforeach;?>

	</select>
			<!-- 选择品牌结束 -->
			<!-- 选择型号开始 -->
			<label for="brand">型号</label> <select name="phoneModel"
				class="phone-model" id="phone-model"><option>选择型号</option></select>
			<!-- 选择型号结束 -->
			<input type="submit" id="add-submit" value="增加机型" />
		
		</form>
		</div>
		<div class="table-wrap" id="repair-retail">
		<form action="<?php echo site_url('AdminRepair/update_retail_price')?>" method="post">
			<div class="re-title"><b>零售价</b></div>
			<div class="re-tab-head">
				<div class="re-tab-head-item index">序号</div>
				<div class="re-tab-head-item">品牌</div>
				<div class="re-tab-head-item model">型号</div>
				<div class="re-tab-head-item">外屏(原装)</div>
				<div class="re-tab-head-item">外屏(组装屏)</div>
				<div class="re-tab-head-item">总成(原装后压)</div>
				<div class="re-tab-head-item">总成(组装屏)</div>
				<div class="re-tab-head-item">电池</div>
				<div class="re-tab-head-item">机壳</div>
				<div class="re-tab-head-item">前摄像头</div>
				<div class="re-tab-head-item">后摄像头</div>
				<div class="re-tab-head-item">开机/音量排线</div>
				<div class="re-tab-head-item">听筒/扬声器</div>
				<div class="re-tab-head-item">尾插</div>
				<div class="re-tab-head-item">解锁</div>
			</div>
			<?php foreach ($repair as $repair_item):?>
<div class="tab-row-wrap">
				<div class="tab-row-item index"><?php echo $repair_item['id']?></div>
				<div class="tab-row-item"><?php echo $repair_item['phoneBrand']?></div>
				<div class="tab-row-item model"><?php echo $repair_item['phoneModel']?></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['outsideScreenOriginal']?>" name="<?php echo 'outsideOriginal'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['outsideScreenAssemble']?>" name="<?php echo 'outsideAssemble'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['insideScreenOriginal']?>" name="<?php echo 'insideOriginal'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['insideScreenAssemble']?>" name="<?php echo 'insideAssemble'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['battery']?>" name="<?php echo 'battery'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['phoneShell']?>" name="<?php echo 'phoneShell'.$repair_item['id']?>"></input></div>		
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['frontCamera']?>" name="<?php echo 'frontCam'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['backCamera']?>" name="<?php echo 'backCam'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['phoneWinding']?>" name="<?php echo 'phoneWinding'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['speaker']?>" name="<?php echo 'speaker'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['tailePlug']?>" name="<?php echo 'tailePlug'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['phoneUnclock']?>" name="<?php echo 'phoneUnclock'.$repair_item['id']?>"></input></div>
</div>
			
<?php endforeach;?>
<input type="submit" value="更新价格"></input>			
</form>
		</div>
		<div class="table-wrap">
		<form action="<?php echo site_url('AdminRepair/update_cost_price')?>" method="post">
			<div class="re-title"><b>成本价</b></div>
			<div class="re-tab-head">
				<div class="re-tab-head-item index">序号</div>
				<div class="re-tab-head-item">品牌</div>
				<div class="re-tab-head-item model">型号</div>
				<div class="re-tab-head-item">外屏(原装)</div>
				<div class="re-tab-head-item">外屏(组装屏)</div>
				<div class="re-tab-head-item">总成(原装后压)</div>
				<div class="re-tab-head-item">总成(组装屏)</div>
				<div class="re-tab-head-item">电池</div>
				<div class="re-tab-head-item">机壳</div>
				<div class="re-tab-head-item">前摄像头</div>
				<div class="re-tab-head-item">后摄像头</div>
				<div class="re-tab-head-item">开机/音量排线</div>
				<div class="re-tab-head-item">听筒/扬声器</div>
				<div class="re-tab-head-item">尾插</div>
				<div class="re-tab-head-item">解锁</div>
			</div>
			<?php foreach ($c_repair as $repair_item):?>
<div class="tab-row-wrap" id="repair-cost">
				<div class="tab-row-item index"><?php echo $repair_item['id']?></div>
				<div class="tab-row-item"><?php echo $repair_item['phoneBrand']?></div>
				<div class="tab-row-item model"><?php echo $repair_item['phoneModel']?></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['outsideScreenOriginal']?>" name="<?php echo 'outsideOriginal'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['outsideScreenAssemble']?>" name="<?php echo 'outsideAssemble'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['insideScreenOriginal']?>" name="<?php echo 'insideOriginal'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['insideScreenAssemble']?>" name="<?php echo 'insideAssemble'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['battery']?>" name="<?php echo 'battery'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['phoneShell']?>" name="<?php echo 'phoneShell'.$repair_item['id']?>"></input></div>		
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['frontCamera']?>" name="<?php echo 'frontCam'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['backCamera']?>" name="<?php echo 'backCam'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['phoneWinding']?>" name="<?php echo 'phoneWinding'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['speaker']?>" name="<?php echo 'speaker'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['tailePlug']?>" name="<?php echo 'tailePlug'.$repair_item['id']?>"></input></div>
				<div class="tab-row-item"><input type="text" placeholder="<?php echo $repair_item['phoneUnclock']?>" name="<?php echo 'phoneUnclock'.$repair_item['id']?>"></input></div>
</div>
			
<?php endforeach;?>
<input type="submit" value="更新价格"></input>			
</form>
		
		</div>

	</div>
</div>