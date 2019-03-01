<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .a-upload {
        width: 100px;
        height: 100px;
        position: relative;
        cursor: pointer;
        color: #888;
        background: #fafafa;
        overflow: hidden;
        display: inline-block;
        *display: inline;
        *zoom: 1;
        background: url(<?php  echo $_W['siteroot'];?>addons/ewei_shopv2/static/images/icon.png) no-repeat;
        background-size: 100% 100%;
    }

    .a-upload  input {
        position: absolute;
        right: 0;
        top: 0;
        opacity: 0;
        filter: alpha(opacity=0);
        cursor: pointer
    }

    .a-upload:hover {
        text-decoration: none
    }
</style>
<div class="page-heading"> <h2>会员审核重新提交</h2> </div>
<form action="./index.php"  method="post" class="form-horizontal table-search" role="form">
    <input type="hidden" name="c" value="site" />
    <input type="hidden" name="a" value="entry" />
    <input type="hidden" name="m" value="ewei_shopv2" />
    <input type="hidden" name="do" value="web" />
    <input type="hidden" name="r" value="order.vip.post" />
    <input type="hidden" name="id" value="<?php  echo $_GPC['id'];?>">
    <table class="table table-hover table-responsive">
        <thead class="navbar-inner">
            <tr>
                <td>
                    姓名：
                    <input type="text" name="name" value="<?php  echo $op['name'];?>" class="form-control">
                </td>
                <td>
                    性别：
                    <label><input type="radio" name="sex" value="男" <?php  if($op['sex'] == '男') { ?>checked="checked"<?php  } ?>>男</label>
                    <label><input type="radio" name="sex" value="女" <?php  if($op['sex'] == '女') { ?>checked="checked"<?php  } ?>>女</label>
                </td>
            </tr>
            <tr>
                <td>生日：<?php  echo tpl_form_field_date('birthday', $op['birthday']);?></td>
                <td>城市：<?php  echo tpl_form_field_district('address', array('province' => $address['0'],'city' => $address['1']));?></td>
            </tr>
            <tr>
                <th>
                    车牌号：
                    <select class="form-control" name="plate_0">
                        <option <?php  if($op['plate_0'] == '粤') { ?>selected="selected"<?php  } ?> value="粤">粤</option>
                        <option <?php  if($op['plate_0'] == '京') { ?>selected="selected"<?php  } ?> value="京">京</option>
                        <option <?php  if($op['plate_0'] == '沪') { ?>selected="selected"<?php  } ?> value="沪">沪</option>
                        <option <?php  if($op['plate_0'] == '津') { ?>selected="selected"<?php  } ?> value="津">津</option>
                        <option <?php  if($op['plate_0'] == '冀') { ?>selected="selected"<?php  } ?> value="冀">冀</option>
                        <option <?php  if($op['plate_0'] == '晋') { ?>selected="selected"<?php  } ?> value="晋">晋</option>
                        <option <?php  if($op['plate_0'] == '渝') { ?>selected="selected"<?php  } ?> value="渝">渝</option>
                        <option <?php  if($op['plate_0'] == '豫') { ?>selected="selected"<?php  } ?> value="豫">豫</option>
                        <option <?php  if($op['plate_0'] == '云') { ?>selected="selected"<?php  } ?> value="云">云</option>
                        <option <?php  if($op['plate_0'] == '辽') { ?>selected="selected"<?php  } ?> value="辽">辽</option>
                        <option <?php  if($op['plate_0'] == '黑') { ?>selected="selected"<?php  } ?> value="黑">黑</option>
                        <option <?php  if($op['plate_0'] == '湘') { ?>selected="selected"<?php  } ?> value="湘">湘</option>
                        <option <?php  if($op['plate_0'] == '皖') { ?>selected="selected"<?php  } ?> value="皖">皖</option>
                        <option <?php  if($op['plate_0'] == '鲁') { ?>selected="selected"<?php  } ?> value="鲁">鲁</option>
                        <option <?php  if($op['plate_0'] == '新') { ?>selected="selected"<?php  } ?> value="新">新</option>
                        <option <?php  if($op['plate_0'] == '苏') { ?>selected="selected"<?php  } ?> value="苏">苏</option>
                        <option <?php  if($op['plate_0'] == '浙') { ?>selected="selected"<?php  } ?> value="浙">浙</option>
                        <option <?php  if($op['plate_0'] == '赣') { ?>selected="selected"<?php  } ?> value="赣">赣</option>
                        <option <?php  if($op['plate_0'] == '鄂') { ?>selected="selected"<?php  } ?> value="鄂">鄂</option>
                        <option <?php  if($op['plate_0'] == '桂') { ?>selected="selected"<?php  } ?> value="桂">桂</option>
                        <option <?php  if($op['plate_0'] == '甘') { ?>selected="selected"<?php  } ?> value="甘">甘</option>
                        <option <?php  if($op['plate_0'] == '蒙') { ?>selected="selected"<?php  } ?> value="蒙">蒙</option>
                        <option <?php  if($op['plate_0'] == '陕') { ?>selected="selected"<?php  } ?> value="陕">陕</option>
                        <option <?php  if($op['plate_0'] == '吉') { ?>selected="selected"<?php  } ?> value="吉">吉</option>
                        <option <?php  if($op['plate_0'] == '闽') { ?>selected="selected"<?php  } ?> value="闽">闽</option>
                        <option <?php  if($op['plate_0'] == '贵') { ?>selected="selected"<?php  } ?> value="贵">贵</option>
                        <option <?php  if($op['plate_0'] == '青') { ?>selected="selected"<?php  } ?> value="青">青</option>
                        <option <?php  if($op['plate_0'] == '藏') { ?>selected="selected"<?php  } ?> value="藏">藏</option>
                        <option <?php  if($op['plate_0'] == '川') { ?>selected="selected"<?php  } ?> value="川">川</option>
                        <option <?php  if($op['plate_0'] == '宁') { ?>selected="selected"<?php  } ?> value="宁">宁</option>
                        <option <?php  if($op['plate_0'] == '琼') { ?>selected="selected"<?php  } ?> value="琼">琼</option>
                    </select>
                    <input type="text" name="plate_1" value="<?php  echo $op['plate_1'];?>" class="form-control">
                </th>
                <th>
                    车架号后6位：
                    <input type="text" name="vin" value="<?php  echo $op['vin'];?>"  class="form-control">
                </th>
            </tr>
            <tr>
                <th>
                    品牌型号：
                    <input type="text" name="brand" value="<?php  echo $op['brand'];?>"  class="form-control">
                </th>
                <th>
                    车价水平：
                    <label><input type="radio" name="price" value="30万以下" <?php  if($op['price'] == '30万以下') { ?>checked="checked"<?php  } ?>>30万以下</label>
                    <label><input type="radio" name="price" value="30万以上" <?php  if($op['price'] == '30万以上') { ?>checked="checked"<?php  } ?>>30万以上</label>
                </th>
            </tr>
            <tr>
                <th>
                    发票：
                    <label><input type="checkbox" name="invoice" value="需要" <?php  if($op['invoice'] == '需要') { ?>checked="checked"<?php  } ?>>需要</label>
                </th>
                <th>
                    发票抬头：
                    <input type="text" name="invoice_title" value="<?php  echo $op['invoice_title'];?>"  class="form-control">
                </th>
            </tr>
            <tr>
                <th colspan="2">上传照片：</th>
            </tr>
            <tr>
                <td colspan="2" id="thumb_div">
                    <?php  if(is_array($op['thumb'])) { foreach($op['thumb'] as $img) { ?>
                    <div style="float: left;margin-right: 20px;margin-bottom: 10px;" class="show">
                        <a href="javascript:void(0);" style="width: 15px;height: 15px;background: red;color: #fff;display: block;position: absolute;text-align: center;line-height: 15px;" onclick="$(this).parent('div').remove();">
                            <span>&times;</span>
                        </a>
                        <img style='width:100px;padding:1px;border:1px solid #ccc;' src="../attachment/<?php  echo $img;?>">
                        <input type="hidden" name="thumb[]" value="<?php  echo $img;?>">
                    </div>
                    <?php  } } ?>
                    <div style="float: left;" class="show">
                        <a href="javascript:void(0);" class="a-upload">
                            <input type="file" name="fileUpload" id="fileUpload" accept="image/*" style="width: 100%;height: 100%;">
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style="margin: 0 auto;width: 15%;">
                        <input type="submit" name="submit" value="提交" class="btn btn-primary">
                        <input type="button" name="cancel" value="取消" class="btn btn-red" onclick="window.history.back();">
                    </div>
                </td>
            </tr>
        </thead>

    </table>
</form>
<script type="text/javascript" src="../addons/ewei_shopv2/static/js/ajaxfileupload.js"></script>
<script type="text/javascript">
    $(document).on('change','#fileUpload',function() {
        ajaxFileUpload();
    });
    function ajaxFileUpload() {
        $.ajaxFileUpload({
            url:"<?php  echo webUrl('order.vip.upload')?>",
            secureuri: false,
            fileElementId: 'fileUpload',
            dataType: 'json',
            success: function (data, status) {
                console.log(data);
                var txt = '<div style="float: left;margin-right: 20px;margin-bottom: 10px;" class="show">';
                    txt += '<a href="javascript:void(0);" style="width: 15px;height: 15px;background: red;color: #fff;display: block;position: absolute;text-align: center;line-height: 15px;" onclick="$(this).parent('+'div'+').remove();">';
                    txt += '<span>&times;</span>';
                    txt += '</a>';
                    txt += '<img style="width:100px;padding:1px;border:1px solid #ccc;" src="'+data.url+'">';
                    txt += '<input type="hidden" name="thumb[]" value="'+data.value+'">';
                    txt += '</div>';
                $('.a-upload').before(txt);

            },
            error: function (data, status, e) {
                // var html='<div class="title">提示</div><div>' + e + '</div>';
                alert(e);
                return false;
            }
        });
        return false;
    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>