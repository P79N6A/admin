<?php defined('IN_IA') or exit('Access Denied');?>	<div class="list_body group_list">
		<div class="list_top">		
		</div>
		<div class="list_table good_list">
<form action="" method="post">
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="col-sm-1">
								<label class="my_checkbox">
								<input class="" type="checkbox" name="" onclick="var ck = this.checked;$('.goodid_check input').each(function(){this.checked = ck});"> 全选/取消
								</label>
							</th>
							<th class="col-sm-2">
								团购商品
							</th>
							<th class="col-sm-1">人数</th>
							<th class="col-sm-2">时间</th>
							<th class="col-sm-1">团状态</th>
							<th class="col-sm-1">操作</th>
						</tr>
					</thead>
					<tbody>
					<?php  if(is_array($groupinfo)) { foreach($groupinfo as $item) { ?>
						<tr>
							<td class="">
								<label class="my_checkbox goodid_check">
									<input type="checkbox" name="checkid[]" value="<?php  echo $item['id'];?>" class=""> <?php  echo $item['id'];?>
								</label>
							</td>
							<td class="">
								<div class="item_cell_box">
									<li class=""><img src="<?php  echo tomedia($item['pic'])?>" width="40px" height="40px;"></li>
									<li class="item_cell_flex">
										<p>商品id ：<?php  echo $item['gid'];?></p>
										<p>
											<a class="a_href" target="_blank" href="<?php  echo $this->createWebUrl('good',array('op'=>'edit','id'=>$item['gid'],'look'=>1))?>" ><?php  echo $item['title'];?></a>
										</p>
									</li>
								</div>
							</td>
							<td class="font_13px_999">
								<li>满团人数：<span class="font_ff5f27"><?php  echo $item['fullnumber'];?></span></li>
								<li>还差人数：<span class="font_ff5f27"><?php  echo $item['lastnumber'];?></span></li>
							</td>
							<td>
								<?php  if($item['status'] == 1 && $item['overtime'] > time()) { ?>
									距离结束: <?php  echo Util::lastTime($item['overtime'],false)?>
								<?php  } else if($item['status'] == 2 || (time() >= $item['overtime']  && $item['status'] == 1)) { ?>
									<p>建团时间： <?php  echo date('Y-m-d H:i:s',$item['createtime'])?></p>
									<p>失败时间： <?php  echo date('Y-m-d H:i:s',$item['overtime'])?></p>
								<?php  } else if($item['status'] == 3 ) { ?>
									<p>建团时间： <?php  echo date('Y-m-d H:i:s',$item['createtime'])?></p>
									<p>完成时间： <?php  echo date('Y-m-d H:i:s',$item['overtime'])?></p>
								<?php  } ?>
							</td>
							<td>

								<?php  if($item['gstatus'] == 1) { ?>
									<span class="font_ff5f27">组团中</span>
								<?php  } else if($item['gstatus'] == 2) { ?>
									<span class="font_13px_999">组团失败</span>
								<?php  } else if($item['gstatus'] == 3 ) { ?>
									<span class="font_green">组团成功</span>
								<?php  } else if($item['gstatus'] == 4 ) { ?>
									<span class="font_13px_999">退款中</span>
								<?php  } ?>
								<?php  if($item['isrefund'] == 2) { ?>
									<p class="font_13px_999">已全部退款</p>
								<?php  } ?>
							</td>
							<td class="opclass">
								<span>
									<a href="<?php  echo $this->createWebUrl('group',array('op'=>'info','id'=>$item['id']))?>" class="a_href" target="_blank">团订单</a>
								</span>
								<?php  if($item['gstatus'] == 2 && $item['isrefund'] == 0) { ?>
								<span><a href="javascript:;" class="a_href group_allrefund" data-id="<?php  echo $item['id'];?>" >全团退款</a></span>
								<?php  } ?>
							</td>
						</tr>
						<?php  } } ?>						
					</tbody>
				</table>		
		</div>		
		<div class="list_bottom item_cell_box good_list good_list_bot">
			<div class="item_cell_flex">
				<label class="">
					<input class="" type="checkbox" name="" onclick="var ck = this.checked;$('.goodid_check input').each(function(){this.checked = ck});"> 全选/取消
				</label>&nbsp;&nbsp;&nbsp;
				<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
			</div>
			<div class=""><?php  echo $pager;?></div>
		</div>
</form>			
	</div>