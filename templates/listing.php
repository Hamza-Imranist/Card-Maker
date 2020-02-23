<?php $i = 0; foreach($files as $file) { $i++; if($i > 4) $i = 1; ?>
    <div class="col-md-3">
        <a href="?photo=<?= $file->name ?>&p=<?php echo $file->isDetails ? 'view' : 'edit' ?>"
           title="<?php echo !$file->isDetails ? 'This image needs to configure !' : ''?>">
            <div class="hidden-sm" style="height: 150px;overflow: hidden;<?php echo $file->isDetails ? '' : 'opacity: 0.4;'?>"
                 data-toggle="popover" data-trigger="hover" data-placement="<?php echo $i < 4 ? 'right' : 'left'?>"
                 data-html="true" data-content="<img style='width: 250px' src='<?php echo $file->fullPath; ?>' />">
                <img width="100%" class="thumbnail" src="<?php echo $file->fullPath; ?>" />
            </div>
            <div class="visible-sm" style="<?php echo $file->isDetails ? '' : 'opacity: 0.4;'?>">
                <img width="85%" class="thumbnail center-block" src="<?php echo $file->fullPath; ?>" />
            </div>
        <?php echo !$file->isDetails ? '<i class="fa fa-warning text-danger" style="position: absolute;top: 40px;left: 98px;font-size: 80px;opacity: 0.9;"></i>' : '';?>
        </a>
        <?php if (isAdmin) { ?>
        <a class="text-success" href='?photo=<?php echo $file->name ?>&p=edit'><i class="fa fa-pencil"></i></a>
        <a class="pull-right text-danger" 
           onclick="ask_b('Do you want to delete this image ?', '?photo=<?php echo $file->name ?>&p=delete');"
           href='#'><i class="fa fa-remove"></i></a>
        <?php } ?>
    </div>
<?php } if(isAdmin && empty($dontShowUploadBtn)) { ?>
<div class="clearfix"></div>
<br />
<div class="clearfix"></div>
<button type="button" class="btn btn-primary" onclick="goto('?p=new')">
    Add New Photo
</button>

<?php } ?>