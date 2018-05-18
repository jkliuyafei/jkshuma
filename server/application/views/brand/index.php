<div class="container">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<form class="form-inline" role="form" action="<?php echo site_url('AdminHome/add_brand')?>" method="post" name="add_brand">
				<div class="form-group">
					<label class="sr-only" for="brand">品牌</label> <input type="text"
						class="form-control" name="brand" placeholder="输入品牌">
				</div>
				<div class="form-group">
					<label class="sr-only" for="brandId">品牌id</label><input type="text"
						class="form-control" name="brandId" placeholder="输入品牌id">
				</div>
				<button type="submit" class="btn btn-default" id="btn-submit-brand">提交</button>

			</form>

		</div>
	</div>
</div>
<div style="width: 100%;height:30px;"></div>
<div class="container">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>序号</th>
						<th>品牌</th>
						<th>品牌id</th>
						<th>品牌index</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($brand as $brand_item):?>
<tr>
						<td><?php echo $brand_item['id']?></td>
						<td><?php echo $brand_item['brand']?></td>
						<td><?php echo $brand_item['brandId']?></td>
						<td><?php echo $brand_item['brandIndex']?></td>
					</tr>
<?php endforeach;?>
				
				
				</tbody>
			</table>

		</div>
	</div>
</div>