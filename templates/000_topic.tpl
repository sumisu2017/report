<!doctype html>
<html lang="zh-Hant-TW">

<head>
    {include file="header.tpl"}
</head>

<body> 
    <!-- {include file="nav.tpl"} -->
    <div class="container">
        <!-- {include file="op_`$op`.tpl"}             -->
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr class="info">
                    <th>類別編號</th>
                    <th>類別或主題名稱</th>
                    <th>種類</th>
                    <th>說明</th>
                    <th>預設</th>
                </tr>
            </thead>
            <tbody>
                  {foreach $all as $topic}
                <tr>
                    <td>
                        {$topic.topic_sn}
                    </td>
                    <td>
                    <!-- <a href="index.php?receipt_id={$receipt.receipt_id}">{$receipt.title}</a> -->
                    {$topic.topic_title}
                    </td>
                   
                    <td>{$topic.topic_type}</td>
                    <td>{$topic.topic_description}</td>
                    <td>{$topic_default}</td>
                </tr>
                {foreachelse}
                <tr>
                    <td colspan=5>暫無領據</td>
                </tr>
                {/foreach}

            </tbody>
        </table>

    </div>
    {include file="footer.tpl"}

</body>
</html>