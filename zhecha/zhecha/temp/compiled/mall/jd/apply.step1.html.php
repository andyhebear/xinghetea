<?php echo $this->fetch('top.html'); ?>
<script type="text/javascript">
$(function(){
	$("#agreement_next").click(function(){
		var agreement = $("#input_apply_agreement").prop('checked');
		if(agreement){
			location.href = 'index.php?app=apply&step=2';
			return;
		}else{
			alert('请阅读并同意入驻协议');
			return false;
		}
	});
});
</script>
<style type="text/css">
.w{width:990px;}
</style>
<div id="main" class="w-full">
	<div class="page-apply">
		<div class="w logo mt10">
			<p><a href="<?php echo $this->_var['site_url']; ?>" title="<?php echo $this->_var['site_title']; ?>"><img alt="<?php echo $this->_var['site_title']; ?>" src="<?php echo $this->_var['site_logo']; ?>" /></a></p>
		</div>
		<div class="w content clearfix">
			<div class="left">
				<div class="title">
					<h3>商家入驻申请</h3>
				</div>
				<ul class="list">
					<li><i></i>入驻流程</li>
					<li class="current"><i></i>签订入驻协议</li>
					<li><i></i>填写商家信息</li>
					<li><i></i>平台审核</li>
					<li><i></i>店铺开通</li>
				</ul>
				<div class="title">
					<h3>平台联系方式</h3>
				</div>
				<ul class="call">
					<li><span>电话：</span>400-8888888</li>
					<li><span>手机：</span>15888888888</li>
					<li><span>邮箱：</span>psmoban@psmb.com</li>
				</ul>
			</div>
			<div class="right">
				<div class="joinin-step">
				  <ul>
					<li class="first current"><span>签订入驻协议</span></li>
					<li><span>填写商家信息</span></li>
					<li><span>平台审核</span></li>
					<li class="last"><span>店铺开通</span></li>
				  </ul>
				</div>
				<div class="apply-agreement">
				  <h3>入驻协议</h3>
				  <div class="agreement-content"><?php echo $this->_var['setup_store']['content']; ?></div>
				  <div class="agreement-btn">
					<input id="input_apply_agreement" name="agreement" type="checkbox" checked="checked">
					<label for="input_apply_agreement">我已阅读并同意以上协议</label>
				  </div>
				  <div class="bottom"><a id="agreement_next" href="javascript:;" class="agreement_next">下一步，填写商家信息</a></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->fetch('footer.html'); ?>