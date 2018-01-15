<?php echo $this->fetch('header.html'); ?>
<div id="page-channel">
	<div class="col-1 w relative">
		<div class="float-layer absolute" area="float-layer" widget_type="area">
			<?php $this->display_widgets(array('page'=>'14032368727','area'=>'float-layer')); ?>
		</div>
    </div>
	<div class="col-2" area="full-width-area" widget_type="area">
    	<?php $this->display_widgets(array('page'=>'14032368727','area'=>'full-width-area')); ?>
    </div>
    <div class="col-3 w clearfix">
    	<div class="col-3-left" area="col-3-left" widget_type="area">
    	<?php $this->display_widgets(array('page'=>'14032368727','area'=>'col-3-left')); ?>
    	</div>
        <div class="col-3-right" area="col-3-right" widget_type="area">
    	<?php $this->display_widgets(array('page'=>'14032368727','area'=>'col-3-right')); ?>
    	</div>
    </div>
	<div class="col-4 w" area="width-area" widget_type="area">
    	<?php $this->display_widgets(array('page'=>'14032368727','area'=>'width-area')); ?>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>