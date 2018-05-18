
<div class="add-item">
<?php
$this->load->library('form_validation');
echo validation_errors();
?>
<?php echo form_open('AdminAddVolume/add_iphoneModel'); ?>

<label for="model">苹果型号</label> <select name="phoneModel">
<?php foreach($iphoneModel as $iphoneModel_item):?>
		<option value="<?php echo $iphoneModel_item['model'];?>"><?php echo $iphoneModel_item['model'];?></option>
		<?php endforeach;?>

	</select> <label for="g32">32G</label> <input type="text" name="g32"></input>
	<label for="g64">64G</label> <input type="text" name="g64"></input> <label
		for="g128">128G</label> <input type="text" name="g128"></input> <label
		for="g256">256G</label> <input type="text" name="g256"></input> <input
		type="submit" name="submit" value="增加条目" />
	</form>
</div>
<div class="add-volume-wrap">
<?php echo form_open('AdminAddVolume/update_price'); ?>
	<table>
		<tr>
			<th>序号</th>
			<th>型号</th>
			<th>32G</th>
			<th>64G</th>
			<th>128G</th>
			<th>256G</th>
		</tr>
	
<?php foreach ($addVolume as $addVolume_item):?>
<tr>
			<td><?php echo $addVolume_item['id']?></td>
			<td><?php echo $addVolume_item['model']?></td>
			<td><input type="text" placeholder="<?php echo $addVolume_item['volume32']?>" name="<?php echo 'g32'.$addVolume_item['id'];?>"></input></td>
			<td><input type="text" placeholder="<?php echo $addVolume_item['volume64']?>" name="<?php echo 'g64'.$addVolume_item['id'];?>"></input></td>
			<td><input type="text" placeholder="<?php echo $addVolume_item['volume128']?>" name="<?php echo 'g128'.$addVolume_item['id'];?>"></input></td>
			<td><input type="text" placeholder="<?php echo $addVolume_item['volume256']?>" name="<?php echo 'g256'.$addVolume_item['id'];?>"></input></td>
			


		</tr>
<?php endforeach;?>

</table>
<input type="submit" value="更新报价"></input>
</form>
</div>