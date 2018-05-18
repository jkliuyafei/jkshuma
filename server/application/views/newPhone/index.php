<div class="new-phone-wrap">
<form action="<?php echo site_url('AdminNewPhone/update_price')?>" method="post">
<div class="new-phone-content">
<?php foreach ($newPhone as $newPhone_item):?>
<div class="brand-content-item">
				<div class="phone-brand-table"><?php echo $newPhone_item['brand'];?></div>
				<div class="model-content">
	<?php foreach ($newPhone_item['exceptBrand'] as $model_item):?>
	<div class="model-content-item">
						<div class="phone-model-table"><?php echo $model_item['model']?></div>
						<div class="volume-content">
					<?php foreach ($model_item['exceptModel'] as $volume_item):?>
					<div class="volume-content-item">
								<div class="phone-volume-table"><?php echo $volume_item['volume'];?></div>
								<div class="other-content">
					<?php foreach ($volume_item['other'] as $other_item):?>
					<div class="other-content-item">
										<div class="other-table"><?php echo $other_item['color']?></div>
										<div class="other-table">
											<input type="text" class="price-input"
												name="<?php echo $other_item['phoneId']?>"
												placeholder="<?php echo $other_item['price']?>" />
										</div>
										<div class="other-table"><?php echo $other_item['phoneId']?></div>
									</div>
					
					<?php endforeach;?>
					
					</div>

							</div>
					<?php endforeach;?>
					</div>

					</div>
	<?php endforeach;?>
	
	</div>
			</div>
<?php endforeach;?>
</div>
		<input type="submit" value="更新价格"></input>
		</form>
	</div>

	<div class="phone-handle">
		<div class="handle-item-title">价格修改</div>
		<div class="handle-item-wrap">

<form action="<?php echo site_url('AdminNewPhone/handle_price')?>" id="handle-price-form" method="post">
		<div class="change-price-wrap">
				为&nbsp <select name="priceBrand" id="price-handle-brand">
					<option>选择品牌</option>
<?php foreach ($priceBrand as $brand_item):?>
		<option value="<?php echo $brand_item['phoneBrand']?>"><?php echo $brand_item['phoneBrand']?></option>
		<?php endforeach;?>
</select> &nbsp增加&nbsp<input type="text" name="priceOffset" id="price-handle-offset" />&nbsp元
				&nbsp&nbsp&nbsp <input type="submit" id="price-handle-submit"
					value="批量修改" />
			</div>
			</form>
		</div>
		<div style="height: 10px;"></div>
		<div class="handle-item-title">增加机型</div>
		<div class="handle-item-wrap">

<form action="<?php echo site_url('AdminNewPhone/add_phone')?>" id="add-phone-form" method="post">
			<div class="brand-wrap">
				<div class="property-option">
					<label for="brand">品牌</label> <select name="phoneBrand"
						id="phone-brand"><option>选择品牌</option>
					<?php foreach($allBrand as $brand_item):?>
		<option value="<?php echo $brand_item['brand'];?>"><?php echo $brand_item['brand'];?></option>
		<?php endforeach;?>	
					</select>
				</div>
				<div class="property-option">
					<label for="brand">型号</label> <select name="phoneModel"
						class="phone-model" id="phone-model"><option>选择型号</option></select>
				</div>
				<div class="property-option">
					<label for="volume">容量</label> <select name="phoneVolume" id="phone-volume">
						<option>选择容量</option>
		<?php foreach ($phoneVolume as $volume_item):?>
		<option value="<?php echo $volume_item['volume']?>"><?php echo $volume_item['volume']?></option>
		<?php endforeach;?>
		</select>
				</div>
			</div>
			<div class="color">
				<label>颜色：</label>
			</div>
			<div class="color-wrap">
			<?php foreach ($phoneColor as $color_item):?>
			<div class="color-checkbox">
					<input type="checkbox" name="phoneColor[]"
						value="<?php echo $color_item['color'];?>" /><?php echo $color_item['color'];?>
			</div>
			<?php endforeach;?>
			</div>
			<input type="submit" id="add-submit" value="增加机型" />
			</form>
		</div>
		<div
			style="width: 100%; height: 1px; border-bottom: 1px solid #dfdede;"></div>

	</div>
