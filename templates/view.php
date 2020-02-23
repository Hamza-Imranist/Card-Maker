<?php if($orginalName) { ?>
<a href="<?php echo sitePath('?photo='.$orginalName.'&p=view')?>" type="button" class="btn btn-primary">
    Create your own card
</a>
<?php } ?>
<div class="text-center">
    <img src="<?php echo sitePath('__temp/'.$_GET['path'])?>" class="thumbnail center-block" />
</div>
<?php if($orginalName) { ?>
<a href="<?php echo sitePath('?photo='.$orginalName.'&p=view')?>" type="button" class="btn btn-primary">
    Create your own card
</a>
<?php } ?>