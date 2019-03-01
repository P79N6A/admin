<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style>
	.recharge-area{position: fixed;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.4);display: none;}
	.recharge-main{width: 50%;height: 20vw;margin: 5% auto;background: #fff;}
	.recharge-head{width: 100%;text-align: center;border-bottom: 1px solid #aaa;font-size: 20px;line-height: 30px;}
	.recharge-body{width: 100%;padding: 2vw 3vw;}
	.recharge-body table tbody tr td input{width: 80%;border: 0;}
	.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;}
	a:hover{text-indent: none;}
	.btn:hover{background: #fff;color: #333}
</style>
<link rel="stylesheet" type="text/css" href="../addons/purchasing/static/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="../addons/purchasing/static/js/bootstrap-datetimepicker.min.js"></script>
<style type="text/css">
	.input-container{display: inherit;}
</style>
<form action="<?php  echo $this->createMobileUrl('manager',array('agent_id'=>$_GPC['agent_id']));?>" class="form-inline" role="form" method="get">
	<div class="form-group" >
		开始日期:
		<input type="text" name="stime" id="starttime" readonly="readonly" value="<?php  echo $stime;?>" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
		结束日期:
		<input type="text" name="etime" id="endtime" readonly="readonly" value="<?php  echo $etime;?>" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
		<!--c=site&a=entry&eid=181-->
		<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
		<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
		<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
		<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
		<input type="hidden" name="op" value="<?php  echo $_GPC['op'];?>">
		<input type="hidden" name="area" value="<?php  echo $_GPC['area'];?>">
		<input type="hidden" name="agent_id" value="<?php  echo $_GPC['agent_id'];?>">
		<input type="submit" value="查询" class="btn btn-info">
	</div>
</form>
<?php  if($report_area == 'JB') { ?>
<table class="table table-bordered" style="margin-top: 10px;font-size: 12px;">
	<tr>
		<td colspan="25">下线报告：<?php  echo $account;?></td>
	</tr>
	<tr>
		<td colspan="25">JUBAO</td>
	</tr>
	<tr class="active">
		<td>登入</td>
		<td>名称</td>
		<td>来</td>
		<td>下线佣金</td>
		<td>下线中奖</td>
		<td>彩金中</td>
		<td>%</td>
		<td>花红</td>
		<td>下线净</td>
		<td>出给上线</td>
		<td>出给上线佣</td>
		<td>出给上线中奖</td>
		<td>彩金中</td>
		<td>%</td>
		<td>花红</td>
		<td>出给上线净</td>
		<td>盈利赚</td>
		<td>佣金赚</td>
		<td>奖金赚</td>
		<td colspan="6"></td>
	</tr>
	<?php  if(is_array($list_jb)) { foreach($list_jb as $jbi) { ?>
	<tr>
		<td>
			<?php  if($jbi['user_type'] == 1) { ?>
			<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'downline','id'=>$jbi['agent_id'],'stime'=>$_GPC['stime'],'etime'=>$_GPC['etime'],'area'=>'JB'))?>" title=""><?php  echo $jbi['account'];?></a>
			<?php  } else { ?>
			<?php  echo $jbi['account'];?>
			<?php  } ?>
		</td>
		<td><?php  echo $jbi['nickname'];?></td>
		<td><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'sum_bet','start'=>$_GPC['stime'],'end'=>$_GPC['etime'],'agent_id'=>$jbi['agent_id'],'member_id'=>$jbi['member_id']))?>"><?php  echo number_format($jbi['sum_bet'],2)?></a></td>
		<td><?php  echo number_format($jbi['cashback'],2)?></td>
		<td><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'reward','start'=>$_GPC['stime'],'end'=>$_GPC['etime'],'agent_id'=>$jbi['agent_id'],'member_id'=>$jbi['member_id']))?>"><?php  echo number_format($jbi['pay_award'],2)?></a></td>
		<td><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'jackpot','start'=>$_GPC['stime'],'end'=>$_GPC['etime'],'agent_id'=>$jbi['agent_id'],'member_id'=>$jbi['member_id']))?>"><?php  echo number_format($jbi['jackpot'],2)?></a></td>
		<td><?php  echo number_format($jbi['bonus_percent'],2)?></td>
		<td><?php  echo number_format($jbi['bonus'],2)?></td>
		<td><?php  echo number_format($jbi['profit']-$jbi['bonus']-$jbi['jackpot'],2)?></td>
		<td><?php  echo number_format($jbi['upline_sum_bet'],2)?></td>
		<td><?php  echo number_format($jbi['upline_cashback'],2)?></td>
		<td><?php  echo number_format($jbi['upline_pay_award'],2)?></td>
		<td><?php  echo number_format($jbi['jackpot'],2)?></td>
		<td><?php  echo number_format($jbi['upline_bonus_percent'],2)?></td>
		<td><?php  echo number_format($jbi['upline_bonus'],2)?></td>
		<td><?php  echo number_format($jbi['upline_profit']-$jbi['upline_bonus']-$jbi['jackpot'],2)?></td>
		<td><?php  echo number_format($jbi['profit']-$jbi['bonus'],2)-number_format($jbi['upline_profit']-$jbi['upline_bonus'],2)?></td>
		<td><?php  echo number_format($jbi['commission'],2)?></td>
		<td><?php  echo number_format($jbi['bonus_earn'],2)?></td>
		<td colspan="6"></td>
	</tr>
	<?php  } } ?>
	<tr style="background-color: #CCC;">
		<td colspan="2">共：</td>
		<td><?php  echo number_format($list_total['sum_bet'],2)?></td>
		<td><?php  echo number_format($list_total['cashback'],2)?></td>
		<td><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'reward','start'=>$_GPC['stime'],'end'=>$_GPC['etime'],'agent_id'=>$_GPC['agent_id']))?>"><?php  echo number_format($list_total['pay_award'],2)?></a></td>
		<td><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'jackpot','start'=>$_GPC['stime'],'end'=>$_GPC['etime'],'agent_id'=>$jbi['agent_id']))?>"><?php  echo number_format($list_total['jackpot'],2)?></a></td>
		<td><?php  echo number_format($list_total['bonus_percent'],2)?></td>
		<td><?php  echo number_format($list_total['bonus'],2)?></td>
		<td><?php  echo number_format($list_total['profit']-$list_total['bonus']-$list_total['jackpot'],2)?></td>
		<td><?php  echo number_format($list_total['upline_sum_bet'],2)?></td>
		<td><?php  echo number_format($list_total['upline_cashback'],2)?></td>
		<td><?php  echo number_format($list_total['upline_pay_award'],2)?></td>
		<td><?php  echo number_format($list_total['jackpot'],2)?></td>
		<td><?php  echo number_format($list_total['upline_bonus_percent'],2)?></td>
		<td><?php  echo number_format($list_total['upline_bonus'],2)?></td>
		<td><?php  echo number_format($list_total['upline_profit']-$list_total['upline_bonus']-$list['jackpot'],2)?></td>
		<td><?php  echo number_format($list_total['profit']-$list_total['bonus'],2)-number_format($list_total['upline_profit']-$list_total['upline_bonus'],2)?></td>
		<td><?php  echo number_format($list_total['commission'],2)?></td>
		<td><?php  echo number_format($list_total['bonus_earn'],2)?></td>
		<td colspan="6"></td>
	</tr>
</table>
<table class="table table-bordered">
	<tr>
		<td colspan="16"> 公司总账</td>
	</tr>
	<tr>
		<td></td>
		<td>来</td>
		<td>下线佣金</td>
		<td>下线中奖</td>
		<td>下线净</td>
	</tr>
	<tr>
		<td>总共：</td>
		<td><?php  echo number_format($list_jb_total['sum_bet'],2);?></td>
		<td><?php  echo number_format($list_jb_total['cashback'],2);?></td>
		<td><?php  echo number_format($list_jb_total['pay_award'],2);?></td>
		<td><?php  echo number_format($list_jb_total['profit'],2);?></td>
	</tr>
</table>
<?php  } else if($report_area == 'OT') { ?>
<table class="table table-bordered" style="margin-top: 10px;font-size: 12px;">
	<tr>
		<td colspan="25">下线报告：<?php  echo $account;?></td>
	</tr>
	<tr>
		<td colspan="25"><?php  if(!empty($disc_name)) { ?><?php  echo $disc_name;?><?php  } else { ?>OTHER<?php  } ?></td>
	</tr>
	<tr class="active">
		<td>登入</td>
		<td>名称</td>
		<td>来</td>
		<td>下线吃</td>
		<td>下线出字</td>
		<td>下线佣金</td>
		<td>下线中奖</td>
		<td>%</td>
		<td>彩金中</td>
		<td>花红</td>
		<td>下线净</td>
		<td>自己吃</td>
		<td>自己佣</td>
		<td>自己中</td>
		<td>自己净</td>
		<td>出给上线</td>
		<td>出给上线佣</td>
		<td>出给上线中奖</td>
		<td>彩金中</td>
		<td>%</td>
		<td>花红</td>
		<td>出给上线净</td>
		<td>盈利赚</td>
		<td>佣金赚</td>
		<td>奖金赚</td>
	</tr>
	<?php  if(is_array($list_other)) { foreach($list_other as $oti) { ?>
	<tr>
		<td>
			<?php  if($oti['user_type'] == 1) { ?>
			<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'downline','id'=>$oti['agent_id'],'area'=>'JB','stime'=>$_GPC['stime'],'etime'=>$_GPC['etime']))?>" title=""><?php  echo $oti['account'];?></a>
			<?php  } else { ?>
			<?php  echo $oti['account'];?>
			<?php  } ?>
		</td>
		<td><?php  echo $oti['nickname'];?></td>
		<td><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'sum_bet','start'=>$_GPC['stime'],'end'=>$_GPC['etime'],'agent_id'=>$oti['agent_id'],'member_id'=>$oti['member_id']))?>"><?php  echo number_format($oti['sum_bet'],2)?></a></td>
		<td><?php  echo number_format($oti['eat'],2)?></td>
		<td><?php  echo number_format($oti['eat_surplus'],2)?></td>
		<td><?php  echo number_format($oti['cashback'],2)?></td>
		<td><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'reward','start'=>$_GPC['stime'],'end'=>$_GPC['etime'],'agent_id'=>$oti['agent_id'],'member_id'=>$oti['member_id']))?>"><?php  echo number_format($oti['pay_award'],2)?></a></td>
		<td><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'jackpot','start'=>$_GPC['stime'],'end'=>$_GPC['etime'],'agent_id'=>$oti['agent_id'],'member_id'=>$oti['member_id']))?>"><?php  echo number_format($oti['jackpot'],2)?></a></td>
		<td><?php  echo number_format($oti['bonus_percent'],2)?></td>
		<td><?php  echo number_format($oti['bonus'],2)?></td>
		<td><?php  echo number_format($oti['profit']-$oti['bonus']-$oti['jackpot'],2)?></td>
		<td><?php  echo number_format($oti['eat_own'],2)?></td>
		<td><?php  echo number_format($oti['cashback_own'],2)?></td>
		<td><?php  echo number_format($oti['pay_award_own'],2)?></td>
		<td><?php  echo number_format($oti['profit_own'],2)?></td>
		<td><?php  echo number_format($oti['upline_sum_bet'],2)?></td>
		<td><?php  echo number_format($oti['upline_cashback'],2)?></td>
		<td><?php  echo number_format($oti['upline_pay_award'],2)?></td>
		<td><?php  echo number_format($oti['jackpot'],2)?></td>
		<td><?php  echo number_format($oti['upline_bonus_percent'],2)?></td>
		<td><?php  echo number_format($oti['upline_bonus'],2)?></td>
		<td><?php  echo number_format($oti['upline_profit']-$oti['upline_bonus']-$oti['jackpot'],2)?></td>
		<td><?php  echo number_format(number_format($oti['profit']-$oti['bonus'],2)-$oti['upline_profit']-$oti['upline_bonus'],2)?></td>
		<td><?php  echo number_format($oti['commission'],2)?></td>
		<td><?php  echo number_format($oti['bonus_earn'],2)?></td>
	</tr>
	<?php  } } ?>
	<tr>
		<td colspan="2">共：</td>
		<td><?php  echo number_format($list_total['sum_bet'],2)?></td>
		<td><?php  echo number_format($list_total['eat'],2)?></td>
		<td><?php  echo number_format($list_total['eat_surplus'],2)?></td>
		<td><?php  echo number_format($list_total['cashback'],2)?></td>
		<td><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'reward','start'=>$_GPC['stime'],'end'=>$_GPC['etime'],'agent_id'=>$_GPC['agent_id']))?>"><?php  echo number_format($list_total['pay_award'],2)?></a></td>		
		<td><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'jackpot','start'=>$_GPC['stime'],'end'=>$_GPC['etime'],'agent_id'=>$oti['agent_id']))?>"><?php  echo number_format($list_total['jackpot'],2)?></a></td>
		<td><?php  echo number_format($list_total['bonus_percent'],2)?></td>
		<td><?php  echo number_format($list_total['bonus'],2)?></td>
		<td><?php  echo number_format($list_total['profit']-$list_total['bonus']-$list_total['jackpot'],2)?></td>
		<td><?php  echo number_format($list_total['eat_own'],2)?></td>
		<td><?php  echo number_format($list_total['cashback_own'],2)?></td>
		<td><?php  echo number_format($list_total['pay_award_own'],2)?></td>
		<td><?php  echo number_format($list_total['profit_own'],2)?></td>
		<td><?php  echo number_format($list_total['upline_sum_bet'],2)?></td>
		<td><?php  echo number_format($list_total['upline_cashback'],2)?></td>
		<td><?php  echo number_format($list_total['upline_pay_award'],2)?></td>
		<td><?php  echo number_format($list_total['jackpot'],2)?></td>
		<td><?php  echo number_format($list_total['upline_bonus_percent'],2)?></td>
		<td><?php  echo number_format($list_total['upline_bonus'],2)?></td>
		<td><?php  echo number_format($list_total['upline_profit']-$list_total['upline_bonus']-$list_total['jackpot'],2)?></td>
		<td><?php  echo number_format($list_total['profit']-$list_total['bonus'],2)-number_format($list_total['upline_profit']-$list_total['upline_bonus'],2)?></td>
		<td><?php  echo number_format($list_total['commission'],2)?></td>
		<td><?php  echo number_format($list_total['bonus_earn'],2)?></td>
	</tr>
</table>
<?php  } ?>
<script src="../DateBox/required.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
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
      $('#starttime').datetimepicker({
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
        $('#endtime').datetimepicker('remove');
        var sdate=$("#startDate").val();
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
        $('#endtime').datetimepicker({
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
	$("#endtime").click(function(){
	    if($("#startDate").val()!=''){

	    }else{
	      showMsg('请先选择入住时间！');
	    }
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>