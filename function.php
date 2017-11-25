<?php
//連線資料庫
function link_db()
{
    $db = new mysqli('localhost', 'root', '12345', 'reporter');
    if ($db->connect_error) {
        die('無法連上資料庫' . $db->connect_error);
    }
    $db->set_charset("utf8");
    return $db;
}
/* function link_db()
{
//實體化資料庫物件
$mysqli = new mysqli(_DB_LOCATION, _DB_ID, _DB_PASS, _DB_NAME);
if ($mysqli->connect_error) {
throw new Exception('無法連上資料庫：' . $mysqli->connect_error);
}
$mysqli->set_charset("utf8");
return $mysqli;
} */

//檢查並傳回欲拿到資料使用的變數
function clean_var($var = '', $title = '', $filter = '')
{
    global $db;
    $clean_var = $db->real_escape_string($_REQUEST[$var]);
    if (empty($clean_var)) {
        throw new Exception("{$title}為必填！");
    }
    if ($filter) {
        $clean_var = filter_var($clean_var, $filter);
        if (!$clean_var) {
            throw new Exception("不合法的{$title}");
        }
    }
    return $clean_var;
}

//檢查並傳回欲拿到資料使用的變數
function get_pic()
{
    global $smarty;
    $dir = "images/";
    $pic = [];
// Open a known directory, and proceed to read its contents
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                // echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
                if ($file != "." && $file != ".." && $file != "ajax-loader.gif") {
                    $pic[] = $file;
                }

            }
            closedir($dh);
        }
    }
    // die(var_dump($pic));
    //return json_encode($pic);
    //$smarty->assign('pic', json_encode($pic));
    $smarty->assign('pic', json_encode($pic));
}

//讀出單一文章
function show_article($sn)
{
    global $db, $smarty;

    require_once 'HTMLPurifier/HTMLPurifier.auto.php';
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);

    $sql             = "SELECT * FROM `article` WHERE `sn`='$sn'";
    $result          = $db->query($sql) or die($db->error);
    $data            = $result->fetch_assoc();
    $data['content'] = $purifier->purify($data['content']);
    $smarty->assign('article', $data);
}
