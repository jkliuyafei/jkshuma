<div class="container">
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			<form class="form-inline" role="form" name="add_model_form"
				action="<?php echo site_url('AdminModel/add_model')?>" method="post">
				<div class="radiobox form-group">
					<label> <input type="radio" name="newOrOld" value="1" checked>新款
					</label>
				</div>
				<div class="radiobox form-group" style="padding-left: 10px;">
					<label> <input type="radio" name="newOrOld" value="0">老款
					</label>
				</div>
				<div class="form-group" style="padding-left: 15px;">
					<label>选择品牌</label> <select class="form-control" name="phoneBrand">
				<?php foreach($allBrand as $brand_item):?>
		<option value="<?php echo $brand_item['brand'];?>"><?php echo $brand_item['brand'];?></option>
		<?php endforeach;?>
				</select>
				</div>
				<div class="form-group" style="padding-left: 10px;">
					<label>型号</label><input type="text" name="model" class="form-control">
				</div>
				<button type="submit" name="add_model" class="btn btn-default">添加</button>

			</form>
		</div>
	</div>


</div>
<div style="width: 100%;height:30px;"></div>
<div class="container">
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>序号</th>
						<th>品牌</th>
						<th>型号</th>
						<th>型号顺序</th>
						<th>型号状态</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($model as $model_item):?>
				
				<tr class="<?php if ($model_item['modelStatus']==0) {
				    echo "danger";
				}?>">

						<td><?php echo $model_item['id']?></td>
						<td><?php echo $model_item['brand']?></td>
						<td><?php echo $model_item['model']?></td>
						<td><?php echo $model_item['modelOrder']?></td>
						<td><?php
        
        if ($model_item['modelStatus'] == 1) {
            echo "在售";
        } else {
            echo "已下线";
        }
        ?></td>
						<td><button class="handle-btn" name="handle_model" 
								data-id="<?php echo $model_item['id']?>"><?php
        
        if ($model_item['modelStatus'] == 1) {
            echo "↓↓↓";
        } else {
            echo "↑↑↑";
        }
        ?></button></td>

					</tr>
<?php endforeach;?>
				
				
				</tbody>
			</table>
		</div>
	</div>
</div>