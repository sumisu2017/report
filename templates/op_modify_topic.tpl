<script src="js/languages/jquery.validationEngine-zh_TW.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css">

<script src="ckeditor/ckeditor.js"></script>
<form action="topic.php" method="post" enctype="multipart/form-data" class="my-4" id="myform">

    <div class="form-group">
        <label for="topic_title" class="col-form-label sr-only">類別或主題名稱</label>
        <input type="text" class="form-control validate[required]" name="topic_title" id="topic_title" placeholder="請輸入類別或主題名稱"
         value="{$topic.topic_title}">
    </div>
    <div class="form-group">
            <div class="form-group">請擇一
                <select name="topic_type"> 
             {if $topic.topic_type=="類別" }
　               <option value="類別" selected="selected">類別</option>
                 <option value="主題" >主題</option>
             {else}
                <option value="類別">類別</option>
                <option value="主題" selected="selected">主題</option>
             {/if}             
            </select>
            </div>
    </div>
    <div class="form-group">
        <label for="topic_description" class="col-form-label sr-only">說明</label>
        <textarea name="topic_description" id="topic_description" rows="20" class="form-control " placeholder="請輸入專題說明">{$topic.topic_description}</textarea>
    </div>

    <div class="text-center">
        <input type="hidden" name="sn" value="{$topic.topic_sn}">
        <input type="hidden" name="op" value="update">
        <input type="hidden" name="username" value="{$smarty.session.username}">
        <button type="submit" class="btn btn-primary">儲存</button>
    </div>
</form>

<script>
    CKEDITOR.replace('topic_description');
    $(document).ready(function () {
        $('#myform').validationEngine({ promptPosition: "bottomLeft" });
    });

</script>