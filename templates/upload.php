<div class="col-md-12" id="files"></div>
<div class="col-md-12">
    <div class="progress hidden" id="progress-wrp">
        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
            <span class="sr-only">0% Complete</span>
        </div>
    </div>
</div>
<div class="col-md-3"></div>
<div class="col-md-3">
    <label class="btn btn-lg btn-primary center-block">
        <i class="fa fa-folder-open"></i>
        Browse
        <input type="file" accept="image/*" class="hidden" name="theFile" multiple />
    </label>
</div>
<div class="col-md-3">        
    <button class="btn btn-lg btn-success center-block" id="upload" disabled="disabled" onclick="upload()" style="width: 100%">
        <i class="fa fa-upload"></i>
        Upload
    </button>
</div>
<?php $files = listing(true);
if(count($files) > 0) { 
?>
<div class="col-md-3"></div>
<div class="col-md-12">
    <h2>New Images needs to configure</h2>
    <?php
    
    $dontShowUploadBtn = true;
    include 'listing.php';
    ?>
</div>
<?php } ?>

<!--Start Uploaded Images template-->
<script type="text/template" id="fileShow">
    <div class="col-md-3" id="imgs_{i}" style="margin-bottom: 30px;">
        <img src="{data}" title="{name}" style="width: 140px;height: 140px;margin-bottom: 2px;" class="thumbnail" />
        <button type="button" class="btn btn-danger"onclick="removeImage({i})">
            <i class="fa fa-remove"></i>
            Remove
        </button>
    </div>
</script>
<!--End Uploaded Images template-->