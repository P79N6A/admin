<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
	.order_detail .fui-list-inner .title.has-address {
		font-size: .7rem;
		line-height: 1.2rem;
		height: 1.2rem;
		display: block;
	}
	.order_detail .fui-list-inner .text{
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
	}
	.order_detail .fui-list:before{
		border: 0;
	}
	.order_detail .fui-list_title{
		position: relative;
		display: flex;
		align-items: center;
		line-height: normal;
	}
	/*.order_detail .fui-list_title:before{*/
		/*content: " ";*/
		/*position: absolute;*/
		/*left: 0.5rem;*/
		/*right: 0.5rem;*/
		/*bottom: 0;*/
		/*height: 1px;*/
		/*border-top: 1px solid #ebebeb;*/
		/*color: #D9D9D9;*/
		/*-webkit-transform-origin: 0 0;*/
		/*-ms-transform-origin: 0 0;*/
		/*transform-origin: 0 0;*/
		/*-webkit-transform: scaleY(0.5);*/
		/*-ms-transform: scaleY(0.5);*/
		/*transform: scaleY(0.5);*/
	/*}*/
	.order_detail  .lineblock {
		position: relative;
		overflow: hidden;
	}

	.order_detail  .lineblock:before {
		content: "";
		position: absolute;
		left: .5rem;
		top: 0;
		right: .5rem;
		height: 1px;
		border-top: 1px solid #ebebeb;
		-webkit-transform-origin: 0 100%;
		-ms-transform-origin: 0 100%;
		transform-origin: 0 100%;
		-webkit-transform: scaleY(0.5);
		-ms-transform: scaleY(0.5);
		transform: scaleY(0.5);
	}
</style>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/mobile/default/static/css/orderdetail.css?v=2.0.0">

	<div class="fui-page cav order_detail">

		<div class="fui-header">
			<div class="fui-header-left">
				<a class="back" id="btn-back"></a>
			</div>
			<div class="title">
				订单详情
			</div>
			<div class="fui-header-right"></div>
		</div>

		<div class="fui-content navbar">

			<!--状态-->
			<div class="order_detail_header">
				<div class="order_detail_ststus">
					<div style="font-size: 0.85rem;">
						<?php  if(empty($order['status'])) { ?>
							<?php  if($order['paytype']==3) { ?>
								货到付款，等待发货
							<?php  } else { ?>
								等待付款
							<?php  } ?>
						<?php  } else if($order['status']==1) { ?>
							<?php  if($order['sendtype']>0) { ?>
								部分商品已发货
							<?php  } else { ?>
								买家已付款
							<?php  } ?>
							<?php  if(!empty($order['ccard'])) { ?>
								(充值中)
							<?php  } ?>
						<?php  } else if($order['status']==2) { ?>
							卖家已发货
						<?php  } else if($order['status']==3) { ?>
							交易完成
							<?php  if(!empty($order['ccard'])) { ?>
								(充值完成)
							<?php  } ?>
						<?php  } else if($order['status']==-1) { ?>
							交易关闭
						<?php  } else if($order['status'] == -2) { ?>
							会员申请被驳回
						<?php  } ?>

						<?php  if($order['refundstate'] > 0) { ?>
							(<?php  if($order['status'] ==1) { ?>申请退款<?php  } else { ?>申请售后<?php  } ?>中)
						<?php  } ?>
					</div>
					<div>订单金额：<?php  if($order['ispackage']) { ?>(套餐总价)<?php  } ?>
						&yen; <?php  echo $order['goodsprice'];?></div>
				</div>
			</div>

			<?php  if($order['canverify']&&$order['status']!=-1&&$order['status']!=0) { ?>
				<div class="code_box">
					<div class="img_box order_detail_code">
						<img  src="<?php  echo $qrcodeimg;?>" alt="">
					</div>
					<div class="cav_code"><?php  echo $verifycode;?></div>
				</div>
			<?php  } ?>

			<?php  if(!empty($address)) { ?>
				<div class="fui-list-group noborder" style="display: block;">

					<?php  if(!empty($order['isnewstore'])) { ?>
						<?php  if(!empty($order['expresssn'])) { ?>
							<div class="fui-list" style="background: #fff;">
								<div class="fui-list-icon">
									<i class="icon icon-deliver" style="color: #ff5555;"></i>
								</div>
								<div class="fui-list-inner" style="font-size: 0.7rem;height: auto;line-height: 1.5rem;">
									<p style='color:#ff5555'><?php  echo $order['expresssn'];?></p>
								</div>
								<div class="fui-list-angle"><span class="angle"></span></div>
							</div>
						<?php  } ?>
					<?php  } else { ?>
						<?php  if($order['status'] > 1 && $order['sendtype']==0) { ?>
						<a class="fui-list" style="background: #fff;" href="<?php  echo mobileUrl('order/express',array('id'=>$order['id']))?>">
							<div class="fui-list-icon">
								<i class="icon icon-deliver" style="color: #ff5555;"></i>
							</div>
							<div class="fui-list-inner" style="font-size: 0.7rem;height: auto;line-height: 1.2rem;">
								<?php  if(empty($express)) { ?>
								<p style='color:#ff5555'>快递公司:<?php  echo $order['expresscom'];?></p>
								<p style='color:#999'>快递单号:<?php  echo $order['expresssn'];?></p>
								<?php  } else { ?>
								<p style='color:#ff5555'><?php  echo $express['step'];?></p>
								<p style='color:#999'><?php  echo $express['time'];?></p>
								<?php  } ?>
							</div>
							<div class="fui-list-angle"><span class="angle"></span></div>
						</a>
						<?php  } ?>

						<?php  if($order['status'] > 0 && $order['sendtype']>0 && $order_goods) { ?>
							<?php  if(is_array($order_goods)) { foreach($order_goods as $index => $sg) { ?>
								<a class="fui-list" style="background: #fff;" href="<?php  echo mobileUrl('order/express',array('id'=>$sg['orderid'],'sendtype'=>$sg['sendtype'],'bundle'=>chr($index+65)))?>">
									<div class="fui-list-icon">
										<i class="icon icon-deliver" style="color: #ff5555;"></i>
									</div>
									<div class="fui-list-inner" style="font-size: 0.7rem;height: auto;line-height: 1.2rem;">
										<?php  if(empty($express)) { ?>
										<p style='color:#ff5555'>快递公司:<?php  if($sg['expresscom']) { ?><?php  echo $sg['expresscom'];?><?php  } else { ?>其他快递<?php  } ?></p>
										<p style='color:#999'>快递单号:<?php  echo $sg['expresssn'];?></p>
										<?php  } else { ?>
										<p style='color:#ff5555'><?php  echo $express['step'];?></p>
										<p style='color:#999'><?php  echo $express['time'];?></p>
										<?php  } ?>
									</div>
									<div class="fui-list-angle"><span class="angle"></span></div>
								</a>
							<?php  } } ?>
						<?php  } ?>
					<?php  } ?>
					<div class="fui-list" style="background: #fff;    padding-top: .8rem;
    padding-bottom: .83rem;">
						<div class="fui-list-icon">
							<i class="icon icon-dingwei"></i>
						</div>
						<div class="fui-list-inner" style="font-size: 0.7rem;height: auto;">
							<div class="title has-address"><?php  echo $address['realname'];?> <?php  echo $address['mobile'];?></div>
							<!--<p><?php  echo $address['realname'];?> <?php  echo $address['mobile'];?></p>-->
							<div class="text"><span class='address'><?php  echo $address['province'];?><?php  echo $address['city'];?><?php  echo $address['area'];?><?php  if(!empty($new_area) && !empty($address_street)) { ?> <?php  echo $address['street'];?><?php  } ?> <?php  echo $address['address'];?></span></div>
							<!--<p><?php  echo $address['province'];?><?php  echo $address['city'];?><?php  echo $address['area'];?><?php  if(!empty($new_area) && !empty($address_street)) { ?> <?php  echo $address['street'];?><?php  } ?> <?php  echo $address['address'];?></p>-->
						</div>
					</div>
				</div>
			<?php  } ?>





			<!--商品信息-->
			<div class="fui-list-group">
				<?php  if(empty($order['isnewstore'])) { ?>
				<div class="fui-list_title"><i class="icon icon-dianpu1" style="margin-right: 0.25rem;"></i><?php  echo $shopname;?></div>
				<?php  } ?>

				<?php  $i=0;?>
				<?php  if(is_array($goods)) { foreach($goods as $g) { ?>
					<a class="fui-list" href="<?php  if(empty($order['isnewstore'])) { ?><?php  echo mobileUrl('goods/detail',array('id'=>$g['goodsid']))?><?php  } else { ?><?php  echo mobileUrl('newstore/goods/detail',array('id'=>$g['goodsid'],'storeid'=>$order['storeid']))?><?php  } ?>">
						<div class="fui-list-media">
							<img src="<?php  echo tomedia($g['thumb'])?>"/>
						</div>
						<div class="fui-list-inner">
							<div class="title"><?php  if($g['seckill_task']) { ?><span class="fui-label fui-label-danger"><?php  echo $g['seckill_task']['tag'];?></span><?php  } ?><?php  echo $g['title'];?></div>
							<?php  if(!empty($g['optionid'])) { ?><div class="subtitle"><?php  echo $g['optiontitle'];?></div><?php  } ?>
							<?php  if($g['status']==2) { ?>
							<div class="subtitle">
								<label class="fui-label fui-label-danger">赠品</label>
							</div>
							<?php  } ?>
						</div>
						<div class="fui-list-angle" style="margin-right: 0">
							<div style="color: #000">￥<?php  echo $g['price'];?></div>
							<div class="num">x<?php  echo $g['total'];?></div>
						</div>
					</a>
					<?php  if(!empty($g['fullbackgoods'])) { ?>
						<div class="fui-cell-group" <?php  if($g['fullbackgoods']['minallfullbackallprice']<=0 && $g['fullbackgoods']['minallfullbackallratio']<=0) { ?>display: none;<?php  } ?>>
							<a href="<?php  echo mobileUrl('member/fullback')?>"  class="fui-cell">
								<div class="fui-cell-label">全返详情</div>
								<div class="fui-cell-info">

								</div>
								<div class="fui-cell-remark">
									<i class="icon icon-rechargefill" style="color: #ff6462;"></i>
									<?php  if($g['fullbackgoods']['type']>0) { ?>
										全返  <?php  echo price_format($g['fullbackgoods']['minallfullbackallratio'],2)?>%  ， <?php  echo price_format($g['fullbackgoods']['fullbackratio'],2)?>% /天，共  <?php  echo $g['fullbackgoods']['day'];?>  天
									<?php  } else { ?>
										全返 &yen;<?php  echo price_format($g['fullbackgoods']['minallfullbackallprice'],2)?>，&yen;<?php  echo price_format($g['fullbackgoods']['fullbackprice'],2)?>/天，共 <?php  echo $g['fullbackgoods']['day'];?> 天
									<?php  } ?>
								</div>
							</a>
						</div>
					<?php  } ?>

					<?php  if(!empty($g['diyformdata']) && $g['diyformdata'] != 'false') { ?>
						<div class="fui-cell-group noborder">
							<?php  $datas = $g['diyformdata']?>
							<?php  if(is_array($g['diyformfields'])) { foreach($g['diyformfields'] as $key => $value) { ?>
							<div class="fui-cell">
								<div class="fui-cell-label"><?php  echo $value['tp_name']?></div>
								<div class="fui-cell-info">

								</div>
								<div class="fui-cell-remark noremark">
									<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('diyform/mdiyform', TEMPLATE_INCLUDEPATH)) : (include template('diyform/mdiyform', TEMPLATE_INCLUDEPATH));?>
								</div>
							</div>
							<?php  } } ?>
						</div>
					<?php  } ?>
				<?php  $i++;?>
			<?php  } } ?>
		</div>
		<!--门店-->
		<?php  if(empty($order['isnewstore'])) { ?>
		<?php  if(!empty($stores)) { ?>
		<div class="fui-according-group">
			<div class="fui-according expanded">
				<div class="fui-according-header">
					<span class="text">适用门店</span>
							<span class="remark">
								<span class="badge"><?php  echo count($stores)?></span>
							</span>
				</div>
				<div class="fui-according-content">
					<div class="content-block">
						<div class="fui-cell-group notop store-container">
							<?php  if(is_array($stores)) { foreach($stores as $item) { ?>
							<a href="<?php  echo mobileUrl('store/detail',array('id'=>$item['id']))?>" class="fui-cell">
								<div class="fui-cell-icon">
									<i class="icon icon-locationfill"></i>
								</div>
								<div class="fui-cell-info">
									<?php  echo $item['storename'];?>
								</div>
								<div class="fui-cell-remark">
									查看
								</div>
							</a>
							<?php  } } ?>
							<?php  if(count($stores)>3) { ?>
							<div class='show-allshop'><span class='show-allshop-btn'>加载更多门店</span></div>
							<?php  } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php  } ?>
		<?php  } ?>
		<?php  if(!empty($store)) { ?>
		<div class="fui-according-group">
			<div class="fui-according expanded">
				<div class="fui-according-header">
					<span class="text">适用门店</span>
							<span class="remark">
								<span class="badge"><?php  echo count($stores)?></span>
							</span>
				</div>
				<div class="fui-according-content">
					<div class="content-block">
						<div class="fui-cell-group notop store-container">
							<a href="<?php  echo mobileUrl('store/detail',array('id'=>$store['id']))?>" class="fui-cell">
								<div class="fui-cell-icon">
									<i class="icon icon-locationfill"></i>
								</div>
								<div class="fui-cell-info">
									<?php  echo $store['realname'];?>
								</div>
								<div class="fui-cell-remark">
									查看
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php  } ?>
		<?php  if(!empty($carrier)) { ?>
		<div class="fui-cell-group">
			<div class="fui-cell">
				<div class="fui-cell-info">
					姓名：<?php  echo $carrier['carrier_realname'];?>
				</div>
				<div class="fui-cell-remark noremark">
				</div>
			</div>
			<div class="fui-cell">
				<div class="fui-cell-info">
					电话：<?php  echo $carrier['carrier_mobile'];?>
				</div>
				<div class="fui-cell-remark noremark">
				</div>
			</div>
			<?php  if($order['status'] == -1) { ?>
			<div class="fui-cell">
				<div class="fui-cell-info">
					审核不通过：<?php  echo $order['refused_reason'];?>
				</div>
				<div class="fui-cell-remark noremark">
				</div>
			</div>
			<?php  } ?>
		</div>
		<?php  } ?>
		<?php  if($order['status'] != -2) { ?>
		<?php  if(!empty($order_fields) && !empty($order_data)) { ?>
			<div class="fui-cell-group noborder">
				<?php  $datas = $order_data?>
				<?php  if(is_array($order_fields)) { foreach($order_fields as $key => $value) { ?>
				<div class="fui-cell">
					<div class="fui-cell-label"><?php  echo $value['tp_name']?></div>
					<div class="fui-cell-info">

					</div>
					<div class="fui-cell-remark noremark">
						<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('diyform/mdiyform', TEMPLATE_INCLUDEPATH)) : (include template('diyform/mdiyform', TEMPLATE_INCLUDEPATH));?>
					</div>
				</div>
				<?php  } } ?>
			</div>
		<?php  } ?>
		<?php  } else { ?>
		<?php  if(!empty($order_fields) && !empty($order_data)) { ?>
			<div class="fui-cell-group noborder">
				<?php  $datas = $order_data?>
				<?php  if(is_array($order_fields)) { foreach($order_fields as $key => $value) { ?>
				<div class="fui-cell">
					<div class="fui-cell-label"><?php  echo $value['tp_name']?></div>
					<div class="fui-cell-info">
						<?php  if($value['data_type'] == 0) { ?>

				        <input type="text" class='fui-input' id='field_data<?php  echo $i?>' name='field_data<?php  echo $i?>' placeholder="<?php  if(!empty($value['placeholder'])) { ?><?php  echo $value['placeholder'];?><?php  } else { ?>请输入<?php  echo $value['tp_name'];?><?php  } ?>"  value="<?php  echo $order_data[$key]?>" />
				        <?php  } else if($value['data_type'] == 1) { ?>
				        <textarea class="" id='field_data<?php  echo $i?>' name='field_data<?php  echo $i?>' placeholder="<?php  if(!empty($value['placeholder'])) { ?><?php  echo $value['placeholder'];?><?php  } else { ?>请输入<?php  echo $value['tp_name'];?><?php  } ?>" ><?php  echo $order_data[$key]?></textarea>

				        <?php  } else if($value['data_type'] == 2) { ?>
				        <div class="diyform-pulldown">
				            <select id='field_data<?php  echo $i?>' name='field_data<?php  echo $i?>'  class="form-select">
				                <option value=''>请选择<?php  echo $value['tp_name'];?></option>
				                <?php  if(is_array($value['tp_text'])) { foreach($value['tp_text'] as $k2 => $v2) { ?>
				                <option value="<?php  echo $v2?>" <?php  if($order_data[$key] == $v2) { ?>selected<?php  } ?>><?php  echo $v2?></option>
				                <?php  } } ?>
				            </select>
				        </div>
				        <?php  } else if($value['data_type'] == 3) { ?>
				        <?php  if(is_array($value['tp_text'])) { foreach($value['tp_text'] as $k2 => $v2) { ?>
				        <label class="checkbox-inline">
				            <input type="checkbox" class='fui-checkbox fui-checkbox-danger' name='field_data<?php  echo $i?>[]' <?php  if(is_array($order_data[$key]) &&  in_array($v2, $order_data[$key])) { ?>checked<?php  } ?> value="<?php  echo $v2?>"/> <?php  echo $v2?>
				        </label>
				        <?php  } } ?>

				        <?php  } else if($value['data_type'] == 5) { ?>
				        <ul class="fui-images fui-images-sm" id="field_data<?php  echo $i?>_images">
							<?php  if(is_array($order_data[$key])) { foreach($order_data[$key] as $v1) { ?>
							<input type="hidden" name="field_data<?php  echo $i?>[]" value="<?php  echo $v1;?>" />
							<li style="background-image:url(<?php  echo tomedia($v1)?>)" class="image image-sm" data-filename="<?php  echo $v1;?>"><span class="image-remove"><i class="icon icon-roundclose"></i></span></li>
							<?php  } } ?>
				        </ul>
				        <div class="fui-uploader fui-uploader-sm diyform-container-uploader" <?php  if(!empty($order_data[$key])) { ?><?php  if($img_max == count($order_data[$key])) { ?>style='display:none'<?php  } ?><?php  } ?>
				        data-name="field_data<?php  echo $i?>[]"
				        data-max="<?php  echo $img_max;?>"
				        data-count="<?php  if(!empty($order_data[$key])) { ?><?php  echo count($order_data[$key])?><?php  } else { ?>0<?php  } ?>">
				        <input type="file"name='imgFile<?php  echo $i?>' id='imgFile<?php  echo $i?>' <?php  if(!is_h5app() || (is_h5app() && is_ios())) { ?>multiple="" accept="image/*"  capture="camera"<?php  } ?> >
				    </div>

				    <?php  } else if($value['data_type'] == 6) { ?>
				    <input type="text" class='fui-input' id='field_data<?php  echo $i?>' name='field_data<?php  echo $i?>' placeholder="请输入<?php  echo $value['tp_name'];?>" maxlength="18" value="<?php  echo $order_data[$key]?>" />

				    <?php  } else if($value['data_type'] == 7) { ?>
				    <div class="diyform-pulldown">
				        <input type="text" class='fui-input datepicker' id="field_data<?php  echo $i?>" name='field_data<?php  echo $i?>' placeholder="请输入<?php  echo $value['tp_name'];?>" value='<?php  if(!empty($order_data[$key])) { ?><?php  echo $order_data[$key]?><?php  } ?>' readonly/>
				    </div>

				    <?php  } else if($value['data_type'] == 8) { ?>
				    <div class="diyform-pulldown2">
				        <input type="text" class='fui-input datepicker'  id="field_data<?php  echo $i?>_0" name='field_data<?php  echo $i?>' placeholder="开始日期" value='<?php  if(!empty($order_data[$key]['0'])) { ?><?php  echo $order_data[$key]['0']?><?php  } ?>' style='width:100%;float:left;background: #f3f3f3;text-indent: .5rem;;border-radius: .1rem' readonly/>
				    </div>
				    <span style="float: left;display: inline-block;margin: 0 .5rem;color: #000;">至</span>
				    <div class="diyform-pulldown2" style="margin-right: 1.5rem">
				        <input type="text" class='fui-input datepicker'  id="field_data<?php  echo $i?>_1" name='field_data<?php  echo $i?>' placeholder="结束日期" value='<?php  if(!empty($order_data[$key]['1'])) { ?><?php  echo $order_data[$key]['1']?><?php  } ?>' style='width:100%;float:left;background: #f3f3f3; text-indent: .5rem;;border-radius: .1rem;' readonly/>
				    </div>

				    <?php  } else if($value['data_type'] == 9) { ?>
				<div class="diyform-pulldown">
				    <input type="text" class='fui-input citypicker' id="field_data<?php  echo $i?>" name='field_data<?php  echo $i?>' placeholder="请选择<?php  echo $value['tp_name'];?>"
				           value="<?php  if(!empty($order_data[$key]['province'])) { ?><?php  echo $order_data[$key]['province'];?><?php  } ?><?php  if(!empty($order_data[$key]['city'])) { ?><?php  echo $order_data[$key]['city'];?><?php  } ?><?php  if(!empty($order_data[$key]['area'])) { ?><?php  echo $order_data[$key]['area'];?><?php  } ?>"
				           data-value="<?php  if(!empty($order_data[$key]['value'])) { ?><?php  echo $order_data[$key]['value'];?><?php  } ?>"
				           data-area="<?php  echo intval($value['tp_area'])?>" readonly/>
				</div>
				    <?php  } else if($value['data_type'] == 10) { ?>
				    <input type="text" class='fui-input' id='field_data<?php  echo $i?>' name='field_data<?php  echo $i?>' placeholder="请输入<?php  echo $value['tp_name'];?>"  value="<?php  echo $order_data[$key]['name1']?>" />
				    <br/>
				    <input type="text" class='fui-input' id='field_data<?php  echo $i?>_2' name='field_data<?php  echo $i?>_2' placeholder="请输入<?php  echo $value['tp_name2'];?>"  value="<?php  echo $order_data[$key]['name2']?>" />

				    <?php  } else if($value['data_type'] == 11) { ?>
				    <div class="diyform-pulldown">
				        <input type="text" class='fui-input timepicker' id="field_data<?php  echo $i?>" name='field_data<?php  echo $i?>' placeholder="请选择<?php  echo $value['tp_name'];?>"  readonly value='<?php  if(!empty($order_data[$key])) { ?><?php  echo $order_data[$key]?><?php  } ?>'/>
				    </div>
				    <?php  } else if($value['data_type'] == 12) { ?>
				    <div class="diyform-pulldown2">
				        <input type="text" class='fui-input timepicker'  id="field_data<?php  echo $i?>_0" name='field_data<?php  echo $i?>' placeholder="开始时间" value='<?php  if(!empty($order_data[$key]['0'])) { ?><?php  echo $order_data[$key]['0']?><?php  } ?>' style='width:100%;float:left;background: #f3f3f3; text-indent: .5rem;;border-radius: .1rem;' readonly/>
				    </div>
				    <span style="float: left;display: inline-block;margin: 0 .5rem;color: #000;">至</span>
				    <div class="diyform-pulldown2" style="margin-right: 4rem">
				        <input type="text" class='fui-input timepicker'  id="field_data<?php  echo $i?>_1" name='field_data<?php  echo $i?>' placeholder="结束时间" value='<?php  if(!empty($order_data[$key]['1'])) { ?><?php  echo $order_data[$key]['1']?><?php  } ?>' style='width:100%;float:left;background: #f3f3f3; text-indent: .5rem;;border-radius: .1rem;' readonly/>
				    </div>
				    <?php  } else if($value['data_type'] == 13) { ?>
				        <?php  echo $value['tp_text'];?>
				    <?php  } ?>
					</div>
				</div>
				<?php  } } ?>
			</div>
		<?php  } ?>
		<?php  } ?>




		<!--消费码-->
		<?php  if($order['showverify']) { ?>
			<div class="fui-cell-group">
								<?php  if($order['status']>0 || $order['paytime'] > 0) { ?>
									<?php  if(is_array($verifyinfo)) { foreach($verifyinfo as $v) { ?>
										<div  class="fui-cell lineblock">
											<div class="fui-cell-info">
												消费码:<?php  echo $v['verifycode'];?>
											</div>

											<div class="fui-cell-remark noremark">
												<?php  if($v['verified']) { ?>
												<div class='fui-label fui-label-danger' >已使用</div>
												<?php  } else if($order['verifyendtime'] > 0 && $order['verifyendtime'] < time()) { ?>
												<div class='fui-label fui-label-warning' >已过期</div>
												<?php  } else { ?>
												<?php  if($order['dispatchtype']) { ?>
												<div class='fui-label fui-label-default' >未取货</div>
												<?php  } else { ?>
												<?php  if($order['verifytype']==1) { ?>
												<div class='fui-label fui-label-default' >剩余<?php  echo $goods[0]['total']-count($vs)?> 次</div>
												<?php  } else { ?>
												<div class='fui-label fui-label-default' >未使用</div>
												<?php  } ?>
												<?php  } ?>
												<?php  } ?>
											</div>
										</div>
									<?php  } } ?>
								<?php  } else { ?>
									<div   class="fui-cell lineblock">
										<div class="fui-cell-info">
											付款后可见!
										</div>
									</div>
								<?php  } ?>
							</div>
		<?php  } ?>

		<?php  if(!empty($order['virtual']) && !empty($order['virtual_str'])) { ?>
			<!--发货信息-->
			<div class="fui-according-group">
				<div class="fui-according expanded">
					<div class="fui-according-header">
						<span class="text">发货信息</span>
						<span class="remark"></span>
					</div>
					<div class="fui-according-content"  style="display: block;">
						<div class="content-block">
							<div class="fui-cell-group notop">
								<?php  if(is_array($ordervirtual)) { ?>
									<?php  if(is_array($ordervirtual)) { foreach($ordervirtual as $ordervirtualrow) { ?>
											<div  class="fui-cell">
												<div class="fui-cell-label"><?php  echo $ordervirtualrow['key'];?></div>
												<div class="fui-cell-info" style="white-space: normal;word-wrap: break-word"><?php  echo $ordervirtualrow['value'];?></div>
											</div>
									<?php  } } ?>
								<?php  } else { ?>
									<div  class="fui-cell">
										<div class="fui-cell-info" style="white-space: normal;word-wrap: break-word">
											<?php  echo $order['virtual_str'];?>
										</div>
									</div>
								<?php  } ?>
								<?php  if(!empty($virtualtemp) && !empty($virtualtemp['linkurl'])) { ?>
								<a class="btn btn-default block" href="<?php  echo $virtualtemp['linkurl'];?>"><?php echo !empty($virtualtemp['linktext'])? $virtualtemp['linktext']: '使用地址'?></a>
								<?php  } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php  } ?>

		<?php  if(!empty($order['isvirtualsend']) && !empty($order['virtualsend_info'])) { ?>
			<!--发货信息-->
			<div class="fui-according-group">
				<div class="fui-according expanded">
					<div class="fui-according-header">
						<span class="text">发货信息</span>
						<span class="remark"></span>
					</div>
					<div class="fui-according-content"  style="display: block;">
						<div class="content-block">
							<div class="fui-cell-group notop">
								<div   class="fui-cell">
									<div class="fui-cell-info" style="white-space: normal;word-wrap: break-word">
										<?php  echo $order['virtualsend_info'];?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php  } ?>

		<!--商品小计-->
		<div class="fui-cell-group noborder">
			<div class="fui-cell">
				<div class="fui-cell-label">商品小计</div>
				<div class="fui-cell-info">
					<?php  if($order['ispackage']) { ?>(套餐总价)<?php  } ?>
				</div>
				<div class="fui-cell-remark noremark">
					&yen; <?php  echo $order['goodsprice'];?>
				</div>
			</div>
			<?php  if(empty($order['isnewstore'])) { ?>
			<div class="fui-cell">
				<div class="fui-cell-label">运费</div>
				<div class="fui-cell-info">

				</div>
				<div class="fui-cell-remark noremark">
					&yen; <?php  echo $order['dispatchprice'];?>
				</div>
			</div>
			<?php  } ?>

			<?php  if(!empty($order['lotterydiscountprice']) && $order['lotterydiscountprice']>0) { ?>
			<div class="fui-cell">
				<div class="fui-cell-label">抽奖优惠</div>
				<div class="fui-cell-info">

				</div>
				<div class="fui-cell-remark noremark">
					- &yen; <?php  echo $order['lotterydiscountprice'];?>
				</div>
			</div>
			<?php  } ?>

			<?php  if(!$order['ispackage']) { ?>
				<?php  if($order['deductenough']>0) { ?>
					<div class="fui-cell">
						<div class="fui-cell-label">满额立减</div>
						<div class="fui-cell-info">

						</div>
						<div class="fui-cell-remark noremark">
							-&yen; <?php  echo $order['deductenough'];?>
						</div>
					</div>
				<?php  } ?>

				<?php  if($order['couponprice']>0) { ?>
					<div class="fui-cell">
						<div class="fui-cell-label">优惠券优惠</div>
						<div class="fui-cell-info">

						</div>
						<div class="fui-cell-remark noremark">
							-&yen; <?php  echo $order['couponprice'];?>
						</div>
					</div>
				<?php  } ?>

				<?php  if($order['buyagainprice']>0) { ?>
					<div class="fui-cell">
						<div class="fui-cell-label">重复购买优惠</div>
						<div class="fui-cell-info">

						</div>
						<div class="fui-cell-remark noremark">
							-&yen; <?php  echo $order['buyagainprice'];?>
						</div>
					</div>
				<?php  } ?>

				<?php  if($order['discountprice']>0) { ?>
					<div class="fui-cell">
						<div class="fui-cell-label">会员优惠</div>
						<div class="fui-cell-info">

						</div>
						<div class="fui-cell-remark noremark">
							-&yen; <?php  echo $order['discountprice'];?>
						</div>
					</div>
				<?php  } ?>

				<?php  if($order['isdiscountprice']>0) { ?>
				<div class="fui-cell">
					<div class="fui-cell-label">促销优惠</div>
					<div class="fui-cell-info">

					</div>
					<div class="fui-cell-remark noremark">
						-&yen; <?php  echo $order['isdiscountprice'];?>
					</div>
				</div>
				<?php  } ?>
				<?php  if($order['deductprice']>0) { ?>
					<div class="fui-cell">
						<div class="fui-cell-label"><?php  echo $_W['shopset']['trade']['credittext'];?>抵扣</div>
						<div class="fui-cell-info">

						</div>
						<div class="fui-cell-remark noremark">
							-&yen; <?php  echo $order['deductprice'];?>
						</div>
					</div>
				<?php  } ?>

				<?php  if($order['deductcredit2']>0) { ?>
					<div class="fui-cell">
						<div class="fui-cell-label"><?php  echo $_W['shopset']['trade']['moneytext'];?>抵扣</div>
						<div class="fui-cell-info">

						</div>
						<div class="fui-cell-remark noremark">
							-&yen; <?php  echo $order['deductcredit2'];?>
						</div>
					</div>
				<?php  } ?>

				<?php  if($order['seckilldiscountprice']>0) { ?>
					<div class="fui-cell">
						<div class="fui-cell-label">秒杀优惠</div>
						<div class="fui-cell-info">

						</div>
						<div class="fui-cell-remark noremark">
							-&yen; <?php  echo $order['seckilldiscountprice'];?>
						</div>
					</div>
				<?php  } ?>
			<?php  } ?>

				<div class="fui-cell">
					<div class="fui-cell-label" style="width: 6rem;">实付费<?php  if(empty($order['isnewstore'])) { ?>(含运费)<?php  } ?></div>
					<div class="fui-cell-info">

					</div>
					<div class="fui-cell-remark noremark text-danger">
						 <span style='font-size:.75rem'>&yen;<?php  echo $order['price'];?>
					</div>
				</div>
			</div>

			<div class="fui-cell-group noborder order-info">
				<div class="fui-cell">
					<div class="fui-cell-info">
						<span style="margin-right: 0.7rem;">订单编号</span><?php  echo $order['ordersn'];?>
					</div>
					<div class="fui-cell-remark noremark">

					</div>
				</div>
				<div class="fui-cell">
					<div class="fui-cell-info">
						<span style="margin-right:0.7rem;">创建时间</span><?php  echo date('Y-m-d H:i:s', $order['createtime'])?>
					</div>
					<div class="fui-cell-remark noremark">

					</div>
				</div>
				<?php  if($order['status']>=1 && $order['paytime'] > 0) { ?>
					<div class="fui-cell">
						<div class="fui-cell-info">
							<span style="margin-right: 0.7rem;">支付时间</span><?php  echo date('Y-m-d H:i:s', $order['paytime'])?>
						</div>
						<div class="fui-cell-remark noremark">

						</div>
					</div>
				<?php  } ?>
				<?php  if(!$isonlyverifygood) { ?>
					<?php  if($order['status']>=2 || ($order['status']>=1 && $order['sendtype']>0)) { ?>
						<div class="fui-cell">
							<div class="fui-cell-info">
								<span style="margin-right: 0.7rem;">发货时间</span><?php  echo date('Y-m-d H:i:s', $order['sendtime'])?>
							</div>
							<div class="fui-cell-remark noremark">

							</div>
						</div>
					<?php  } ?>
				<?php  } ?>

				<?php  if($order['status']==3) { ?>
					<div class="fui-cell">
						<div class="fui-cell-info">
							<span style="margin-right: 0.7rem;">完成时间</span><?php  echo date('Y-m-d H:i:s', $order['createtime'])?>
						</div>
						<div class="fui-cell-remark noremark">

						</div>
					</div>
				<?php  } ?>
			</div>
		</div>
		<div class="fui-footer" style="text-align: right;">
			
			<?php  if($order['userdeleted']==0) { ?>
				<?php  if($order['status']==0) { ?>
					<div class="btn btn-sm btn-default-o order-cancel">取消订单
						<select data-orderid="<?php  echo $order['id'];?>">

							<option value="">不取消了</option>
							<option value="我不想买了">我不想买了</option>
							<option value="信息填写错误，重新拍">信息填写错误，重新拍</option>
							<option value="同城见面交易">同城见面交易</option>
							<option value="其他原因">其他原因</option>
						</select>
					</div>
					<?php  if(is_mobile()) { ?>
						<?php  if($order['paytype']!=3) { ?>
							<?php  if($order['paytype']!=3 && empty($ispeerpay)) { ?>
								<a class="btn btn-sm btn-default-o"  href="<?php  echo mobileUrl('order/pay',array('id'=>$order['id']))?>">支付订单</a>
							<?php  } else { ?>
								<a class="btn btn-sm btn-default-o"  href="<?php  echo mobileUrl('order/pay/peerpayshare',array('id'=>$order['id']))?>">代付订单</a>
							<?php  } ?>
						<?php  } ?>
					<?php  } ?>
				<?php  } ?>
				<?php  if(!$order['diyformdata']) { ?>
				<?php  if($order['status']==3 || $order['status']==-1) { ?>
					<div class="btn btn-sm btn-default-o order-delete" data-orderid="<?php  echo $order['id'];?>">删除订单</div>
				<?php  } ?>


				<?php  if($order['status']==3 && $order['iscomment']==1) { ?>
					<a class="btn btn-sm btn-default-o" href="<?php  echo mobileUrl('order/comment',array('id'=>$order['id']))?>">追加评价</a>
				<?php  } ?>
				<?php  if($order['status']==3 && $order['iscomment']==0 && empty($_W['shopset']['trade']['closecomment'])) { ?>
					<a class="btn btn-sm btn-default-o" href="<?php  echo mobileUrl('order/comment',array('id'=>$order['id']))?>">评价</a>
				<?php  } ?>
				<?php  if($order['status']==2) { ?>
					<div class="btn btn-sm btn-default-o order-finish" data-orderid="<?php  echo $order['id'];?>">确认收货</div>
				<?php  } ?>

				<?php  if($order['canrefund']) { ?>
					<a data-nocache="true" class="btn btn-sm btn-default-o" href="<?php  echo mobileUrl('order/refund',array('id'=>$order['id']))?>"><?php  if(!empty($order['refundstate'])) { ?>查看<?php  } ?><?php  if($order['status'] ==1) { ?>申请退款<?php  } else { ?>申请售后<?php  } ?><?php  if(!empty($order['refundstate'])) { ?>进度<?php  } ?></a>
				<?php  } ?>

				<?php  if($order['refundstate'] > 0 && $refund['status']!=5) { ?>
					<a class='btn btn-sm btn-default-o btn-cancel'>取消申请</a>
				<?php  } ?>
				<?php  } ?>
			<?php  } else if($order['userdeleted']==1) { ?>
				<div class="btn btn-sm btn-default-o order-deleted" data-orderid="<?php  echo $order['id'];?>">彻底删除订单</div>

				<div class="btn btn-sm btn-default-o order-recover" data-orderid="<?php  echo $order['id'];?>">恢复订单</div>
			<?php  } ?>
		</div>


		<?php  if($order['canverify']) { ?>
		<div class="mask">
			<div class="code_box">
				<p>请将二维码出示给核销员</p>
				<div class="img_box">
					<img class="qrimg" src="<?php  echo $qrcodeimg;?>"/>
				</div>
				<div class="cav_code"><?php  echo $verifycode;?></div>
				<div class="error">
					<p style="padding: 0 1.3rem">温馨提示：为了更好的保护您利益,请不要轻易将您的核销二维码泄露给他人</p>
				</div>
			</div>
		</div>
		<?php  } ?>

	</div>

	<script type="text/javascript">
		$('.order_detail_code').click(function(){
			$('.mask').css({display:'block'})
		})
		$('.mask').click(function(){
			$(this).css({display:'none'})
		})
		require(['biz/order/detail'], function (modal) {
			FoxUI.according.init();
			modal.init({orderid: "<?php  echo $orderid;?>",fromDetail:true});
		});
	</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--yifuyuanma-->�</option>
						</select>
					</div>
					<?php  if(is_mobile()) { ?>
						<?php  if($order['paytype']!=3) { ?>
							<?php  if($order['paytype']!=3 && empty($ispeerpay)) { ?>
								<a class="btn btn-sm btn-default-o"  href="<?php  echo mobileUrl('order/pay',array('id'=>$order['id']))?>">支付订单</a>
							<?php  } else { ?>
								<a class="btn btn-sm btn-default-o"  href="<?php  echo mobileUrl('order/pay/peerpayshare',array('id'=>$order['id']))?>">代付订单</a>
							<?php  } ?>
						<?php  } ?>
					<?php  } ?>
				<?php  } ?>
				<?php  if(!$order['diyformdata']) { ?>
				<?php  if($order['status']==3 || $order['status']==-1) { ?>
					<div class="btn btn-sm btn-default-o order-delete" data-orderid="<?php  echo $order['id'];?>">删除订单</div>
				<?php  } ?>


				<?php  if($order['status']==3 && $order['iscomment']==1) { ?>
					<a class="btn btn-sm btn-default-o" href="<?php  echo mobileUrl('order/comment',array('id'=>$order['id']))?>">追加评价</a>
				<?php  } ?>
				<?php  if($order['status']==3 && $order['iscomment']==0 && empty($_W['shopset']['trade']['closecomment'])) { ?>
					<a class="btn btn-sm btn-default-o" href="<?php  echo mobileUrl('order/comment',array('id'=>$order['id']))?>">评价</a>
				<?php  } ?>
				<?php  if($order['status']==2) { ?>
					<div class="btn btn-sm btn-default-o order-finish" data-orderid="<?php  echo $order['id'];?>">确认收货</div>
				<?php  } ?>

				<?php  if($order['canrefund']) { ?>
					<a data-nocache="true" class="btn btn-sm btn-default-o" href="<?php  echo mobileUrl('order/refund',array('id'=>$order['id']))?>"><?php  if(!empty($order['refundstate'])) { ?>查看<?php  } ?><?php  if($order['status'] ==1) { ?>申请退款<?php  } else { ?>申请售后<?php  } ?><?php  if(!empty($order['refundstate'])) { ?>进度<?php  } ?></a>
				<?php  } ?>

				<?php  if($order['refundstate'] > 0 && $refund['status']!=5) { ?>
					<a class='btn btn-sm btn-default-o btn-cancel'>取消申请</a>
				<?php  } ?>
				<?php  } ?>
			<?php  } else if($order['userdeleted']==1) { ?>
				<div class="btn btn-sm btn-default-o order-deleted" data-orderid="<?php  echo $order['id'];?>">彻底删除订单</div>

				<div class="btn btn-sm btn-default-o order-recover" data-orderid="<?php  echo $order['id'];?>">恢复订单</div>
			<?php  } ?>
		</div>


		<?php  if($order['canverify']) { ?>
		<div class="mask">
			<div class="code_box">
				<p>请将二维码出示给核销员</p>
				<div class="img_box">
					<img class="qrimg" src="<?php  echo $qrcodeimg;?>"/>
				</div>
				<div class="cav_code"><?php  echo $verifycode;?></div>
				<div class="error">
					<p style="padding: 0 1.3rem">温馨提示：为了更好的保护您利益,请不要轻易将您的核销二维码泄露给他人</p>
				</div>
			</div>
		</div>
		<?php  } ?>

	</div>

	<script type="text/javascript">
		$('.order_detail_code').click(function(){
			$('.mask').css({display:'block'})
		})
		$('.mask').click(function(){
			$(this).css({display:'none'})
		})
		require(['biz/order/detail'], function (modal) {
			FoxUI.according.init();
			modal.init({orderid: "<?php  echo $orderid;?>",fromDetail:true});
		});
	</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--yifuyuanma-->