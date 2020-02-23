<?php


function show()
{
    $appendingLimit = 10;
    $fonts = include 'google-fonts.php';
    $fileExists = false;
    $path = $GLOBALS['config']['dir'].'/';
    $photo = (object) [
        'name' => $_GET['photo'],
        'path' => $path.$_GET['photo'],
        'textName' => 'Your Name',
        'widthName' => '100',
        'leftName' => '10',
        'topName' => '10',
        'textAlign' => 'left',
        'textColorName' => '#790897',
        'textLengthName' => '100',
        'borderColorName' => '#000000',
        'fontName' => $fonts[0],
        'fontSizeName' => 25,
        'borderSizeName' => 1,
        'imgWidthName' => 100,
        'imgHeightName' => 100,
        'appendName' => 0,
    ];
    $photo2 = (object) [
        'name' => $_GET['photo'],
        'path' => $path.$_GET['photo'],
        'textProfession' => 'Your Profession',
        'widthProfession' => '100',
        'leftProfession' => '10',
        'topProfession' => '10',
        'textAlign' => 'left',
        'textColorProfession' => '#978093',
        'textLengthProfession' => '100',
        'borderColorProfession' => '#000000',
        'fontProfession' => $fonts[0],
        'fontSizeProfession' => 15,
        'borderSizeProfession' => 1,
        'imgWidthProfession' => 100,
        'imgHeightProfession' => 100,
        'appendProfession' => 0,
    ];
    
    if(!empty($_POST) && isAdmin)
    {
        if(!demoMode)
        {
            
            foreach($photo as $k=>$v)
            {
                if(isset($_POST[$k]))
                {
                    $photo->{$k} = $_POST[$k];
                }
            }
            foreach($photo2 as $k=>$v)
            {
                if(isset($_POST[$k]))
                {
                    $photo2->{$k} = $_POST[$k];
                }
            }
            $status = @file_put_contents($path.$_GET['photo'].'.json', json_encode($_POST));
            if($status)
            {
                ?>
                <div class="alert alert-success">
                    <i class="fa fa-check"></i>
                    Data Saved success
                </div>
                <?php
            }
            $fileExists = true;
        }
        else
        {
            showDemoMode();
        }
    }
    elseif(file_exists($path.$_GET['photo'].'.json'))
    {
        $fileExists = true;
        $photoData = file_get_contents($path.$_GET['photo'].'.json');
        $photoData = json_decode($photoData);
        
        foreach($photoData as $k=>$v)
        {
            $photo->{$k} = $v;
        }
        foreach($photoData as $k=>$v)
        {
            $photo2->{$k} = $v;
        }
    }
    include 'templates/editor.php';
    ?>        



<script type="text/javascript">

    var imgConfgName = <?php echo json_encode($photo); ?>;
    var imgConfgProfession = <?php echo json_encode($photo2); ?>;
    var data = [imgConfgName, imgConfgProfession];
    


    function loadsName(editorName)
    {
            $("#photoTextName").keyup(function()
            {
                editorName.modifyTextName(this.value);
                imgConfgName.textName = this.value;
            }).keyup();

            $("#textFontName").change(function()
            {
                var font = $(this).val();
                imgConfgName.fontName = editorName.modifyFontName(font);
            }).change();
            $("#photoTextWidthName").change(function()
            {
                var nm = parseFloat($(this).val());
                if(nm && nm > 0)
                {
                    imgConfgName.widthName = editorName.modifyWidthName(nm);
                    $(this).val(imgConfgName.widthName);
                }
            }).keyup(function()
            {
                $(this).change();
            }).click(function()
            {
                $(this).change();
            }).change();
            $("#fontSizeName").blur(function()
            {
                var nm = parseFloat($(this).val());
                if(nm && nm > 0)
                {
                    imgConfgName.fontSizeName = editorName.modifyFontSizeName(nm);
                    $(this).val(imgConfgName.fontSizeName);
                }
            });
            editorName.modifyFontSizeName(parseFloat(imgConfgName.fontSizeName));
            
            $("#borderSizeName").change(function()
            {
                var nm = parseFloat($(this).val());
                if(nm && nm > 0)
                {
                    imgConfgName.borderSizeName = editorName.modifyBorderName(imgConfgName.borderColorName, nm);
                    $(this).val(imgConfgName.borderSizeName);
                }
            }).keyup(function()
            {
                $(this).change();
            }).click(function()
            {
                $(this).change();
            }).change();

            $("#textLengthName").blur(function()
            {
                var nm = parseFloat($(this).val());
                if(nm && nm > 0)
                {
                    var v = $("#photoTextName").val();
                    v = v.substr(0, nm);
                    $("#photoTextName").val(v).keyup();
                    imgConfgName.textLength = nm;
                    $("#photoTextName").prop('maxlength', imgConfgName.textLength).attr('maxlength', imgConfgName.textLength);
                }
            });

            function textAppendingName(that)
            {
                var valueName = $(that).attr('target');
                if(!imgConfgName.appendName) imgConfgName.appendName = 0;
                imgConfgName.appendName += parseInt(valueName);
                
                if(imgConfgName.appendName <= 0)
                {
                    imgConfgName.appendName = 0;
                    $("#appendName button:eq(0)").prop('disabled', true);
                }
                else $("#appendName button:eq(0)").prop('disabled', false);
                
               
                if(imgConfgName.appendName >= imgConfgName.widthName - 10)
                {
                    imgConfgName.appendName = imgConfgName.widthName - 10;
                    $("#appendName button:eq(1)").prop('disabled', true);
                }
                else $("#appendName button:eq(1)").prop('disabled', false);
                editorName.modifyAppendName(imgConfgName.appendName);
                
                $("#appendName input").val(valueName);
            }
            
            var selectedThat = null;
            window.setInterval(function()
            {
               if(selectedThat) textAppendingName(selectedThat);
            }, 50);
            
            $("#appendName button").mousedown(function()
            {
                selectedThat = this;
            }).mouseup(function()
            {
                selectedThat = null;
            })
            .on('touchstart', function(){
                selectedThat = this;
            })
            .on('touchend', function(){
                selectedThat = null;
            });
            editorName.modifyAppendName(parseInt(imgConfgName.appendName));

            if(!imgConfgName.textAlign) imgConfgName.textAlign = 'left';
            editorName.modifyAlignName(imgConfgName.textAlign);
            $("#textAlign [target='" + imgConfgName.textAlign + "']").addClass('active');

            $("#textColorName").spectrum({
                showButtons: false,
                color: imgConfgName.textColorName,
                change: function(color)
                {
                    imgConfgName.textColorName = color.toHexString();
                    editorName.modifyColorName(imgConfgName.textColorName);
                    $('[name="textColorName"]').val(color.toHexString());
                }
            });
            
            editorName.modifyColorName(imgConfgName.textColorName);
            $("#borderColorName").spectrum({
                showButtons: false,
                color: imgConfgName.borderColorName,
                change: function(color)
                {
                    imgConfgName.borderColorName = color.toHexString();
                    editorName.modifyBorderName(imgConfgName.borderColorName, imgConfgName.borderSizeName);
                    $('[name="borderColorName"]').val(color.toHexString());
                }
            });
            editorName.modifyBorderName(imgConfgName.borderColorName, imgConfgName.borderSizeName);
        }
    var editorName = $("#preview").photoPreview({
        view: <?php echo isAdmin && $_GET['p'] == 'edit' ? 'false' : 'true'?>,
        onStopName: function(ui)
        {
            imgConfgName.leftName = ui.position.left;
            imgConfgName.topName = ui.position.top;
            $("#leftPosName").val(imgConfgName.leftName);
            $("#topPosName").val(imgConfgName.topName);
        },
        onLoadName: function(editor, options)
        {
            imgConfgName.imgWidthName = options.width;
            imgConfgName.imgHeightName = options.height;
            $("#imgHeightName").val(imgConfgName.imgHeightName);
            $("#imgWidthName").val(imgConfgName.imgWidthName);
            loadsName(editorName);
        },
        top: imgConfgName.topName,
        left: imgConfgName.leftName,
    });




    function loadsProfession(editorProfession)
    {
            $("#photoTextProfession").keyup(function()
            {
                editorProfession.modifyText(this.value);
                imgConfgProfession.textProfession = this.value;
            }).keyup();

            $("#textFontProfession").change(function()
            {
                var font = $(this).val();
                imgConfgProfession.fontProfession = editorProfession.modifyFont(font);
            }).change();
            $("#photoTextWidthProfession").change(function()
            {
                var nm = parseFloat($(this).val());
                if(nm && nm > 0)
                {
                    imgConfgProfession.widthProfession = editorProfession.modifyWidth(nm);
                    $(this).val(imgConfgProfession.widthProfession);
                }
            }).keyup(function()
            {
                $(this).change();
            }).click(function()
            {
                $(this).change();
            }).change();
            $("#fontSizeProfession").blur(function()
            {
                var nm = parseFloat($(this).val());
                if(nm && nm > 0)
                {
                    imgConfgProfession.fontSizeProfession = editorProfession.modifyFontSize(nm);
                    $(this).val(imgConfgProfession.fontSizeProfession);
                }
            });
            editorProfession.modifyFontSize(parseFloat(imgConfgProfession.fontSizeProfession));
            
            $("#borderSizeProfession").change(function()
            {
                var nm = parseFloat($(this).val());
                if(nm && nm > 0)
                {
                    imgConfgProfession.borderSizeProfession = editorProfession.modifyBorder(imgConfgProfession.borderColorProfession, nm);
                    $(this).val(imgConfgProfession.borderSizeProfession);
                }
            }).keyup(function()
            {
                $(this).change();
            }).click(function()
            {
                $(this).change();
            }).change();

            $("#textLengthProfession").blur(function()
            {
                var nm = parseFloat($(this).val());
                if(nm && nm > 0)
                {
                    var v = $("#photoTextProfession").val();
                    v = v.substr(0, nm);
                    $("#photoTextProfession").val(v).keyup();
                    imgConfgProfession.textLength = nm;
                    $("#photoTextProfession").prop('maxlength', imgConfgProfession.textLength).attr('maxlength', imgConfgName.textLength);
                }
            });

            function textAppendingProfession(that)
            {
                var valueProfession = $(that).attr('target');
                if(!imgConfgProfession.appendProfession) imgConfgProfession.appendProfession = 0;
                imgConfgProfession.appendProfession += parseInt(valueProfession);
                
                if(imgConfgProfession.appendProfession <= 0)
                {
                    imgConfgProfession.appendProfession = 0;
                    $("#appendProfession button:eq(0)").prop('disabled', true);
                }
                else $("#appendProfession button:eq(0)").prop('disabled', false);
                
               
                if(imgConfgProfession.appendProfession >= imgConfgProfession.widthProfession - 10)
                {
                    imgConfgProfession.appendProfession = imgConfgProfession.widthProfession - 10;
                    $("#appendProfession button:eq(1)").prop('disabled', true);
                }
                else $("#appendProfession button:eq(1)").prop('disabled', false);
                editorProfession.modifyAppend(imgConfgProfession.appendProfession);
                
                $("#appendProfession input").val(valueProfession);
            }
            
            var selectedThat = null;
            window.setInterval(function()
            {
               if(selectedThat) textAppendingProfession(selectedThat);
            }, 50);
            
            $("#appendProfession button").mousedown(function()
            {
                selectedThat = this;
            }).mouseup(function()
            {
                selectedThat = null;
            })
            .on('touchstart', function(){
                selectedThat = this;
            })
            .on('touchend', function(){
                selectedThat = null;
            });
            editorProfession.modifyAppend(parseInt(imgConfgProfession.appendProfession));

            if(!imgConfgProfession.textAlign) imgConfgProfession.textAlign = 'left';
            editorProfession.modifyAlign(imgConfgProfession.textAlign);
            $("#textAlign [target='" + imgConfgProfession.textAlign + "']").addClass('active');

            $("#textColorProfession").spectrum({
                showButtons: false,
                color: imgConfgProfession.textColorProfession,
                change: function(color)
                {
                    imgConfgProfession.textColorProfession = color.toHexString();
                    editorProfession.modifyColor(imgConfgProfession.textColorProfession);
                    $('[name="textColorProfession"]').val(color.toHexString());
                }
            });
            
            editorProfession.modifyColor(imgConfgProfession.textColorProfession);
            $("#borderColorProfession").spectrum({
                showButtons: false,
                color: imgConfgProfession.borderColorProfession,
                change: function(color)
                {
                    imgConfgProfession.borderColorProfession = color.toHexString();
                    editorProfession.modifyBorder(imgConfgProfession.borderColorProfession, imgConfgProfession.borderSizeProfession);
                    $('[name="borderColorProfession"]').val(color.toHexString());
                }
            });
            editorProfession.modifyBorder(imgConfgProfession.borderColorProfession, imgConfgProfession.borderSizeProfession);
        }
    var editorProfession = $("#preview").photoPreview({
        view: <?php echo isAdmin && $_GET['p'] == 'edit' ? 'false' : 'true'?>,
        onStopProfession: function(ui)
        {
            imgConfgProfession.leftProfession = ui.position.left;
            imgConfgProfession.topProfession = ui.position.top;
            $("#leftPosProfession").val(imgConfgProfession.leftProfession);
            $("#topPosProfession").val(imgConfgProfession.topProfession);
        },
        onLoadProfession: function(editorProfession, options)
        {
            imgConfgProfession.imgWidthProfession = options.width;
            imgConfgProfession.imgHeightProfession = options.height;
            $("#imgHeightProfession").val(imgConfgProfession.imgHeightProfession);
            
            
            $("#imgWidthProfession").val(imgConfgProfession.imgWidthProfession);
            loadsProfession(editorProfession);
        },
        top: imgConfgProfession.topProfession,
        left: imgConfgProfession.leftProfession,
    });

    $("#download").click(function()
    {
        
        editorName.download(imgConfgName);
    });
    
    $("#share").click(function()
    {
        editorName.share(imgConfgName);
        $('#url-val').hide();
    });
    
    $("#send").click(function()
    {
        $("#sendTo").modal('show');
    });
    
    $("#facebook-btn").click(function()
    {
        editorName.shareNow(imgConfgName, 'facebook');
    });
    
    $("#twitter-btn").click(function()
    {
        editorName.shareNow(imgConfgName, 'twitter');
    });
    
    $("#google-btn").click(function()
    {
        editorName.shareNow(imgConfgName, 'google');
    });
    
    $("#linkedin-btn").click(function()
    {
        editorName.shareNow(imgConfgName, 'linkedin');
    });
    
    $("#pinterest-btn").click(function()
    {
        editorName.shareNow(imgConfgName, 'pinterest');
    });
    $("#url-btn").click(function()
    {
        $('#url-val').val(editorName.shareNow(imgConfgName, 'url')).slideDown().select();
    });
    
    $("#sendTo form").submit(function()
    {
        var form = {};
        $(this).find('input').each(function()
        {
            form[$(this).attr('name')] = $(this).val();
        });

        editorName.sendMail(imgConfgName, form, function(res)
        {
            alert(res.emailStatus ? 'Mail sent successfully' : "Can't sending the mail !");
            if(res.emailStatus) $("#sendTo").modal('hide');
        });
        return false;
    });

</script>
    <?php
}

function upload()
{
    if(!empty($_FILES['images']) && !demoMode)
    {        
        $path = $GLOBALS['config']['dir'].'/';
        function theName($name)
        {
            $ext = getExt($name);
            $newName = rand(0, 99).'_'.uniqid();
            if(file_exists($GLOBALS['path'].$newName.'.'.$ext))
            {
                $name = theName($name);
            }
            else $name = $newName.'.'.$ext;
            
            return $name;
        }
        
        
        foreach($_FILES['images']['name'] as $k=>$name)
        {
            $name = theName($name);
            @move_uploaded_file($_FILES['images']['tmp_name'][$k], $path.$name);
        }
    }
    elseif(demoMode) showDemoMode ();
    include_once 'templates/upload.php';
    ?>        
    <script type="text/javascript" defer>
        var formData = new FormData();        
        var theFiles = {};
        var index = 0;
        var temp = $("#fileShow").html();

        function addFile(file)
        {            
            formData.append("images[]", file);
            theFiles[index] = file;
            var old = ['{i}', '{name}', '{data}'];
            var newR = [index, file.name];
            readData(file, function(result)
            {
                newR.push(result);
                $("#files").append(strReplace(old, newR, temp));
            });
            index++;
            isUploadEnabled();
        }
        
        function reset()
        {
            formData = new FormData();
            $("#files").find('div').remove();
            theFiles = {};
            isUploadEnabled();
        }
        
        function startEvent()
        {            
            $('[name="theFile"]').change(function()
            {                
                $.each(this.files, function(i, file)
                {                    
                    if(file.name && file.type)
                    {
                        addFile(file);
                    }
                });                
                $(this).val('');   
//                this.files = [];
            });
        }
           
        function removeImage(i)
        {            
            formData = new FormData();            
            delete theFiles[i];
            $('#imgs_'+i).remove();
            
            $.each(theFiles, function(idx, file)
            {
                formData.append("images[]", file);
            });
            isUploadEnabled();
        }
        
        function isUploadEnabled()
        {
            $("#upload").prop('disabled', len(theFiles) == 0);
        }
        
        
        
        function upload()
        {
            if(len(theFiles) > 0)
            {
                $("#progress-wrp").removeClass('hidden');
                $.ajax({
                    type: "POST",
                    url: "?p=new",
                    xhr: function () {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) {
                            myXhr.upload.addEventListener('progress', progressHandling, false);
                        }
                        return myXhr;
                    },
                    success: function (data) 
                    {
//                        reset();
//                        $("#progress-wrp").addClass('hidden');
                        location.reload();
                    },
                    error: function (error) 
                    {
                        
                    },
                    async: true,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 200000
                });
            }
        }
        
        function progressHandling(event)
        {
            var percent = 0;
            var position = event.loaded || event.position;
            var total = event.total;
            var progress_bar_id = "#progress-wrp";
            if (event.lengthComputable) {
                percent = Math.ceil(position / total * 100);
            }
            // update progressbars classes so it fits your code
            $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
            $(progress_bar_id + " .status").text(percent + "%");
        }
        
        
        startEvent();
    </script>
    <?php
}


function savePhoto()
{
    if(!empty($_FILES['file']) && !empty($_POST['name']))
    {
        $names = getExt($_POST['name'], true);
        if($names->ext != 'png') exit;
        $file = '__temp/';
        if(!empty($_POST['dir'])) 
        {
            $file .= $_POST['dir'].'/';
            @mkdir($file);
        }        
        $file .= $names->name.'.png';
        
        
        
        
        $data = array('path' => $file, 'name' => $_POST['name']);
        $data['status'] = @move_uploaded_file($_FILES['file']['tmp_name'], $file);
        if(!empty($_POST['email']))
        {
            $form = (object) $_POST['email'];
            include_once 'mailer.php';
            $isHTML = in_array($GLOBALS['config']['cardsMailFormat'], ['image', 'both']);
            $mail = $isHTML ? 'photo' :'nophoto';
            $bodytext = @file_get_contents('templates/mail_'.$mail.'.php');
            $url = substr($file, 7);
            $url = str_replace("/", "_-_", $url);
            $bodytext = str_replace([
                '{imgPath}',
                '{name}',
                '{senderName}',
            ], 
            [
                sitePath('?do=share&p=show&path='.$url),
                $form->name,
                $form->yourName,
            ], $bodytext);
            $email = new PHPMailer();            
            $email->From      = !empty($GLOBALS['config']['senderMail']) ? $GLOBALS['config']['senderMail'] : 'no-replay@'.serverName();
            $email->FromName  = $form->yourName;
            $email->Subject   = $form->title;
            $email->Body      = $bodytext;
            $email->AddAddress($form->email);
            if(in_array($GLOBALS['config']['cardsMailFormat'], ['attachment', 'both'])) $email->AddAttachment($file, $_POST['name']);
            if($isHTML) $email->isHTML();
            $data['emailStatus'] = $email->Send();
        }
        echoJson($data);
    }
    echoJson(['error' => true]);
}

function view()
{
    $orginalName = explode("/", $_GET['path']);
    $orginalName = !empty($orginalName[1]) ? $orginalName[0] : null;
    include 'templates/view.php';
}
