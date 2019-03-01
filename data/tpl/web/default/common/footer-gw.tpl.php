<?php defined('IN_IA') or exit('Access Denied');?>			</div>
		</div>
		<script type="text/javascript">
			require(['bootstrap']);
			

			<?php  if($_W['uid']) { ?>
				function checknotice() {
					$.post("<?php  echo url('utility/notice')?>", {}, function(data){
						var data = $.parseJSON(data);
						$('#notice-container').html(data.notices);
						$('#notice-total').html(data.total);
						if(data.total > 0) {
							$('#notice-total').css('background', '#ff9900');
						} else {
							$('#notice-total').css('background', '');
						}
						setTimeout(checknotice, 60000);
					});
				}
				checknotice();
			<?php  } ?>
		</script><!---易福源码网 www.efwww.com-->
		<div class="center-block footer" role="footer">
			<div class="text-center">
				<?php  if(empty($_W['setting']['copyright']['footerright'])) { ?><a href="/">关于微信</a>&nbsp;&nbsp;<a href="/">微信帮助</a><?php  } else { ?><?php  echo $_W['setting']['copyright']['footerright'];?><?php  } ?><?php  if(!empty($_W['setting']['copyright']['statcode'])) { ?>&nbsp; &nbsp; <?php  echo $_W['setting']['copyright']['statcode'];?><?php  } ?>
			</div>
			<div class="text-center">
				<?php  if(empty($_W['setting']['copyright']['footerleft'])) { ?>Powered by <a href="/"><b>微信</b></a> v<?php echo IMS_VERSION;?> &copy; <?php  } else { ?><?php  echo $_W['setting']['copyright']['footerleft'];?><?php  } ?>
			</div>
		</div>
	</div>
			<?php  if(!empty($_W['setting']['copyright']['statcode'])) { ?><?php  echo $_W['setting']['copyright']['statcode'];?><?php  } ?>

</body>
</html>
