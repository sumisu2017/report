<?php
require "loginheader.php";
require_once 'header.php';
$page_title = '管理頁面';

$op = isset($_REQUEST['op']) ? filter_var($_REQUEST['op']) : '';
$sn = isset($_REQUEST['sn']) ? (int) $_REQUEST['sn'] : 0;
switch ($op) {
    case 'insert':
        $sn = insert_article();
        header("location: index.php?sn={$sn}");
        exit;

    case 'update':
        update_article($sn);
        header("location: index.php");
        exit;

    case 'delete_article':
        delete_article($sn);
        header("location: index.php");
        exit;

    case "article_form":
        //sumi add 加入TOPIC
        list_topic();
        break;

    case "modify_article":
        //sumi add 加入TOPIC
        list_topic();

        show_article($sn);
        break;

    default:
        $op = "";
        break;
}

require_once 'footer.php';

/*************函數區**************/

//儲存文章
function insert_article()
{
    //sumi add topic_sn
    global $db;
    $title    = $db->real_escape_string($_POST['title']);
    $content  = $db->real_escape_string($_POST['content']);
    $username = $db->real_escape_string($_POST['username']);
    $topic_sn = $db->real_escape_string($_POST['topic_sn']);

    $sql = "INSERT INTO `article` (`title`, `content`, `username`, `create_time`, `update_time`,`classify`) VALUES ('{$title}', '{$content}', '{$username}', NOW(), NOW(),'{$topic_sn}')";
    $db->query($sql) or die($db->error);
    $sn = $db->insert_id;

    //上傳圖片
    upload_pic($sn);

    return $sn;
}

function delete_article($sn)
{
    global $db;

    $sql = "DELETE FROM `article` WHERE sn='{$sn}' and username='{$_SESSION['username']}'";
    $db->query($sql) or die($db->error);

    if (file_exists("uploads/cover_{$sn}.png")) {
        unlink("uploads/cover_{$sn}.png");
        unlink("uploads/thumb_{$sn}.png");
    }

}

//更新文章
function update_article($sn)
{
    //sumi add topic_sn
    global $db;
    $title    = $db->real_escape_string($_POST['title']);
    $content  = $db->real_escape_string($_POST['content']);
    $username = $db->real_escape_string($_POST['username']);
    $topic_sn = $db->real_escape_string($_POST['topic_sn']);

    $sql = "update `article` Set `title`='{$title}', `content`= '{$content}',`update_time`=NOW() ,`classify` ='{$topic_sn}' WHERE sn='{$sn}' ";
    //,username={$username}
    $db->query($sql) or die($db->error);
    //上傳圖片
    upload_pic($sn);
}

//上傳圖片
function upload_pic($sn)
{
    //先刪除再新增
    if (file_exists("uploads/cover_{$sn}.png")) {
        unlink("uploads/cover_{$sn}.png");
        unlink("uploads/thumb_{$sn}.png");
    }

    if (isset($_FILES)) {
        require_once 'class.upload.php';
        $foo = new Upload($_FILES['pic']);
        if ($foo->uploaded) {
            // save uploaded image with a new name
            $foo->file_new_name_body = 'cover_' . $sn;
            $foo->image_resize       = true;
            $foo->image_convert      = png;
            $foo->image_x            = 1200;
            $foo->image_ratio_y      = true;
            $foo->Process('uploads/');
            if ($foo->processed) {
                $foo->file_new_name_body = 'thumb_' . $sn;
                $foo->image_resize       = true;
                $foo->image_convert      = png;
                $foo->image_x            = 400;
                $foo->image_ratio_y      = true;
                $foo->Process('uploads/');
            }
        }

    }
}

//讀出所有類別
function list_topic()
{
    global $db, $smarty;

    $sql    = "SELECT * FROM `topic` ORDER BY `topic_sn` ";
    $result = $db->query($sql) or die($db->error);
    $all    = [];
    $i      = 0;
    while ($data = $result->fetch_assoc()) {
        $all[] = $data;
    }
    //die(var_export($all));
    $smarty->assign('all', $all);
}
