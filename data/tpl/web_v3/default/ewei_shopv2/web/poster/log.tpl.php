<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>


<div class="page-header">
    当前位置：<span class="text-primary">关注记录 </span>
</div>
	<div class="page-content">
          <form action="./index.php" method="get" class="form-horizontal table-search"  role="form">
                        <input type="hidden" name="c" value="site" />
                        <input type="hidden" name="a" value="entry" />
                        <input type="hidden" name="m" value="ewei_shopv2" />
                        <input type="hidden" name="do" value="web" />
                        <input type="hidden" name="r"  value="poster.log" />
                        <input type="hidden" name="id" value="<?php  echo $_GPC['id'];?>" />
                        <div class="page-toolbar m-b-sm m-t-sm">
                            <div class="col-sm-5">
                                    <div class='input-group input-group-sm'   >
                                           <?php  echo tpl_daterange('time', array('placeholder'=>'关注时间'),true);?>
                                    </div>
                            </div>
                            <div class="col-sm-6 pull-right">
                                        <div class="input-group">
                                            <div class="input-group-select">
                                                <select name='searchfield'  class='form-control  input-sm select-md'   style="width:100px;"  >
                                                    <option value='rec' <?php  if($_GPC['searchfield']=='rec') { ?>selected<?php  } ?>>推荐人</option>
                                                    <option value='sub' <?php  if($_GPC['searchfield']=='sub') { ?>selected<?php  } ?>>扫码人</option>
                                                </select>
                                            </div>
                                            <input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="昵称/姓名/手机号"> <span class="input-group-btn">
                                            <button class="btn btn-primary" type="submit"> 搜索</button> </span>
                                        </div>

                            </div>
                        </div>
          </form>
 

            <form action="" method="post" onsubmit="return formcheck(this)">
  
   <?php  if(count($list)>0) { ?>
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>推荐人</th>
                        <th></th>
                        <th>推荐数</th>
                        
                        <th>奖励</th>
                        <th>关注者</th>
                        <th></th>
                        <th>奖励</th>
                        <th>关注时间</th>
                        <th style="width: 45px;">操作</th>
                    </tr>
                </thead> 
                <tbody>  
                 <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>
                        <td><span data-toggle='tooltip' title='<?php  echo $row['nickname'];?>'><img class="radius50" src='<?php  echo tomedia($row['avatar'])?>' style='width:40px;height:40px;padding1px;border:1px solid #ccc' onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"/> <?php  echo $row['nickname'];?></span>
                        <td><?php  echo $row['realname'];?><br/><?php  echo $row['mobile'];?></td>
                        <td><?php  echo $row['times'];?></td>
                        <td data-toggle='tooltip' title="<?php  if(!empty($row['reccredit'])) { ?>+<?php  echo $_W['shopset']['trade']['credittext'];?>: <?php  echo $row['reccredit'];?><?php  } ?><?php  if($row['recmoney']>0) { ?>+余额: <?php  echo $row['recmoney'];?><?php  } ?>">
                            <?php  if(!empty($row['reccredit'])) { ?>+<?php  echo $_W['shopset']['trade']['credittext'];?>: <?php  echo $row['reccredit'];?><br/><?php  } ?>
                            <?php  if($row['recmoney']>0) { ?>+余额: <?php  echo $row['recmoney'];?><br/><?php  } ?>
                        </td>
                        <td><span data-toggle='tooltip' title='<?php  echo $row['nickname1'];?>'><img class="radius50" src='<?php  echo $row['avatar1'];?>' style='width:40px;height:40px;padding1px;border:1px solid #ccc' onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"/> <?php  echo $row['nickname1'];?></span></td>
                          <td><?php  echo $row['realname1'];?><br/><?php  echo $row['mobile1'];?></td>
                         <td data-toggle='tooltip' title="<?php  if(!empty($row['subcredit'])) { ?>+<?php  echo $_W['shopset']['trade']['credittext'];?>: <?php  echo $row['subcredit'];?><?php  } ?><?php  if($row['submoney']>0) { ?>+余额: <?php  echo $row['submoney'];?><?php  } ?>"> <?php  if(!empty($row['subcredit'])) { ?>+<?php  echo $_W['shopset']['trade']['credittext'];?>: <?php  echo $row['subcredit'];?><br/><?php  } ?>
                            <?php  if($row['submoney']>0) { ?>+余额: <?php  echo $row['submoney'];?><br/><?php  } ?>
                        </td>
                        <td><?php  echo date('Y-m-d H:i',$row['createtime'])?></td>
                        <td>
                            <a class='btn btn-default btn-op btn-operation' href="<?php  echo webUrl('poster/log',array('id'=>$row['posterid'],'searchfield'=>'rec','keyword'=>$row['nickname']))?>" title='吸引关注列表'>
                               <span data-toggle="tooltip" data-placement="top" title="" data-original-title="吸引关注列表">
                                    <i class="icow icow-dingdan"></i>
                                 </span>
                            </a>
                        </td>
                    </tr>
                    <?php  } } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="9" class="text-right">  <?php  echo $pager;?></td>
                    </tr>
                </tfoot>
            </table>
     <?php  } else { ?>
     <div class='panel panel-default'>
	<div class='panel-body' style='text-align: center;padding:30px;'>
		 暂时没有任何关注记录!
	</div>
</div>
     
     <?php  } ?>
         </form>
    </div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--yifuyuanma-->