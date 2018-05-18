

<?php
$this->load->library('form_validation');
echo validation_errors();
?>
<div class="all-content">
	<div class="left-menu">
		<div class="menu-btn">型号颜色容量</div>
		<div class="menu-btn">供应商管理</div>
		<div class="menu-btn">分享管理</div>
	</div>
	<div class="right-content">
		<div class="model-color-volume">

			<div class="add-info">
		<?php
$attributes = array(
    'id' => 'add-info-form'
);
echo form_open('AdminOther/add_info', $attributes);
?>
		<label for="brand">品牌</label> <select name="brand" id="phone-brand">
					<option>选择品牌</option>
		<?php foreach ($brand as $brand_item):?>
		<option value="<?php echo $brand_item['brand'];?>"><?php echo $brand_item['brand'];?></option>
		<?php endforeach;?>
		</select> <label for="model">型号</label> <select name="model"
					id="phone-model">
				</select>
				
  				<?php foreach ($volume as $volume_item):?>
  				<input type="checkbox" name="volume[]" value="<?php echo $volume_item['volume']?>" /><?php echo $volume_item['volume']?>
  				<?php endforeach;?>
				<?php foreach ($color as $color_item):?>
				<input type="checkbox" name="color[]" value="<?php echo $color_item['color']?>" /><?php echo $color_item['color']?>
				<?php endforeach;?>
	
		<input type="submit" id="submit-info" value="提交">
				</form>
			</div>
			<div class="model-info">
				<div class="model-info-item">
				<table>
						<tr>
							<th>型号</th>
							<th>容量</th>
						</tr>
						<?php foreach ($modelVolume as $volume_item):?>
						<tr>
							<td rowspan="<?php echo $volume_item['rowspan']?>"><?php echo $volume_item['model']?></td>
							<td><?php echo $volume_item['modelVolumeArr'][0]['modelVolume']?></td>
						</tr>
						<?php
        $modelVolumeArr = $volume_item['modelVolumeArr'];
        for ($i = 1; $i < sizeof($modelVolumeArr); $i ++){?>
        <tr><td><?php echo $modelVolumeArr[$i]['modelVolume'];}?></td></tr>
						<?php endforeach;?>
					</table>
				</div>
				<div class="model-info-item">
					<table>
						<tr>
							<th>型号</th>
							<th>颜色</th>
						</tr>
						<?php foreach ($modelColor as $color_item):?>
						<tr>
							<td rowspan="<?php echo $color_item['rowspan']?>"><?php echo $color_item['model']?></td>
							<td><?php echo $color_item['modelColorArr'][0]['modelColor']?></td>
						</tr>
						<?php
        $modelColorArr = $color_item['modelColorArr'];
        for ($i = 1; $i < sizeof($modelColorArr); $i ++){?>
        <tr><td><?php echo $modelColorArr[$i]['modelColor'];}?></td></tr>
						<?php endforeach;?>
					</table>
				</div>
			</div>

		</div>
		<div class="tenant" hidden="true">
			<div class="add-tenant">
			<?php echo form_open('AdminOther/add_tenant'); ?>
			<label for="shopName">店名</label> <input type="text" name="shopName"></input>
				<label for="leadershipName">负责人</label> <input type="text"
					name="leadershipName"></input> <label for="phoneNum1">电话1</label> <input
					type="text" name="phoneNum1"></input> <label for="phoneNum2">电话2</label>
				<input type="text" name="phoneNum2"></input> <select
					name="tenantType">
					<option value="1" selected>靓号供应商</option>
					<option value="2" selected>新机批发商</option>
					<option value="3" selected>二手机供应商</option>
				</select> <input type="submit" name="submit" value="增加供应商">
				</form>
			</div>
			<div class="tenant-content">
				<table>
					<tr>
						<th>序号</th>
						<th>店名</th>
						<th>负责人</th>
						<th>电话1</th>
						<th>电话2</th>
						<th>供应商类型</th>
					</tr>
			<?php foreach ($tenant as $tenant_item):?>
			<tr>

						<td><?php echo $tenant_item['id']?></td>
						<td><?php echo $tenant_item['shopName']?></td>
						<td><?php echo $tenant_item['leadershipName']?></td>
						<td><?php echo $tenant_item['phoneNumber1']?></td>
						<td><?php echo $tenant_item['phoneNumber2']?></td>
						<td><?php echo $tenant_item['tenantType']?></td>

					</tr>
			<?php endforeach;?>
			</table>

				1.靓号供应商 2.新机批发商 3.二手机供应商

			</div>
		</div>
		<div class="share"></div>
	</div>
</div>