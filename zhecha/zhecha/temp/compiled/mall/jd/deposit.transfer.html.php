<?php echo $this->fetch('member.header.html'); ?>

<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
    	<?php echo $this->fetch('member.curlocal.html'); ?>
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public table deposit">
            	<div class="deposit-withdraw">
                	<?php if ($this->_var['deposit_account']['money'] > 0): ?>
                	<div class="notice-word"><p class="yellow">将您的账户余额转出到另外的预存款账户上，请慎重填写。</p></div>
                	<form method="get">
                    	<input type="hidden" name="app" value="deposit" />
                        <input type="hidden" name="act" value="transfer_confirm" />
                    	<div class="title clearfix">
                        	<h2 class="float-left">您的账户（<?php echo $this->_var['deposit_account']['account']; ?>）</h2>
                            <p class="float-left">余额：<strong><?php echo $this->_var['deposit_account']['money']; ?></strong> 元</p>
                        </div>
                		<div class="form">
                			<dl class="clearfix">
                        		<dt>转入账户：</dt>
                            	<dd>
                                	<input type="text" class="text" name="account" />
                                </dd>
                        	</dl>
                            <dl class="clearfix">
                        		<dt>转账金额：</dt>
                            	<dd><input type="text" name="money" class="text" value="" /> 元</dd>
                        	</dl>
                            <dl class="clearfix">
                        		<dt>&nbsp;</dt>
                            	<dd class="submit">
                                	<span class="btn-alipay">
                                		<input type="submit" value="下一步" />
                                    </span>
                                </dd>
                        	</dl>
                		</div>
					</form>
                    <?php else: ?>
                    <div class="notice-word"><p>您目前账户余额为<span class="f60">0</span>元，不能转账。</p></div>
                    <?php endif; ?>
				</div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>

    <div class="clear"></div>
</div>
<iframe id='iframe_post' name="iframe_post" src="about:blank" frameborder="0" width="0" height="0"></iframe>
<?php echo $this->fetch('footer.html'); ?>
