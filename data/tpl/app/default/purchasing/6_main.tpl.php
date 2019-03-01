<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">公告：<?php  echo $notice['content'];?></h3>
    </div>
    <div class="panel-body">
    	<div class="col-xs-6">
        	<p>account：<?php  echo $manager['account'];?></p>
			password：<input type="text" name="password" style="margin-right: 5px;"><button type="button" onclick="set_password()">save</button>
			<p>last login time：<?php  echo date('Y-m-d H:i:s',$manager['last_login_time']);?></p>
			<p>last login ip：<?php  echo $manager['last_login_ip'];?></p>
        </div>
    	<?php  if($_SESSION['level'] == 1) { ?>
        <div class="col-xs-6">
        	<p>网站公告</p>
    		<textarea placeholder="请输入文字" style="width: 15vw;height: 15vh;" id="notice"></textarea>
    		<button type="button" onclick="set_notice();">保存</button>
        </div>
        <?php  } ?>
    </div>
</div>
<script type="text/javascript">
	function set_password() {
		password = $('input[name=password]').val();
		$.post("<?php  echo $this->createMobileUrl('main',array('op'=>'password'))?>",{password:password},function(result) {
			alert(result.info);
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
    function set_notice() {
        var notice = $('#notice').val();
        $.post("<?php  echo $this->createMobileUrl('main',array('op'=>'notice'))?>",{notice:notice},function(result) {
            alert(result.info);
            if (result.status == 1) {
                window.location.reload();
            }
        },'JSON')
    }
</script>