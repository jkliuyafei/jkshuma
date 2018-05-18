<div class="main-body">
	<div class="num-wrap">
	<?php foreach ($numArr as $numArr_item):?>
	<div class="operators-name"><?php echo $numArr_item['operatorsName'];?></div>
		<div class="num-detail-wrap">
			<table class="table table-bordered">
				<thead>
					<tr>
						<td>号码</td>
						<td>归属地</td>
						<td>售价</td>
						<td>成本</td>
						<td>类型</td>
						<td>资费</td>
						<td>供应商</td>
						<td>联系人</td>
						<td>电话</td>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($numArr_item['numDetail'] as $numDetail_item):?>
				<tr>
						<td><?php echo $numDetail_item['phoneNumber']?></td>
						<td><?php echo $numDetail_item['qCellCore']?></td>
						<td><?php echo $numDetail_item['price']?></td>
						<td><?php echo $numDetail_item['costPrice']?></td>
						<td><?php echo $numDetail_item['price']?></td>
						<td><?php echo $numDetail_item['expensesDetail']?></td>
						<?php
        
        $tenantIndex = $numDetail_item['tenant'];
        foreach ($numTenant as $numTenant_item) {
            if ($numTenant_item['id'] == $tenantIndex) {
                ?>
		        <td><?php echo $numTenant_item['shopName']?></td>
						<td><?php echo $numTenant_item['leadershipName']?></td>
						<td><?php echo $numTenant_item['phoneNumber1']?></td>
		        <?php
            }
        }
        ?>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>

		</div>
	<?php endforeach;?>
	</div>

	<div class="num-main-exe-wrap">
		<div class="operator-name-wrap">
			<div class="operator-name" id="chinaMobile">中国移动</div>
			<div class="operator-name" id="chinaUnicom">中国联通</div>
			<div class="operator-name" id="chinaTelecom">中国电信</div>
		</div>
<?php foreach ($exeDetail as $exeDetail_item):?>
		<div class="exe-wrap" name="<?php echo $exeDetail_item['operatorId'];?>">
			<div class="exe-title"><?php echo $exeDetail_item['operatorName']."&nbsp&nbsp"."套餐".$exeDetail_item['index'];?></div>
			<div class="exe-detail"><?php echo $exeDetail_item['detail'];?></div>
		</div>
<?php endforeach;?>
	</div>

	<div class="num-handle-wrap">
		<div class="num-handle-title">录入号码</div>
		<div class="num-handle-item-wrap">
			<form class="form" role="form" method="post" name="addnum-form"
				action="<?php echo site_url('AdminGoodNum/add_num')?>">
				<div class="add-form-info-wrap">
					<div class="add-form-info-item">
						<select name="add-form-operator" class="my-select">
							<option>运营商</option>
							<option value="chinaMobile">中国移动</option>
							<option value="chinaUnicom">中国联通</option>
							<option value="chinaTelecom">中国电信</option>
						</select>
					</div>
					<div class="add-form-info-item">
						<select name="add-form-expense" class="my-select">
							<option>选择套餐</option>
						</select>
					</div>

				</div>
				<div style="width: 100%; height: 15px;"></div>
				<div class="form-group">
					<label>号码集合</label>
					<textarea class="form-control" rows="5" name="add-form-nums"
						placeholder='请输入号码，号码之间用英文逗号","分隔，而非中文逗号。'></textarea>
				</div>
				<button id="add-form-submit" class="btn btn-default">录入号码</button>
			</form>

		</div>
		<div style="width: 100%; height: 15px;"></div>
		<div class="num-handle-title">添加套餐</div>
		<div class="num-handle-item-wrap">
			<form class="form" role="form" method="post" name="expen-form"
				action="<?php echo site_url('AdminGoodNum/add_expense')?>">
				<div class="tenant-qcell-operator">
					<div class="select-item-wrap">
						<select name="expen-form-tenant" class="my-select">
							<option>供应商</option>
<?php foreach ($numTenant as $numTenant_item):?>
<option value="<?php echo $numTenant_item['id']?>"><?php echo $numTenant_item['shopName']; ?></option>
<?php endforeach;?>
</select>
					</div>
					<div class="select-item-wrap">
						<select name="expen-form-operator" class="my-select">
							<option>运营商</option>
							<option value="chinaMobile">中国移动</option>
							<option value="chinaUnicom">中国联通</option>
							<option value="chinaTelecom">中国电信</option>

						</select>
					</div>
					<div class="select-item-wrap">
						<select name="expen-form-qCellCore" class="my-select">
							<option>归属地</option>
						<?php foreach ($city as $city_item):?>
						<option value="<?php echo $city_item['city']?>"><?php echo $city_item['city']?></option>
						<?php endforeach;?>
					</select>
					</div>
				</div>
				<div style="width: 100%; height: 15px;"></div>
				<div class="form-group" style="display: flex;">
					<label for="expenses-form-price" style="width: 25%">成本价</label> <input
						type="text" style="width: 75%" class="form-control"
						placeholder="输入成本价" name="expen-form-costprice" />
				</div>
				<div class="form-group" style="display: flex;">
					<label for="expenses-form-costprice" style="width: 25%">售价</label>
					<input style="width: 75%" class="form-control" type="text"
						placeholder="输入售价" name="expen-form-price" />
				</div>
				<div class="form-group" style="display: flex;">
					<label for="expenses-form-type" style="width: 25%">类型</label> <input
						style="width: 75%" class="form-control" placeholder="类型。如:ABAB"
						name="expen-form-type" />
				</div>
				<div class="form-group">
					<label class="control-label">资费详情</label>
					<textarea class="form-control" rows="5" name="expen-form-detail"></textarea>
				</div>
				<button id="expen-form-submit" class="btn btn-default">添加套餐</button>
			</form>
		</div>
	</div>
</div>