<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/purchasing/static/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="../addons/purchasing/static/js/bootstrap-datetimepicker.min.js"></script>
<style type="text/css">
	#search-item tbody tr td{border:0;text-align: right;padding: 5px 0;}
	#search-item tbody tr td input[type=text]{width: 100%;}
	#search-item tbody tr td select{width: 100%;}
	.recharge-area{position: fixed;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.4);display: none;z-index: 1000;}
	.recharge-main{width: 30%;height: 30vw;margin: 5% auto;background: #fff;}
	.recharge-head{width: 100%;text-align: center;font-size: 20px;line-height: 30px;padding: 0 10px;}
	.recharge-body{width: 100%;overflow-y: auto;}
	.order-ul{list-style: none;}
	.order-ul li{float: left;}
	.popover{max-width: inherit;}
</style>
<form action="./index.php" method="get">
<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
<input type="hidden" name="op" value="<?php  echo $_GPC['op'];?>">
<table class="table" id="search-item" style="width: 80%;">
	<tr>
		<td>开始日期：</td>
		<td style="width: 150px;">
			<input type="text" name="start" value="<?php  echo $start;?>" id="start" style="width: 100%;border: 1px solid #ccc;background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;" readonly="readonly">
		</td>
		<td>结束日期：</td>
		<td style="width: 150px;">
			<input type="text" name="end" value="<?php  echo $end;?>" id="end" style="width: 100%;border: 1px solid #ccc;background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;" readonly="readonly">
		</td>
		<td>
			<button type="submit" class="btn btn-success btn-sm" style="width: 70px;padding: 2px 10px;">搜索</button>
		</td>
	</tr>
	<tr>
		<td>寻找号码：</td>
		<td>
			<input type="text" name="number" value="<?php  echo $_GPC['number'];?>">
		</td>
		<td>总单号：</td>
		<td>
			<input type="text" name="ordersn" value="<?php  echo $_GPC['ordersn'];?>">
		</td>
		<td>本机单号：</td>
		<td style="width: 150px;">
			<input type="text" name="uordersn" value="<?php  echo $_GPC['uordersn'];?>">
		</td>
		<td>S/O：</td>
		<td>
			<select name="so">
				<option value="0">全部</option>
				<option value="1">有</option>
				<option value="2">无</option>
			</select>
		</td>
		<td>状况：</td>
		<td>
			
			<select name="status">
				<option value="0">全部</option>
				<option value="1" <?php  if($_GPC['status'] == 1) { ?>selected<?php  } ?>>活跃</option>
				<option value="2" <?php  if($_GPC['status'] == 2) { ?>selected<?php  } ?>>取消</option>
			</select>
		</td>
		<td>硬件：</td>
		<td>
			<select name="hard">
				<option value="0">全部</option>
				<option value="Windows" <?php  if($_GPC['hard'] == 'Windows') { ?>selected<?php  } ?>>后台</option>
				<option value="Android" <?php  if($_GPC['hard'] == 'Android') { ?>selected<?php  } ?>>Android</option>
				<option value="iPhone OS" <?php  if($_GPC['hard'] == 'iPhone OS') { ?>selected<?php  } ?>>IOS</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>ID：</td>
		<td>
			<input type="text" name="id" value="<?php  echo $_GPC['id'];?>">
		</td>
		<td>名称：</td>
		<td>
			<input type="text" name="name" value="<?php  echo $_GPC['name'];?>">
		</td>
	</tr>
</table>	
</form>
<table class="table table-bordered">
	<tr>
		<td>单号</td>
		<td>下注时间</td>
		<td>本机ID</td>
		<td>名称</td>
		<td>开彩时间</td>
		<td>本机单号</td>
		<td>状况</td>
		<td>S/O</td>
		<td>数额</td>
		<td>代理ID</td>
		<td>电话号码</td>
		<td>硬件</td>
		<td>Calculating Eat Time</td>
		<td>后台操作ID</td>
		<td>参考单号</td>
		<td>取消时间</td>
		<td></td>
	</tr>
	<?php  if(is_array($list)) { foreach($list as $order) { ?>
	<tr>
		<td><a href="javascript:void(0);" onclick="get_order(<?php  echo $order['id'];?>)">S:<?php  echo $order['ordersn'];?></a></td>
		<td><?php  echo date('Y-m-d H:i',$order['createtime'])?></td>
		<td>
			<a href="javascript:void(0)"  title="<?php  echo $order['account'];?>" data-container="body" data-toggle="popover" data-placement="bottom" data-content="<?php  echo $order['agent'];?>"><?php  echo $order['account'];?></a>
		</td>
		<td><?php  echo $order['nickname'];?></td>
		<td><?php  echo date('d-M',$order['period_time'])?></td>
		<td><?php  echo $order['uordersn'];?></td>
		<td><?php  if($order['status'] == 1) { ?>活跃<?php  } else { ?>取消<?php  } ?></td>
		<td><?php  if($order['has_sale_out'] > 0) { ?>有<?php  } else { ?>无<?php  } ?></td>
		<td><?php  echo $order['order_amount'];?></td>
		<td><?php  echo $order['parent_agent'];?></td>
		<td><?php  echo $order['mobile'];?></td>
		<td><?php  if(strpos($order['soucre'],'Windows')) { ?>后台<?php  } else if(strpos($order['soucre'],'Android')) { ?>Android<?php  } else if(strpos($order['soucre'],'iPhone OS')) { ?>iPhone<?php  } ?></td>
		<td><?php  echo $order['calculating_time'];?>s</td>
		<td><?php  echo $order['control_agent'];?></td>
		<td>S：<?php  echo $order['old_id'];?></td>
		<td><?php  if($order['cancel_time']>0) { ?><?php  echo date('Y-m-d H:i',$order['cancel_time'])?><?php  } ?></td>
		<td>
			<?php  if($order['status'] == 1 && strpos($order['cid'],'(1)') == false) { ?>
			<a href="javascript:void(0);" onclick="cancel_order(<?php  echo $order['id'];?>)">取消</a>
			<?php  } ?>
			<?php  if($order['status'] == 2) { ?>
			<a href="javascript:void(0);" onclick="set_rebuy(<?php  echo $order['id'];?>)">重买</a>
			<?php  } ?>
		</td>
	</tr>
	<?php  } } ?>
</table>
<?php  echo $pager;?>
<div class="recharge-area" id="order_detail">
	<div class="recharge-main">
		<div class="recharge-head">
			<ul class="order-ul" style="margin: 5px 0;">
				<li>
					<label class="btn auto">
					</label>
				</li>
				<li>
					<button class="btn btn-xs btn-warning" style="margin-left: 5px" onclick="rebuy()">重买</button>
				</li>
				<?php  if($_SESSION['level'] < 5) { ?>
				<li id="edit_btn">
					<button class="btn btn-xs btn-warning" style="margin-left: 5px" onclick="edit()">修改</button>
				</li>
				<li id="restore" style="display: none;">
					<button class="btn btn-xs btn-warning" style="margin-left: 5px" onclick="restore()">还原</button>
				</li>
				<?php  } ?>
				<li>
					<button class="btn btn-xs btn-danger" style="margin-left: 5px" onclick="del()">删除</button>
				</li>
				<li>
					<button class="btn btn-xs btn-warning" style="margin-left: 5px" onclick="input_type()">输入法</button>
				</li>
			</ul>
			<input type="hidden" id="order_id">
			<a href="javascript:void(0)" onclick="window.location.reload();" style="font-size: 18px;float: right;"><span>&times;</span></a>
		</div>
		<div class="recharge-body" style="height: 90%;overflow-y: auto;">
			<div style="width: 100%;display: inline-block;word-break: break-word;">
				<div style="width: 100%;">
					TICKET
				</div>
				<table class="table" id="orderd">
				
				</table>
			</div>
			<div id="writing" style="width: 49%;display: none;">
				<div style="width: 100%;">
					WRITING
				</div>
				<table class="table" style="">
				
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="../addons/purchasing/static/js/order.js"></script>
<script type="text/javascript">
	$(function () { 
		$("[data-toggle='popover']").popover();
	});
	var rule = [];
	var company = [];
	var obj = [];
	var sdate = '2018-07-04';
	$.fn.datetimepicker.dates['zdy'] = {
        days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
        daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
        daysMin:  ["日", "一", "二", "三", "四", "五", "六"],
        months: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
        monthsShort: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
        today: "今天",
        format:"yyyy-mm-dd",
        titleFormat:"yyyy-mm-",
        weekStart:1,
        suffix: [],
        meridiem: ["上午", "下午"]
      };
      $('#start').datetimepicker({
        language:  'zdy',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        startDate:sdate,
        minView:2,
        maxView:3,
        onRenderDay: function(date) {
          var date1 = date.getFullYear()+'-'
            +(date.getMonth()<9?'0'+(date.getMonth()+1):date.getMonth()+1)
            +'-'
            +(date.getDate()<10?'0'+(date.getDate()-1):date.getDate()-1);

        }
      }).on('changeDate', function(ev){
        $('#end').datetimepicker('remove');
        var sdate=$("#start").val();
        var edate;
        for(var o in obj){
          if(new Date(sdate)<=new Date(obj[o])){
            var date = new Date(obj[o])
            var ndate = +date+24*60*60*1000;
            var leaveTime = new Date(ndate);
            edate = leaveTime.getFullYear()+'-'+(leaveTime.getMonth()+1)+'-'+leaveTime.getDate();

            break;
          }
        }
        $('#end').datetimepicker({
          language:  'zdy',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          startDate:sdate,
          endDate:edate,
          minView:2,
          maxView:3
        }).on('changeDate', function(ev){

        });
      });
	$("#end").click(function(){
	    if($("#startDate").val()!=''){

	    }else{
	      showMsg('请选择日期');
	    }
	});
    window.onload = function() {
    	get_rule();
    	get_company();
    }
    function get_rule() {
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'get_rule'))?>",{},function(result) {
			rule = result;
		},'JSON');
	}
	function get_company() {
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'get_company'))?>",{},function(result) {
			company = result;
		},'JSON');
	}
	function cancel_order(id) {
		var checked = confirm('确定删除此投注？');
		if (checked == false) {
			return false;
		}
		$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'del'))?>",{id:id},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
	function get_order(id) {
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'order_detail'))?>",{id:id},function(result) {
			var txt = '';
			txt = create_order(result,txt,'xiazhu');
			$('#orderd').html(txt);
			$('#order_detail').show();
		},'JSON');
	}
	function set_rebuy(id) {
		var checked = confirm('确定重新下注这些字吗？');
		if (checked == true) {
			$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'rebuy'))?>",{id:id},function(result) {
				if (result.status == 2) {
					alert(result.info);
				}
				if (result.status == 3) {
					location.href="<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 1) {
					var txt = '';
					txt = create_order(result,txt,'xiazhu');
					$('#orderd').html(txt);
					$('#order_detail').show();
				}
			},'JSON');
		}
	}
	function rebuy() {
		var id = $('#order_id').val();
		var checked = confirm('重买后订单可能会发生变化，请检查！');
		if (checked == true) {
			$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'rebuy'))?>",{id:id},function(result) {
				if (result.status == 2) {
					alert(result.info);
				}
				if (result.status == 3) {
					location.href="<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 1) {
					alert(result.info);
					var txt = '';
					txt = create_order(result,txt,'xiazhu');
					$('#orderd').html(txt);
					$('#order_detail').show();
				}
			},'JSON');
		}
	}
	function del() {
		var id = $('#order_id').val();
		$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'del'))?>",{id:id},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
	function restore() {
		var id = $('#order_id').val();
		$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'restore'))?>",{id:id},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
	function change_auto() {
		var id = $('#order_id').val();
		var is_auto = $('#auto').is(':checked');
		console.log(is_auto);
		$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'change_days'))?>",{id:id,is_auto:is_auto},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON')
	}
	function edit() {
		var id = $('#order_id').val();
		var url = "<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'edit_order'))?>&id="+id;
		var title = '修改单页';
		window.open(url, title, "location=no,status=no,scrollvars=no,width=1000,height=600");
	}
	function input_type() {
		var id = $('#order_id').val();
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'get_writing'))?>",{id:id},function(result) {
			$('#writing').find('.table').html(result.write);
			$('.recharge-main').css('width','60%');
			$('#orderd').parent().css('width','50%');
			$('#writing').css('display','inline-block');
		},'JSON')
	}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>