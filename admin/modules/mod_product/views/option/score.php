<table class="admindata">
    <thead>
        <tr class="head_tb">
            <th style="width: 100px;">STT</th>
            <th width="">Số Điểm</th>
            <th style="width: 150px;">Thời gian chơi</th>
            <th style="width: 200px;">Ngày chơi</th>
        </tr>                
    </thead>
	<?php if($game_score_Items){ ?>
	<tbody>
		<?php $k=1; $i=1; foreach($game_score_Items as $game_score_Item){ ?>
		<tr class="row1">
			<td><?php echo $i;?></td>
			<td><?php echo $game_score_Item->score;?></td>
			<td><?php echo $game_score_Item->timeplay;?></td>
			<td><?php echo $game_score_Item->dt_create;?> </td>
		</tr>
		<?php $k=1-$k;$i++;} ?>
        
        <tr class="row1">
			<td colspan="4">
            <a onclick="return verify_del();" href="<?php echo base_url();?>mod_game/member/deldiem/<?php echo $member_id;?>" title="">
                Xóa tất cả điểm thi <img style="vertical-align: middle;" src="<?php echo base_url()?>templates/icon/del.png"/></a>
            </td>
			
		</tr>
	</tbody>
	<?php }?>
</table>