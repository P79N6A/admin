<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/mobile/default/static/css/coupon.css?v=2.0.0">
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/mobile/default/static/css/coupon-new.css?v=2017030302">
<style>
    .yen{border:none;height:0.75rem;width:0.75rem;display: inline-block;background: #ff4753;color:#fff;font-size:0.4rem;line-height: 0.8rem;text-align: center;
        font-style: normal;border-radius: 0.75rem;-webkit-border-radius: 0.75rem;}
    .order-create-page .fui-list.goods-item .fui-list-inner{
        height: 3.5rem;
        align-self: center;
    }
    .order-create-page .fui-list.goods-item .fui-list-angle{
        height: 3.5rem;
        align-self: center;
    }
    .order-create-page .fui-list-inner .subtitle{
        display: block;
    }
</style>
<div class='fui-page order-create-page'>
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">确认订单</div>
        <div class="fui-header-right" data-nomenu="true">&nbsp;</div>
    </div>
    <div class='fui-content  navbar'>

        <?php  if(count($carrier_list)>0 && !$isverify && !$isvirtual&&!$isonlyverifygoods) { ?>
        <div id="carrierTab" class="fui-tab fui-tab-danger" style="margin-bottom: 0">
            <a data-tab="tab1" class="active">快递配送</a>
            <a data-tab="tab2">上门自提</a>
        </div>
        <?php  } ?>

        <?php  if(!empty($quickinfo)) { ?>
        <div class="fui-cell-group">
            <a class="fui-cell external" href="<?php  echo mobileUrl('quick', array('id'=>$quickinfo['id']))?>">
                <div class="fui-cell-info">数据来自快速购买: <?php  echo $quickinfo['title'];?></div>
                <div class="fui-cell-remark"></div>
            </a>
        </div>
        <?php  } ?>


        <?php  if(!$isverify && !$isvirtual&&!$isonlyverifygoods) { ?>
            <!--地址选择-->
            <div class="fui-list-group" id='addressInfo' data-addressid="<?php  echo intval($address['id'])?>" style="    margin: 0 0 .5rem;">
                <a  class="fui-list <?php  if(empty($address)) { ?>external<?php  } ?>"
                    <?php  if(empty($address)) { ?>
                        href="<?php  echo mobileUrl('member/address/post')?>"
                    <?php  } else { ?>
                        href="<?php  echo mobileUrl('member/address/selector')?>"
                    <?php  } ?>
                data-nocache="true">
                    <div class="fui-list-media">
                        <i class="icon icon-dingwei" <?php  if(empty($address)) { ?>style='display:none'<?php  } ?>></i>
                    </div>
                    <div class="fui-list-inner" >
                        <div class="title has-address" <?php  if(empty($address)) { ?>style='display:none'<?php  } ?>>
                        收货人：
                            <span class='realname'><?php  echo $address['realname'];?></span>
                            <span class='mobile'><?php  echo $address['mobile'];?></span>
                        </div>
                        <div class="text has-address" <?php  if(empty($address)) { ?>style='display:none'<?php  } ?>>
                            <span class='address'><?php  echo $address['province'];?><?php  echo $address['city'];?><?php  echo $address['area'];?><?php  if(!empty($new_area) && !empty($address_street)) { ?> <?php  echo $address['street'];?><?php  } ?> <?php  echo $address['address'];?></span>
                        </div>
                        <div class="text no-address" <?php  if(!empty($address)) { ?>style='display:none'<?php  } ?>><i class="icon icon-icon02"></i> 添加收货地址</div>
                    </div>
                    <div class="fui-list-angle">
                        <div class="angle"></div>
                    </div>
                </a>
            </div>

            <!--自提点选择-->
            <div class="fui-list-group"  id="carrierInfo" style="display: none;margin: 0 0 .5rem">
                <a class="fui-list" href="<?php  echo mobileUrl('store/selector', array('type'=>1,'merchid'=>$merch_id))?>" data-nocache='true'>
                    <div class="fui-list-media" style="display: none">
                        <i class="icon icon-dingwei"></i>
                    </div>
                    <div class="fui-list-inner">
                        <div class="no-address"><i class="icon icon-icon02"></i> 请选择自提门店</div>
                        <div class="title has-address" style="display: none"><span class='storename'>请选择itinerary门店</span></div>
                        <!--<div class="subtitle">-->
                            <!--<span style="overflow: hidden;    display: inline-block;">收货人：</span>-->
                            <!--<span class='realname'><?php  echo $carrier_list[0]['realname'];?></span>-->
                            <!--<span class='mobile' id="carrierInfo_mobile"><?php  echo $carrier_list[0]['mobile'];?></span>-->
                        <!--</div>-->
                        <div class="text" style="display: none"><span class='address'><span class="pickstore">[门店自提]</span><?php  echo $carrier_list[0]['address'];?></span></div>
                    </div>
                    <div class="fui-list-angle">
                        <div class="angle"></div>
                    </div>
                </a>

            </div>
        <?php  } ?>
    <!--联系填写-->
    <?php  if($sysset['set_realname']==0 || $sysset['set_mobile']==0) { ?>
        <div class="fui-cell-group sm" id="memberInfo" <?php  if(!$isverify && !$isvirtual) { ?>style="display:none"<?php  } ?>>
            <?php  if($sysset['set_realname']==0) { ?>
                <div class="fui-cell">
                    <div class="fui-cell-label sm">联系人</div>
                    <div class="fui-cell-info c000"><input type="text" placeholder="请输入联系人" data-set="<?php  echo $sysset['set_realname'];?>" name='carrier_realname' class="fui-input" value="<?php  echo $member['realname'];?>"/></div>
                </div>
            <?php  } ?>
            <?php  if($sysset['set_mobile']==0) { ?>
                <div class="fui-cell">
                    <div class="fui-cell-label sm">联系电话</div>
                    <div class="fui-cell-info c000"><input type="tel" placeholder="请输入联系电话" data-set="<?php  echo $sysset['set_mobile'];?>" name='carrier_mobile' class="fui-input" value="<?php  echo $member['carrier_mobile'];?>"/></div>
                </div>
            <?php  } ?>
        </div>
    <?php  } ?>


<div class="fui-list-group" >
    <?php  $i=0?>


    <?php  if(is_array($goods_list)) { foreach($goods_list as $key => $list) { ?>
    <?php  if($i !=0 ) { ?>
        <div style="height: .5rem;background: #f3f3f3"></div>
    <?php  } ?>
    <?php  $i++?>
    <div class="fui-list-group-title"><i class="icon icon-dianpu1"></i > <?php  echo $list['shopname'];?></div>
    <?php  if(is_array($list['goods'])) { foreach($list['goods'] as $g) { ?>
    <input type='hidden' name='goodsid[]' value="<?php  echo $g['id'];?>" />
    <input type='hidden' name='optionid[]' value="<?php  echo $g['optionid'];?>" />
    <div class="fui-list goods-item align-start">
        <div class="fui-list-media">
            <a href="<?php  echo mobileUrl('goods/detail',array('id'=>$g['goodsid']))?>">
                <img id="" class="round" src="<?php  echo tomedia($g['thumb'])?>">
            </a>
        </div>
        <div class="fui-list-inner">
            <a href="<?php  echo mobileUrl('goods/detail',array('id'=>$g['goodsid']))?>">
                <div class="subtitle">
                    <?php  if($g['seckillinfo'] && $g['seckillinfo']['status']==0) { ?><span class='fui-label fui-label-danger'><?php  echo $g['seckillinfo']['tag'];?></span><?php  } ?>
                    <?php  if(empty($g['isnodiscount']) && !empty($g['dflag'])) { ?><span class='fui-label fui-label-danger'>折扣</span><?php  } ?>
                    <?php  if($g['type']==4) { ?><span class='fui-label fui-label-danger'>批发</span><?php  } ?>
                    <?php  echo $g['title'];?>
                </div>
                <?php  if(!empty($g['optionid'])) { ?>
                <div class="text ">
                    <?php  echo $g['optiontitle'];?>
                </div>
                <?php  } ?>

            </a>
        </div>
        <div class="fui-list-angle"style="width: auto">
            <span style="font-size: .65rem;color: #000">￥<span class="marketprice"><?php  if($g['packageprice'] > $g['unitprice']) { ?><?php  echo $g['packageprice'];?><?php  } else if($g['marketprice'] > $g['unitprice']) { ?><?php  echo $g['marketprice'];?><?php  } else { ?><?php  echo $g['unitprice'];?><?php  } ?></span></span>
            <?php  if($g['goodsid'] > 1) { ?>
            <div class="num">
                <?php  if($taskgoodsprice) { ?>
                <?php  $total = 1;?>
                x1<input class="num shownum" type="hidden" name="" value="1"/>
                <?php  } else if($changenum && !$isgift) { ?>
                <div class="fui-number small" data-value="<?php  echo $total;?>" data-unit="<?php  echo $g['unit'];?>" data-maxbuy="<?php  echo $g['totalmaxbuy'];?>" data-minbuy="<?php  echo $g['minbuy'];?>" data-goodsid="<?php  echo $g['goodsid'];?>">
                    <div class="minus">-</div>
                    <input class="num shownum" type="tel" name="" value="<?php  echo $total;?>"/>
                    <div class="plus">+</div>
                </div>
                <?php  } else { ?>
                x<?php  echo $g['total'];?><input class="num shownum" type="hidden" name="" value="<?php  echo $total;?>"/>
                <?php  } ?>
            </div>
            <?php  } ?>
        </div>
    </div>
    <?php  } } ?>
    <?php  } } ?>





    <script type="text/javascript">
        $(function(){
            $(".package-goods-img").height($(".package-goods-img").width());
        })
    </script>
    <div class='fui-cell-group' style="margin-top: 0">
        <?php  if(is_array($giftGood)) { foreach($giftGood as $item) { ?>
        <div class="fui-cell" style="padding:0 ">
            <div class="fui-list goods-item" style="width:100%;">
                <div class="fui-list-media image-media" style="position: initial;">
                    <a href="javascript:void(0);">
                        <img class="round" src="<?php  echo tomedia($item['thumb'])?>" data-lazyloaded="true">
                    </a>
                </div>
                <div class="fui-list-inner">
                    <a href="javascript:void(0);">
                        <div class="text" style="color: #000">
                            <?php  echo $item['title'];?><br /><span class="fui-label fui-label-danger">赠品</span>
                        </div>
                    </a>
                </div>
                <div class='fui-list-angle'>
                    <span class="price" style="display: inline-block;font-size:.65rem;color: #000 ">&yen;<del class='marketprice'><?php  echo $item['marketprice'];?></del></span>
                </div>
            </div>
        </div>
        <?php  } } ?>

        <?php  if(!empty($fullbackgoods)) { ?>
        <div class="fui-cell" id="fullbackgoods" <?php  if($fullbackgoods['minallfullbackallprice']<=0 && $fullbackgoods['minallfullbackallratio']<=0) { ?>style="display: none"<?php  } ?>>
        <div class="fui-cell-label" style='width:auto' >全返详情</div>
        <div class="fui-cell-info" style="text-align: right;">
            <span class="fui-cell-remark noremark" style="font-size: 0.6rem;color:#333;">
                <i class="yen">&yen;</i>
                <?php  if($fullbackgoods['type']>0) { ?>
                总金额 <span class="text-danger"><?php  echo price_format($fullbackgoods['minallfullbackallratio'],2)?>%</span> ，每天返<span class="text-danger"><?php  echo price_format($fullbackgoods['fullbackratio'],2)?>%</span>，时间：<span class="text-danger"><?php  echo $fullbackgoods['day'];?></span>天
                <?php  } else { ?>
                总金额 &yen;<?php  echo price_format($fullbackgoods['minallfullbackallprice'],2)?>，每天返&yen;<?php  echo price_format($fullbackgoods['fullbackprice'],2)?>，时间：<?php  echo $fullbackgoods['day'];?>天
                <?php  } ?>
            </span>
        </div>
    </div>
    <?php  } ?>

    <div class="fui-cell  lineblock ">
        <div class="fui-cell-info c000" style="text-align: right;">共 <span id='goodscount' class='text-danger bigprice'><?php  echo $total;?></span> 件商品 实付：<span class="text-danger bigprice">&yen; <span class='<?php  if(!$packageid && empty($exchangeOrder)) { ?>goodsprice<?php  } ?>'><?php  echo number_format($goodsprice,2)?></soan></span></div>
    </div>

</div>
</div>

<?php  if($isgift) { ?>
<input type="hidden" name="giftid" id="giftid" value="<?php  echo $giftid;?>">
<div class="fui-cell-group sm ">
    <div class="fui-cell">
        <?php  if(count($gifts)>1) { ?>
        <div class='fui-cell-text fui-cell-giftclick'>
            赠品：<label id="gifttitle">请选择赠品</label>
        </div>
        <?php  } else { ?>
        <?php  if(is_array($gifts)) { foreach($gifts as $item) { ?>
        <div class='fui-cell-text' onclick="javascript:window.location.href='<?php  echo mobileUrl('goods/gift',array('id'=>$item['id']))?>'">
            赠品：<?php  echo $gifttitle;?>
        </div>
        <?php  } } ?>
        <?php  } ?>
        <div class='fui-cell-remark'></div>
    </div>
</div>
<?php  } ?>
<?php  if($hasinvoice) { ?>
<div class="fui-cell-group">
    <div class="fui-cell">
        <div class="fui-cell-label">发票抬头</div>
        <div class="fui-cell-info c000"><input type='text' class='fui-input' value="<?php  echo $invoicename;?>" id='invoicename' placeholder="请填写发票抬头(选填)" /></div>
    </div>
    <!--<div class="fui-cell">-->
        <!--<div class="fui-cell-label">税号</div>-->
        <!--<div class="fui-cell-info c000"><input type="text" id="realname" name="realname" value="" placeholder="请填写税号(选填)" class="fui-input"></div>-->
    <!--</div>-->
</div>
<?php  } ?>

<?php  if(!empty($order_formInfo)) { ?>

<div class="fui-cell-group diyform-container">   
    <div class="fui-cell must" data-must="0" data-type="0" data-name="姓名" data-name2="" data-isdefault="0" data-itemid="field_data1" data-key="diyxingming">
        <div class="fui-cell-label" style="padding-right: 15px;">
            姓名            
        </div>
        <div class="fui-cell-info">
            <input type="text" class="fui-input" id="field_data1" name="field_data1" placeholder="" value="">
        </div>
    </div>
    <div class="fui-cell" data-must="0" data-type="7" data-name="生日" data-name2="" data-isdefault="" data-itemid="field_data2" data-key="diyshengri">
        <div class="fui-cell-label" style="padding-right: 15px;">
            生日            
        </div>
        <div class="fui-cell-info">
            <div class="diyform-pulldown">
                <input type="text" class="fui-input datepicker" id="field_data2" name="field_data2" placeholder="请输入生日" value="" readonly="readonly">
            </div>
        </div>
    </div>
    <div class="fui-cell" data-must="0" data-type="3" data-name="性别" data-name2="" data-isdefault="" data-itemid="field_data3" data-key="diyxingbie">
        <div class="fui-cell-label" style="padding-right: 15px;">
            性别            
        </div>
        <div class="fui-cell-info">
            <label class="checkbox-inline">
                <input type="checkbox" class="fui-checkbox fui-checkbox-danger" name="field_data3" checked="" value="男"> 男 
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="fui-checkbox fui-checkbox-danger" name="field_data3" value="女"> 女 
            </label>
        </div>
    </div>
    <div class="fui-cell must" data-must="1" data-type="9" data-name="城市" data-name2="" data-isdefault="" data-itemid="field_data4" data-key="diychengshi">
        <div class="fui-cell-label" style="padding-right: 15px;">
            城市            
        </div>
        <div class="fui-cell-info">
            <div class="diyform-pulldown">
                <input type="text" class="fui-input citypicker" id="field_data4" name="field_data4" placeholder="请选择城市" value="" data-value="" data-area="0" readonly="readonly">
            </div>
        </div>
    </div>
    <div class="fui-cell must" data-must="1" data-type="8" data-name="车牌号" data-name2="" data-isdefault="0" data-itemid="field_data5" data-key="diychepaihao">
        <div class="fui-cell-label" style="padding-right: 15px;">
            车牌号            
        </div>
        <div class="fui-cell-info">
            <select class="fui-select" id="field_data5_0" style="width: 6vw;">
                <option value="粤">粤</option>
                <option value="京">京</option>
                <option value="沪">沪</option>
                <option value="津">津</option>
                <option value="冀">冀</option>
                <option value="晋">晋</option>
                <option value="渝">渝</option>
                <option value="豫">豫</option>
                <option value="云">云</option>
                <option value="辽">辽</option>
                <option value="黑">黑</option>
                <option value="湘">湘</option>
                <option value="皖">皖</option>
                <option value="鲁">鲁</option>
                <option value="新">新</option>
                <option value="苏">苏</option>
                <option value="浙">浙</option>
                <option value="赣">赣</option>
                <option value="鄂">鄂</option>
                <option value="桂">桂</option>
                <option value="甘">甘</option>
                <option value="蒙">蒙</option>
                <option value="陕">陕</option>
                <option value="吉">吉</option>
                <option value="闽">闽</option>
                <option value="贵">贵</option>
                <option value="青">青</option>
                <option value="藏">藏</option>
                <option value="川">川</option>
                <option value="宁">宁</option>
                <option value="琼">琼</option>
            </select>
            <input type="text" class="fui-input" id="field_data5_1" name="field_data5" placeholder="请输入车牌号" value="">
        </div>
    </div>
    <div class="fui-cell must" data-must="1" data-type="0" data-name="车架号后6位" data-name2="" data-isdefault="0" data-itemid="field_data13" data-key="diyvin">
        <div class="fui-cell-label" style="padding-right: 15px;">
            车架号后6位            
        </div>
        <div class="fui-cell-info">
            <input type="text" class="fui-input" id="field_data13" name="field_data13" placeholder="请输入车架号后6位" value="">
        </div>
    </div>
    <div class="fui-cell must" data-must="1" data-type="0" data-name="品牌型号" data-name2="" data-isdefault="0" data-itemid="field_data6" data-key="diypinpaixinghao">
        <div class="fui-cell-label" style="padding-right: 15px;">
            品牌型号            
        </div>
        <div class="fui-cell-info">
            <input type="text" class="fui-input" id="field_data6" name="field_data6" placeholder="请输入品牌型号" value="">
        </div>
    </div>
    <div class="fui-cell must" data-must="1" data-type="3" data-name="车价水平" data-name2="" data-isdefault="0" data-itemid="field_data14" data-key="diyprice">
        <div class="fui-cell-label" style="padding-right: 15px;">
            车价水平            
        </div>
        <div class="fui-cell-info">
            <label class="checkbox-inline">
                <input type="checkbox" class="fui-checkbox fui-checkbox-danger" name="field_data14" checked="" value="30万以下"> 30万以下国产车（含合资） 
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="fui-checkbox fui-checkbox-danger" name="field_data14" value="30万以上"> 30万以上(进口车统一选此选项) 
            </label>
        </div>
    </div>
    <div class="fui-cell " data-must="0" data-type="13" data-name="注意：" data-name2="" data-isdefault="" data-itemid="field_data7" data-key="diyzhuyi">
        <div class="fui-cell-label" style="padding-right: 15px;">
            注意：            
        </div>
        <div class="fui-cell-info" style="white-space:normal;">
            确认该车辆为7座以下的轿车类，车价在30万以下，且可接受更换普通国产玻璃。 本协议服务专车专用，不得用于其它车辆。车辆照片拍摄要求（参照上方图片）：车辆左前45°，右后45°，前档（从外拍摄），前档（从内拍摄），VIN码（车架号）及行驶证照片，共6张照片。支持 jpg, png, gif, bmp, psd, tiff 等图片格式。    
        </div>
    </div>
    <div class="fui-cell">
        <div class="fui-cell-label" style="padding-right: 15px;">
            上传图片示例
        </div>
        <div class="fui-cell-info">
            <img src="../addons/ewei_shopv2/static/images/sample.jpg" style="width: 100%;">
        </div>
    </div>
    <div class="fui-cell must" data-must="1" data-type="5" data-name="上传照片" data-name2="" data-isdefault="" data-itemid="field_data8" data-key="diyshangchuanzhaopian">
        <div class="fui-cell-label" style="padding-right: 15px;">
            上传照片            
        </div>
        <div class="fui-cell-info">
            <ul class="fui-images fui-images-sm" id="field_data8_images">
                <li class="image image-sm">
                    <span class="image-remove">X</span>
                    <input type="hidden" name="field_data8[]">
                </li>
            </ul>
            <div class="fui-uploader fui-uploader-sm diyform-container-uploader" data-name="field_data8[]" data-max="5" data-count="2">
                <input type="button" name="imgFile8" id="imgFile8" onclick="takePicture(1);">
            </div>
        </div>
    </div>
    <div class="fui-cell " data-must="0" data-type="1" data-name="咔客会员玻璃服务协议" data-name2="" data-isdefault="" data-itemid="field_data9" data-key="diykehuiyuanbolifuwuxieyi">
        <div class="fui-cell-label" style="padding-right: 15px;">
            咔客会员玻璃服务协议            
        </div>
        <div class="fui-cell-info">
            <input type="button" style="width: 100%;color: #ccc;background: #fff;border: 0;" value="点击查看" onclick="$('#protocol').show()">
        </div>
        <div id="protocol" style="width: 100%;height: 100%;background: #fff;position: fixed;top: 0;left: 0;z-index: 1000;padding: 14vw 5vw 2vw;overflow: auto;display: none;">
            <div style="width: 100%;position: fixed;z-index: 1001;top: 0;left: 0;background: #fff;">
                <h3 style="text-align: center;line-height: 10vw;padding: 2vw 5vw;">咔客会员玻璃服务协议
                    <a href="javascript:void(0);" style="float: right;font-size: 10vw;color: #ccc" onclick="$('#protocol').hide();">&times;</a>
                </h3>
            </div>
            <div style="font-weight: 600;line-height: 6vw;">         
                <p>协议内容</p>    
                <p>第一条  服务价格及内容</p>    
                <p>在协议有效期内，福耀门店为会员免费提供以下服务；会员确认车辆价值在30万元以下，且可接受更换普通国产玻璃；专车专用，不得用于其他车辆。</p> 
                <table class="table" style="border: #ccc solid 2px;">
                    <tr>
                        <th style="border-right: #ccc solid 2px;">有效期</th>
                        <th style="border-right: #ccc solid 2px;">服务内容（汽车玻璃更换）</th>
                        <th>服务内容（前挡玻璃修补）</th>
                    </tr>
                    <tr>
                        <td style="border-right: #ccc solid 2px;border-top: #ccc solid 2px;">1年</td>
                        <td style="border-right: #ccc solid 2px;border-top: #ccc solid 2px;">免费更换5片/年</td>
                        <td style="border-top: #ccc solid 2px;">免费修补5次/年</td>
                    </tr>
                </table>        
                <p>第二条  更换范围</p>    
                <p>1、  会员车辆发生汽车玻璃单独破损情况时，在协议有效期内，福耀门店向会员提供免费的汽车玻璃更换服务。</p>    
                <p>2、  福耀门店提供免费更换的汽车玻璃包含前、后挡风玻璃、左右边窗玻璃及三角玻璃；不包含天窗玻璃、汽车灯玻璃、内视镜、后视镜等。</p>    
                <p>第三条  免责范围</p>   
                <p>1、  会员车辆玻璃因玻璃车框变形原因造成破损的，会员应先对车框进行修复，由于车框原因影响玻璃安装效果导致玻璃再次破损，福耀门店不提供汽车玻璃免费更换服务。</p>
                <p>2、  会员车辆玻璃因车辆维修、施工或交通事故造成破损的，会员应追究责任方责任，福耀门店不提供汽车玻璃免费更换服务。</p>    
                <p>3、  会员车辆玻璃破损在保险公司承担范围内，如因碰撞或不可抗力如战争、自然灾害（地震、台风、冰雹、沙尘暴等）等原因造成破损的，会员应向其投保的保险公司申请索赔，福耀门店不提供汽车玻璃免费更换服务。</p>    
                <p>第四条  产品范围</p>    
                <p>1、  福耀门店提供给会员的汽车玻璃以福耀品牌为主，如福耀配件玻璃没有生产该型号玻璃，福耀门店可向会员提供其他符合汽车玻璃国家标准质量要求的国产玻璃。</p>    
                <p>2、  福耀门店提供给会员的汽车玻璃仅普通国产玻璃，如会员选择更换钨丝加热、憎水、隔音、镀膜、进口等其他玻璃，需向服务门店补付产品差价。</p>    
                <p>3、  福耀门店仅提供汽车玻璃产品和更换服务，不提供贴膜产品和服务。如需在福耀门店贴膜，贴膜费用由会员自行承担。</p>    
                <p>4、  如会员损坏的汽车前挡玻璃符合修补条件（圆形及星形破点≤2cm；裂纹形状≤3.8cm），应先接受福耀门店提供的前挡玻璃修补服务。</p>    
                <p>第五条  验车</p>    
                <p>在协议签订前，福耀门店有权验证会员车辆状况，确认会员车辆玻璃是完整无破损的状态。
    会员可选择到店验车，或按要求拍照（行驶证、车辆的左前45度、右后45度、前挡、车架号及行驶证照片）并通过微信上传，经福耀门店确认后本权益开始生效。</p>    
                <p>第六条  违约责任</p>    
                <p>1、  如福耀门店提供的玻璃不符合汽车玻璃国家标准质量要求，会员有权要求福耀门店重新调换。</p>    
                <p>2、  如福耀门店发现会员存有舞弊行为，福耀门店有权不履行免费更换义务并可单方面无偿解除会员的更换权益。</p>    
                <p>3、  如在权益履行中，经福耀门店确认无法为会员车辆提供国产玻璃进行更换，则本权益立即终止，福耀门店向会员一次性支付人民币800元整，同时会员不可再次为该车辆购买玻璃更换权益。</p>    
                <p>4、  本协议如发生纠纷双方协商解决。协商不成，可向福耀门店所在地的人民法院诉讼。</p>         
                <p>第七条其他</p>    
                <p>1、会员可以在全国范围内三锋授权门店接受玻璃更换业务。具体门店地址可拨打400-988-6868咨询。</p>   
                <p style="text-align: center;">最终解释权归福建三锋汽车服务有限公司所有。</p>
            </div>
        </div>
    </div>
    <div class="fui-cell must" data-must="1" data-type="3" data-name="会员协议确认" data-name2="" data-isdefault="" data-itemid="field_data10" data-key="diyhuiyuanxieyiqueren">
        <div class="fui-cell-label" style="padding-right: 15px;">
            会员协议确认            
        </div>
        <div class="fui-cell-info">
            <label class="checkbox-inline">
                <input type="checkbox" class="fui-checkbox fui-checkbox-danger" name="field_data10" checked="" value="已确认"> 已确认 
            </label>
        </div>
    </div>
    <div class="fui-cell " data-must="0" data-type="3" data-name="发票" data-name2="" data-isdefault="" data-itemid="field_data11" data-key="diyfapiao">
        <div class="fui-cell-label" style="padding-right: 15px;">
            发票            
        </div>
        <div class="fui-cell-info">
            <label class="checkbox-inline">
                <input type="checkbox" class="fui-checkbox fui-checkbox-danger" name="field_data11" value="需要" onclick="check_select()"> 需要  
            </label>     
        </div>
    </div>
    <div id="taitou" class="fui-cell " data-must="0" data-type="1" data-name="" data-name2="" data-isdefault="" data-itemid="field_data12" data-key="diytaitou" style="display: none;">
        <div class="fui-cell-label" style="padding-right: 15px;">
        </div>
        <div class="fui-cell-info">
            <textarea class="" id="field_data12" name="field_data12" placeholder="如需发票，请输入公司名及纳税识别号"></textarea>      
        </div>
    </div>
    <script language="javascript">
        var new_area = 0;
        var address_street = 0;
        var showArea = false;

        var reqParams = ['foxui','foxui.picker'];
        if(new_area){
            reqParams = ['foxui','foxui.picker','foxui.citydatanew'];
        }

        if ($('.citypicker').attr('data-area') == 1) {
            showArea = true;
        }

        require(reqParams,function(){
            $('.diyform-container .datepicker').datePicker();
            $('.diyform-container .timepicker').timePicker();


            $('.diyform-container .citypicker').cityPicker({
                new_area: new_area,
                address_street: address_street,
                showArea:showArea,
                onShow:function(){

                                }
                ,onClose:function(){
                                }
            });
            $('.diyform-container .diyform-container-uploader').uploader({
                uploadUrl: "./index.php?i=8&c=entry&m=ewei_shopv2&do=mobile&r=util.uploader",
                removeUrl:"./index.php?i=8&c=entry&m=ewei_shopv2&do=mobile&r=util.uploader.remove"
            });
        })
        function check_select() {
            var a = $('input[name=field_data11]').is(':checked');
            if (a == true) {
                $('#taitou').show();
            }
            else{
                $('#taitou').hide();
            }
        }
        wx.ready(function () {
            // 在这里调用 API
            wx.checkJsApi({
              jsApiList: [
                'chooseImage',
                'uploadImage',
                'getLocalImgData',
                'downloadImage'
              ],
              success: function (res) {
                console.log(JSON.stringify(res));
              }
            });
        });
        function takePicture(nums) {  
           wx.chooseImage({  
               count: 1,  
               needResult: 1,  
               sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有  
               sourceType: ['camera'], // 可以指定来源是相册还是相机，默认二者都有  
               success: function (data) {                  
                   localIds = data.localIds[0];   // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片                           
                   var num1 = nums;
                   wxuploadImage(localIds,num1);
               },  
               fail: function (res) {            
                   alterShowMessage("操作提示", JSON.stringify(res), "1", "确定", "", "", "");  
                   }    
               });  
           }
        function wxuploadImage(e,num) {
            wx.uploadImage({  
                localId: e, // 需要上传的图片的本地ID，由chooseImage接口获得  
                isShowProgressTips: 1, // 默认为1，显示进度提示  
                success: function (res) {                                        
                    mediaId = res.serverId;                    
                    downImg(mediaId)          
                },  
                fail: function (error) {  
                    picPath = '';  
                    localIds = '';  
                    alert(Json.stringify(error));          
                }          
            });  
        }
        function downImg(id) {
            $.ajax({
                url:"<?php  echo mobileUrl(order/create/download)?>",
                data:{id:id},
                success:function(data) {
                    var res = $.parseJSON(data);
                    $('.image-sm').attr('background-image','url('+res.url+')');
                }
            })
        }
    </script>
</div>
<?php  } else { ?>
<div class="fui-cell-group">
    <div class="fui-cell fui-cell-textarea">
        <div class="fui-cell-label" style="margin:.15rem 0 0 0">
            买家留言
        </div>
        <div class="fui-cell-info c000">
            <textarea rows="2" placeholder="50字以内（选填）" id='remark'></textarea>
        </div>
    </div>
</div>
<?php  } ?>
<?php  if(empty($exchangeOrder) && empty($taskgoodsprice) && empty($packageid) && empty($if_bargain['bargain'])) { ?>
<div class="fui-cell-group">

    <div id='coupondiv' class="fui-cell fui-cell-click" <?php  if($couponcount<=0) { ?>style='display:none'<?php  } ?>>
    <div class='fui-cell-label' style='width:auto;'>优惠券</div>
    <div class='fui-cell-info'></div>
    <div class='fui-cell-remark'>
        <img id="couponloading" src="../addons/ewei_shopv2/static/images/loading.gif" style="vertical-align: middle;display: none;" width="20" alt=""/>
        <div class='badge badge-danger' <?php  if($couponcount<=0) { ?>style='display:none'<?php  } ?>><?php  echo $couponcount;?></div>
    <span class='text' <?php  if($couponcount>0) { ?>style='display:none'<?php  } ?>>无可用</span>
</div>
</div>


<?php  if($deductcredit>0) { ?>
<div class="fui-cell">
    <div class="fui-cell-label" style="width: auto;"> <span id="deductcredit_info" class='text-danger'><?php  echo $deductcredit;?></span> <?php  echo $_W['shopset']['trade']['credittext'];?>可抵扣 ￥<span id="deductcredit_money" class='text-danger'><?php  echo number_format($deductmoney,2)?></span> 元</div>
    <div class="fui-cell-info"></div>
    <div class="fui-cell-remark noremark"><input id="deductcredit" data-credit="<?php  echo $deductcredit;?>" data-money='<?php  echo $deductmoney;?>' type="checkbox" class="fui-switch fui-switch-small fui-switch-danger pull-right"></div>
</div>
<?php  } ?>
<?php  if($deductcredit2>0) { ?>
<div class="fui-cell">
    <div class="fui-cell-label" style="width: auto;"><?php  echo $_W['shopset']['trade']['moneytext'];?>可抵扣 <span id='deductcredit2_money' class="text-danger"><?php  echo number_format($deductcredit2,2)?></span>元</div>
    <div class="fui-cell-info"></div>
    <div class="fui-cell-remark noremark info"><input id="deductcredit2" data-credit2="<?php  echo $deductcredit2;?>" type="checkbox"  class="fui-switch fui-switch-small fui-switch-danger pull-right"></div>
</div>
<?php  } ?>
</div>

<?php  if(!empty($stores)) { ?>
<script language='javascript' src='https://api.map.baidu.com/api?v=2.0&ak=ZQiFErjQB7inrGpx27M1GR5w3TxZ64k7&s=1'></script>
<div class='fui-according-group'>
    <div class='fui-according expanded'>
        <div class='fui-according-header'>
            <!--<i class='icon icon-shop'></i>-->
            <span class="text">适用门店</span>
            <span class="remark" style="margin-right: .2rem"><div class="badge"><?php  echo count($stores)?></div></span>
        </div>
        <div class="fui-according-content store-container  fui-cell-group">
            <?php  if(is_array($stores)) { foreach($stores as $item) { ?>
            <!--<div  class="fui-list store-item" data-lng="<?php  echo floatval($item['lng'])?>" data-lat="<?php  echo floatval($item['lat'])?>">-->
                <!--<div class="fui-list-media">-->
                    <!--<i class='icon icon-shop'></i>-->
                <!--</div>-->
                <!--<div class="fui-list-inner store-inner">-->
                    <!--<div class="title"><span class='storename'><?php  echo $item['storename'];?></span></div>-->
                <!--</div>-->
                <!--<div class="fui-list-angle ">-->
                    <!--&lt;!&ndash;<?php  if(!empty($item['tel'])) { ?><a href="tel:<?php  echo $item['tel'];?>" class='external '><i class=' icon icon-phone' style='color:green'></i></a><?php  } ?>&ndash;&gt;-->
                    <!--&lt;!&ndash;<a href="<?php  echo mobileUrl('store/map',array('id'=>$item['id'],'merchid'=>$item['merchid']))?>" class='external' ><i class='icon icon-location' style='color:#f90'></i></a>&ndash;&gt;-->
                    <!---->
                <!--</div>-->
            <!--</div>-->
            <a  href="<?php  echo mobileUrl('store/detail',array('id'=>$item['id'],'merchid'=>$item['merchid']))?>"  class="fui-cell store-item external"
                data-lng="<?php  echo floatval($item['lng'])?>"
                data-lat="<?php  echo floatval($item['lat'])?>">
                <div class="fui-cell-icon">
                    <i class='icon icon-dingwei1'></i>
                </div>
                <div class="fui-cell-text">
                    <div class="title"><span class='storename'><?php  echo $item['storename'];?></span></div>
                </div>
                <div class="fui-cell-remark ">
                    查看
                </div>
            </a>
            <?php  } } ?>
            <?php  if(count($stores)>3) { ?>
            <div class='show-allshop'><span class='show-allshop-btn'>加载更多门店</span></div>
            <?php  } ?>
        </div>
        <div id="nearStore" style="display:none">
            <div class='fui-list store-item'  id='nearStoreHtml'></div>
        </div>
    </div></div>
<?php  } ?>
<?php  } ?>


<div class="fui-cell-group">
    <input type="hidden" id="weight" name='weight' value="<?php  echo $weight;?>" />
    <?php  if(!empty($exchangeOrder)) { ?>
    <div class="fui-cell">
        <div class="fui-cell-label" >兑换券</div>
        <div class="fui-cell-info"></div>
        <div class="fui-cell-remark noremark"><span style="color: red;">- &yen; <?php  echo number_format($exchangecha,2);?></span></div>
    </div>
    <?php  } ?>
    <div class="fui-cell">
        <div class="fui-cell-label" >商品小计</div>
        <div class="fui-cell-info"></div>
        <div class="fui-cell-remark noremark">&yen; <span class='<?php  if(!$packageid && empty($exchangeOrder)) { ?>goodsprice<?php  } ?>'>
            <?php  if(!empty($exchangeOrder)) { ?><?php  echo $exchangeprice;?><?php  } else if($taskgoodsprice) { ?><?php  echo $taskgoodsprice;?><?php  } else { ?><?php  echo number_format($goodsprice,2)?><?php  } ?>
        </span></div>
    </div>
    <?php  if(empty($exchangeOrder) && empty($taskgoodsprice)) { ?>
    <?php  if(!$packageid) { ?>
    <?php  if(empty($if_bargain['bargain'])) { ?>
    <div class="fui-cell"  style="display: none">
        <div class="fui-cell-label" style='width:auto' >重复购买优惠</div>
        <div class="fui-cell-info"></div>
        <div class="fui-cell-remark noremark">-￥<span id='showbuyagainprice' class='showbuyagainprice'></span></div>
        <input type="hidden" id='buyagain' class='buyagainprice'  value="<?php  echo number_format($buyagainprice,2)?>" />
    </div>
    <?php  } ?>
    <div class="fui-cell istaskdiscount"  style="display: none">
        <div class="fui-cell-label" style='width:auto' >任务活动优惠</div>
        <div class="fui-cell-info"></div>
        <div class="fui-cell-remark noremark">-&yen; <span id='showtaskdiscountprice' class='showtaskdiscountprice'></span></div>
        <input type="hidden" id='taskdiscountprice' class='taskdiscountprice'  value="<?php  echo number_format($taskdiscountprice,2)?>" />
    </div>

    <div class="fui-cell islotterydiscount"  style="display: none">
        <div class="fui-cell-label" style='width:auto' >游戏活动优惠</div>
        <div class="fui-cell-info"></div>
        <div class="fui-cell-remark noremark">-&yen; <span id='showlotterydiscountprice' class='showlotterydiscountprice'></span></div>
        <input type="hidden" id='lotterydiscountprice' class='lotterydiscountprice'  value="<?php  echo number_format($lotterydiscountprice,2)?>" />
    </div>

    <div class="fui-cell discount"  style="display: none">
        <div class="fui-cell-label" style='width:auto' >会员优惠</div>
        <div class="fui-cell-info"></div>
        <div class="fui-cell-remark noremark">-&yen; <span id='showdiscountprice' class='showdiscountprice'></span></div>
        <input type="hidden" id='discountprice' class='discountprice'  value="<?php  echo number_format($discountprice,2)?>" />
    </div>

    <div class="fui-cell isdiscount"  style="display: none">
        <div class="fui-cell-label" style='width:auto' >促销优惠</div>
        <div class="fui-cell-info"></div>
        <div class="fui-cell-remark noremark">-&yen; <span id='showisdiscountprice' class='showisdiscountprice'></span></div>
        <input type="hidden" id='isdiscountprice' class='isdiscountprice'  value="<?php  echo number_format($isdiscountprice,2)?>" />
    </div>

    <div class="fui-cell" id="deductenough" <?php  if(!$saleset['showenough']) { ?>style='display:none'<?php  } ?>>
    <div class="fui-cell-label" style='width:auto' >商城优惠 <span style="font-size: .6rem">：单笔满 ￥<span id="deductenough_enough"><?php  echo number_format($saleset['enoughmoney'],2)?></span> 元立减￥<?php  if($saleset['showenough']) { ?><?php  echo number_format($saleset['enoughdeduct'],2)?><?php  } ?></span></div>
    <div class="fui-cell-info"></div>
    <div class="fui-cell-remark noremark">-&yen; <span id='deductenough_money'><?php  if($saleset['showenough']) { ?><?php  echo number_format($saleset['enoughdeduct'],2)?><?php  } ?></span></div>
</div>

<div class="fui-cell" id="merch_deductenough" <?php  if(!$merch_saleset['merch_showenough']) { ?>style='display:none'<?php  } ?>>
<div class="fui-cell-label" style='width:auto' >商户单笔满 <span id="merch_deductenough_enough" class='text-danger'><?php  echo number_format($merch_saleset['merch_enoughmoney'],2)?></span> 元立减</div>
<div class="fui-cell-info"></div>
<div class="fui-cell-remark noremark">-&yen; <span id='merch_deductenough_money'><?php  if($merch_saleset['merch_showenough']) { ?><?php  echo number_format($merch_saleset['merch_enoughdeduct'],2)?><?php  } ?></span></div>
</div>

<div class="fui-cell" id="seckillprice"  <?php  if($seckill_price<=0) { ?>style="display: none"<?php  } ?>>
<div class="fui-cell-label" style='width:auto' >秒杀优惠</div>
<div class="fui-cell-info"></div>
<div class="fui-cell-remark noremark">-&yen; <span id="seckillprice_money"><?php  echo number_format($seckill_price,2)?></span></div>
</div>

<?php  } ?>

<?php  } ?>

<?php  if($liveprice>0) { ?>
    <input type="hidden" id="liveid" value="<?php  echo $liveid;?>" />
<?php  } ?>

<div class="fui-cell" id="showdispatchprice">
    <div class="fui-cell-label" >运费</div>
    <div class="fui-cell-info"></div>
    <div class="fui-cell-remark noremark">&yen; <span class='<?php  if(!$packageid && empty($exchangeOrder)) { ?>dispatchprice<?php  } ?>'><?php  if(!empty($exchangeOrder)) { ?><?php  echo $exchangepostage;?><?php  } else if($taskgoodsprice) { ?><?php  echo $taskgoodsprice;?><?php  } else { ?><?php  echo number_format($dispatch_price,2)?><?php  } ?></span></div>
</div>


<div class="fui-cell" id='coupondeduct_div' style='display:none'>
    <div class="fui-cell-label" style='width:auto' id='coupondeduct_text' ></div>
    <div class="fui-cell-info"></div>
    <div class="fui-cell-remark noremark">-&yen; <span id="coupondeduct_money">0</span></div>
</div>
</div>

</div>
<?php  if($isgift) { ?>
<div id='gift-picker-modal' style="margin:-100%;">
    <div class='gift-picker'>
        <div class="fui-cell-group fui-sale-group" style='margin-top:0;'>
            <div class="fui-cell">
                <div class="fui-cell-text dispatching">
                    请选择赠品:
                    <div class="dispatching-info" style="max-height:12rem;overflow-y: auto ">
                        <?php  if(is_array($gifts)) { foreach($gifts as $item) { ?>
                        <div class="fui-list goods-item align-start" data-giftid="<?php  echo $item['id'];?>">
                            <div class="fui-list-media">
                                <input type="radio" name="checkbox" class="fui-radio fui-radio-danger gift-item" value="<?php  echo $item['id'];?>" style="display: list-item;">
                            </div>
                            <div class="fui-list-inner">
                                <?php  if(is_array($item['gift'])) { foreach($item['gift'] as $gift) { ?>
                                <div class="fui-list">
                                    <div class="fui-list-media image-media" style="position: initial;">
                                        <a href="javascript:void(0);">
                                            <img class="round" src="<?php  echo tomedia($gift['thumb'])?>" data-lazyloaded="true">
                                        </a>
                                    </div>
                                    <div class="fui-list-inner">
                                        <a href="javascript:void(0);">
                                            <div class="text">
                                                <?php  echo $gift['title'];?>
                                            </div>
                                        </a>
                                    </div>
                                    <div class='fui-list-angle'>
                                        <span class="price">&yen;<del class='marketprice'><?php  echo $gift['marketprice'];?></del></span>
                                    </div>
                                </div>
                                <?php  } } ?>
                            </div>
                        </div>
                        <?php  } } ?>
                    </div>
                </div>
            </div>
            <div class='btn btn-danger block'>确定</div>
        </div>
    </div>
</div>
<?php  } ?>

<div class="fui-navbar order-create-checkout">
    <a href="javascript:;" class="nav-item total">
        <p style="color: #000"><?php  if($packageid) { ?><span class="text-danger" style="font-size: 0.6rem;">(套餐优惠&yen;<?php  echo number_format($marketprice-$goodsprice,2)?>)</span><?php  } ?>
            需付：<span class="text-danger  bigprice">&yen; <span class="<?php  if(!$packageid && empty($exchangeOrder)) { ?>totalprice<?php  } ?>">
                <?php  if(!empty($exchangeOrder)) { ?><?php  echo $exchangerealprice;?><?php  } else if($taskgoodsprice) { ?><?php  echo $taskgoodsprice;?><?php  } else { ?><?php  echo number_format($realprice,2)?><?php  } ?></span></span>
        </p>
    </a>
    <a href="javascript:;" class="nav-item btn btn-danger buybtn">立即支付</a>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('sale/coupon/util/picker', TEMPLATE_INCLUDEPATH)) : (include template('sale/coupon/util/picker', TEMPLATE_INCLUDEPATH));?>
<script language='javascript'>require(['biz/order/create'], function (modal) {modal.init(<?php  echo json_encode($createInfo)?>); });</script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!---yi fu yuan ma54mI5p2D5omA5pyJ-->