<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

  <style>
    .template .item{position:relative;display:block;float:left;border:1px #ddd solid;border-radius:5px;background-color:#fff;padding:5px;width:190px;margin:0 20px 20px 0; overflow:hidden;}
    .template .title{margin:5px auto;line-height:2em;}
    .template .title a{text-decoration:none;}
    .template .item img{width:178px;height:270px; cursor:pointer;}
    .template .active.item-style img, .template .item-style:hover img{width:178px;height:270px;border:3px #009cd6 solid;padding:1px; }
    .template .title .fa{display:none}
    .template .active .fa.fa-check{display:inline-block;position:absolute;bottom:33px;right:6px;color:#FFF;background:#009CD6;padding:5px;font-size:14px;border-radius:0 0 6px 0;}
    .template .fa.fa-times{cursor:pointer;display:inline-block;position:absolute;top:10px;right:6px;color:#D9534F;background:#ffffff;padding:5px;font-size:14px;text-decoration:none;}
    .template .fa.fa-times:hover{color:red;}
    .template .item-bg{width:100%; height:342px; background:#000; position:absolute; z-index:1; opacity:0.5; margin:-5px 0 0 -5px;}
    .template .item-build-div1{position:absolute; z-index:2; margin:-5px 10px 0 5px; width:168px;}
    .template .item-build-div2{text-align:center; line-height:30px; padding-top:150px;}
  </style>
  <div class="clearfix template">
    <div class="panel panel-default">
      <nav role="navigation" class="navbar navbar-default navbar-static-top" style="margin-bottom:0;">
        <div class="container-fluid">
          <div class="navbar-header">
            <a href="javascript:;" class="navbar-brand">模板选择</a>
          </div>
          <ul class="nav navbar-nav nav-btns">
            <!--<li <?php  if(empty($_GPC['type']) || $_GPC['type'] == 'all') { ?> class="active" <?php  } ?>>-->
              <!--<a href="<?php  echo $this->createWebUrl('templates', array('op' => 'display','rid' => $rid,'type' => 'all'))?>">全部</a>-->
            <!--</li>-->
            
          </ul>

          <!--<div class="navbar-header" style="float:right;">-->
               <!--<a href="<?php  echo $this->createWebUrl('index', array('rid' => $rid))?>" class="navbar-brand"  style="color:red">活动中心</a> -->
          <!--</div>-->
          <!--<div class="navbar-header" style="float:right;">-->
               <!--<a href="<?php  echo $this->createWebUrl('templates', array('op' => 'menu','rid' => $rid))?>" class="navbar-brand"  >自定义菜单   </a>-->
          <!--</div>-->
          <!--<div class="navbar-header" style="float:right;">-->
               <!--<a href="<?php  echo $this->createWebUrl('templates', array('op' => 'post','rid' => $rid))?>" class="navbar-brand"  >添加风格   </a>-->
          <!--</div>-->

        </div>
      </nav>
      <div class="panel-body">
        <?php  if(is_array($templates)) { foreach($templates as $item) { ?>
            <div class="item item-style">
              <!--<a class="fa fa-times"  onclick="if(!confirm('删除后将不可恢复,确定删除吗?')) return false;" title="删除风格" href="<?php  echo $this->createWebUrl('templates', array('op' => 'delete','rid' => $rid,'id' => $item['id'],'stylename' => $item['name']))?>"></a>-->
              <div class="title">
                <div style="overflow:hidden; height:28px;"><h4><?php  echo $item['templatename'];?></h4></div>
                <br/>
                <a href="javascript:void(0)">
                  <?php  if($item['tempalte_type'] == 0) { ?>
                    <img src="../addons/<?php echo MON_XKWKJ;?>/template/mobile/templates/<?php  echo $item['dirname'];?>/preview.jpg" class="img-rounded" />
                  <?php  } ?>
                </a>
                <span class="fa fa-check"></span>
              </div>
              <div class="btn-group  btn-group-justified">
              <?php  if($item['tempalte_type'] != 0) { ?>
                <a href="<?php  echo $this->createWebUrl('templates', array('op' => 'post','rid' => $rid,'id' => $item['id'],'stylename' => $item['name']))?>" class="btn btn-default btn-xs">编辑</a>
              <?php  } ?>
                <!--<a href="javascript:;" onclick="preview('<?php  echo $item['name'];?>', '<?php  echo $rid;?>');return false;" class="btn btn-default btn-xs">预览</a>-->
              
              </div>
            </div>
        <?php  } } ?>
        <!--<div class="item item-style">-->
             <!---->
              <!--<div class="title">-->
                <!--<div style="overflow:hidden; height:28px;"></div>-->
                <!--<a href="<?php  echo $this->createWebUrl('templates', array('op' => 'post'))?>" title="添加新模板">-->
                  <!--<img src="<?php echo FM_STATIC_MOBILE;?>public/images/jia.png" class="img-rounded" />-->
                <!--</a>-->
                <!--<span class="fa fa-check"></span>-->

                <!--<div style="overflow:hidden; height:22px;"></div>-->
              <!--</div>-->
            <!--</div>-->
      </div>
    </div>
  </div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>


