<thead>
	<tr>
		<th class="title-table-order" colspan="3" style="font-size: 23px;
color: green;padding: 20px;">Lịch sử đặt hàng</th>
	</tr>
	<tr>
		<th>Số thứ tự</th>
		<th>Thời gian</th>
		<th>Sản phẩm</th>
		<th width="20%">Ghi chú</th>
		<th>Giá cả</th>
	</tr>
</thead>
<tbody>
	<?php if($order['orders'] == null) {?>
	<tr>
		<td>Bạn chưa có sản phẩm nào</td>
	</tr>
	<?php }else { ?>
	<?php $d = 0;foreach ($order['orders'] as $key => $value) {
	?>

	<tr>
		<td><?php $d = (int) $d + 1; echo $d?></td>
		<td><?php echo $value->order_date ?></td>
		<td><?php echo $value->product ?></td>
		<td><?php echo $value->giavi ?></td>
		<td><?php echo number_format($value->price, 0, ',', '.'); ?> ₫</td>
	</tr>
	<?php }?>
	<?php }?>
</tbody>
