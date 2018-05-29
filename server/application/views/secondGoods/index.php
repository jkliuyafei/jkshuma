<div class="container">
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
		<form action="<?php echo site_url('AdminSecondGoods/update_price')?>" method="post">
			<table class="table table-bordered">
				<thead>
					<tr>
						<td>序号</td>
						<td>品牌</td>
						<td>型号</td>
						<td>容量</td>
						<td>颜色</td>
						<td>串号</td>
						<td>价格</td>
						<td>商品状态</td>
						<td>操作</td>
					</tr>
				</thead>
				<tbody>
<?php foreach ($secondGoods as $secondGoods_item):?>
<tr>
						<td><?php echo $secondGoods_item['id']?></td>
						<td><?php echo $secondGoods_item['goodsBrand']?></td>
						<td><?php echo $secondGoods_item['goodsModel']?></td>
						<td><?php echo $secondGoods_item['goodsVolume']?></td>
						<td><?php echo $secondGoods_item['goodsColor']?></td>
						<td><?php echo $secondGoods_item['goodsImei']?></td>
						<td><input style="border:none;width:100%;height:100%;text-align:center;" type="text" name="<?php echo $secondGoods_item['id']?>"
							placeholder="<?php echo $secondGoods_item['goodsPrice']?>"></input></td>
						<td><?php
    
    if ($secondGoods_item['goodsStatus'] == 1) {
        echo "在库";
    } else {
        echo "已卖出";
    }
    ?></td>
						<td><div class="handle-btn"
								data-id="<?php echo $secondGoods_item['id']?>"><?php
    
    if ($secondGoods_item['goodsStatus'] == 1) {
        echo "下架";
    }
    ?></div></td>

					</tr>
<?php endforeach;?>
				</tbody>
			</table>
			<input type="submit" value="更新价格"></input>
			</form>
		</div>
	</div>


</div>