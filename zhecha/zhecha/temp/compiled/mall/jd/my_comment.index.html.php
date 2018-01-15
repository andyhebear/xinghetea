<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
    	<?php echo $this->fetch('member.curlocal.html'); ?>
        <?php echo $this->fetch('member.submenu.html'); ?>
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.plugins/jquery.validate.js'; ?>" charset="<?php echo $this->_var['charset']; ?>"></script>
        <div class="wrap">
            <div class="public_index table1">
                <table>
                    <?php $_from = $this->_var['my_comment_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'my_comment_list');$this->_foreach['my_comment'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['my_comment']['total'] > 0):
    foreach ($_from AS $this->_var['my_comment_list']):
        $this->_foreach['my_comment']['iteration']++;
?>
                    <tr class="bgcolor">
                        <td class="align2"></td>
                        <td>
                        <a  href="<?php echo url('app=goods&id=' . $this->_var['my_comment_list']['goods_id']. '&store_id=' . $this->_var['store_id']. ''); ?>" target="_blank" class="link3"><?php echo $this->_var['my_comment_list']['goods_name']; ?></a> 
                        </td>
                        <td width="150">
                            <span class="table_user"><?php echo htmlspecialchars($this->_var['my_comment_list']['buyer_name']); ?></span></td>
                        <td>
                            <?php if ($this->_var['my_comment_list']['reply_content'] == ''): ?><a  href="javascript:void(0);" class="add1_ico reply" ectype="dialog" dialog_id="my_comment_reply" dialog_title="回复评价" dialog_width="400" uri="index.php?app=my_comment&amp;act=reply&amp;rec_id=<?php echo $this->_var['my_comment_list']['rec_id']; ?>">回复</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="20"></td>
                        <td>
                            <strong>评价内容:</strong>
                            <span><?php echo htmlspecialchars($this->_var['my_comment_list']['comment']); ?></span>
                        </td>
                        <td><span class="time"><?php echo local_date("Y-m-d H:i:s",$this->_var['my_comment_list']['evaluation_time']); ?></span></td>
                        <td></td>
                    </tr>
                    <?php if ($this->_var['my_comment_list']['reply_content'] != ''): ?>
                    <tr <?php if (($this->_foreach['my_comment']['iteration'] == $this->_foreach['my_comment']['total'])): ?>class="line_bold"<?php endif; ?>>
                        <td height="40"></td>
                        <td>
                            <strong><span class="color8">我的回复:</span></strong>
                            <span class="color3"><?php echo htmlspecialchars($this->_var['my_comment_list']['reply_content']); ?></span>
                        </td>
                        <td><span class="time"><?php echo local_date("Y-m-d H:i:s",$this->_var['my_comment_list']['reply_time']); ?></span></td>
                        <td></td>
                    </tr>
                    <?php else: ?>
                    <?php if (($this->_foreach['qa']['iteration'] == $this->_foreach['qa']['total'])): ?>
                    <tr class="line_bold">
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4"><div class="notice-word"><p>没有符合条件的记录</p></div></td></tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['my_comment_data']): ?>
                    <tr>
                        <th></th>
                        <th colspan="3">
                                <?php echo $this->fetch('member.page.bottom.html'); ?>
                            </p>
                        </th>
                    </tr>
                    <?php endif; ?>
                </table>
              </div>
            <iframe name="pop_warning" style="display:none;"></iframe>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>