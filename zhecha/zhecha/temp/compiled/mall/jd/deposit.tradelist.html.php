<?php echo $this->fetch('member.header.html'); ?> 
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<div class="content"> <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right"> <?php echo $this->fetch('member.curlocal.html'); ?>
    <?php echo $this->fetch('member.submenu.html'); ?>
    <div class="wrap">
      <div class="public table deposit">
        <div class="recordlist"> 
          <?php if ($this->_var['records']['list']): ?>
          <div class="notice-word">
            <p>显示所有交易记录</p>
          </div>
          <?php endif; ?>
          <div class="title clearfix">
            <form method="get" class="float-left">
              <input type="hidden" name="app" value="deposit" />
              <input type="hidden" name="act" value="tradelist" />
              <input type="text" name="add_time_from" id="add_time_from" value="<?php echo $_GET['add_time_from']; ?>" />
              <span>-</span>
              <input type="text" name="add_time_to" id="add_time_to" value="<?php echo $_GET['add_time_to']; ?>" />
              <input type="submit" class="btn-record" value="搜索" />
            </form>
          </div>
          <ul class="subtit">
            <li class="clearfix">
              <div class="time">创建日期</div>
              <div class="info">名称 | 备注</div>
              <div class="tradeNo">商户订单号 | 交易号</div>
              <div class="party">对方</div>
              <div class="amount">金额 | 明细</div>
              <div class="status">状态</div>
              <div class="detail">操作</div>
            </li>
          </ul>
          <div class="content"> 
            <?php $_from = $this->_var['records']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'record');if (count($_from)):
    foreach ($_from AS $this->_var['record']):
?>
            <ul>
              <li class="clearfix" style="<?php if ($this->_var['record']['refund']): ?> border-bottom:1px #ddd dotted;<?php endif; ?><?php if (in_array ( $this->_var['record']['refund']['status'] , array ( 'CLOSED' ) )): ?>color:gray<?php endif; ?>">
                <div class="time"><?php echo local_date("Y.m.d H.i.s",$this->_var['record']['add_time']); ?></div>
                <div class="info break-word"><?php echo sub_str($this->_var['record']['title'],30); ?></div>
                <div class="tradeNo"><span class="break-word"><?php echo $this->_var['record']['bizOrderId']; ?> | <?php echo $this->_var['record']['tradeNo']; ?></span></div>
                <div class="party center"><?php echo $this->_var['record']['partyInfo']['name']; ?></div>
                <div class="amount center"> <strong class="price"> 
                  <?php if ($this->_var['record']['flow'] == 'income'): ?> 
                  <span class="green">+<?php echo $this->_var['record']['amount']; ?></span> 
                  <?php else: ?> 
                  <span class="f60">-<?php echo $this->_var['record']['amount']; ?></span> 
                  <?php endif; ?> 
                  </strong> </div>
                <div class="status"> <span class="<?php if (in_array ( $this->_var['record']['status'] , array ( 'CLOSED' ) ) || in_array ( $this->_var['record']['refund']['status'] , array ( 'CLOSED' ) )): ?>gray <?php elseif (! in_array ( $this->_var['record']['status'] , array ( 'SUCCESS' ) )): ?>f60<?php endif; ?>"><?php echo $this->_var['record']['status_label']; ?></span> </div>
                <div class="detail"> <a target="_blank" href="<?php echo url('app=deposit&act=record&tradeNo=' . $this->_var['record']['tradeNo']. ''); ?>">查看</a> </div>
              </li>
            </ul>
            <?php if (in_array ( $this->_var['record']['refund']['status'] , array ( 'SUCCESS' ) )): ?>
            <ul class="refund gray clearfix">
              <li class="clearfix">
                <div class="time"></div>
                <div class="info break-word"> 
                  <?php if ($this->_var['record']['buyer_id'] == $this->_var['visitor']['user_id']): ?> 
                  退款 
                  <?php else: ?> 
                  退款给买家 
                  <?php endif; ?> 
                </div>
                <div class="tradeNo break-word"></div>
                <div class="party">
                &nbsp;
                </div>
                <div class="amount center"> <strong class="gray"> 
                  <?php if ($this->_var['record']['buyer_id'] == $this->_var['visitor']['user_id']): ?>+<?php else: ?>-<?php endif; ?><?php echo $this->_var['record']['refund']['amount']; ?></strong>
                </div>
                <div class="status"></div>
                <div class="detail"></div>
              </li>
            </ul>
            <?php endif; ?> 
            <?php endforeach; else: ?>
            <div class="notice-word mt10">
              <p class="yellow">没有交易记录</p>
            </div>
            <?php endif; unset($_from); ?><?php $this->pop_vars();; ?> 
          </div>
          <div class="mt10 clearfix"><?php echo $this->fetch('member.page.bottom.html'); ?></div>
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