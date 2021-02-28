<?php
extract($def_vars);
if (isset($result)) extract($result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/images/favicon_152x60.png" type="image/png">
    <link rel="stylesheet" href="/css/styles.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/calendar/tcal.css">
    <script type="text/javascript" src="/calendar/tcal.js"></script>
    <title><?php echo $title; ?></title>
    <style type="text/css"></style>
</head>
<body>
    <div class="main_container_header">
        <div class="wrapper_header">
            <div class="header_logo">
                <a href="/"><img src="/images/logo.jpg"></a>
            </div>
            <div class="header_menu">
                <div class="pairs">
                    <div class="header_links">
                        <a href="/management/base">Управление базой</a>
                    </div>
                    <div class="header_links">
                        <a href="#">Ссылка</a>
                    </div>
                </div>
                <div class="pairs">
                    <div class="header_links">
                        <a href="#">Ссылка</a>
                    </div>
                    <div class="header_links">
                        <a href="#">Ссылка</a>
                    </div>
                </div>
                <div class="pairs">
                    <div class="header_links">
                        <a href="#">Ссылка</a>
                    </div>
                </div>
            </div>
            <div class="user-stat_block">
                <?php
                if ($auth->logged_in())
                {?>
                <div>Пользователь:</div>
                <div><?= $user->username ?></div>
                <div><a href="/auth/logout">Выход</a></div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <div class="main_container_content">
        <div class="wrapper_content">
            <h2><?php echo $title; ?></h2>
            <div class="form_block">
                <form action="/<?= $table_name.'/'.$oper_type ?>" method="POST">

                    <?php echo $content; ?>

                    <div class="form_bottom">
                        <input class="submit submit_flex" type="submit"
                            name="GO" value="Сохранить">
                        <div class=
                            "query_status <?php echo isset($res_status) ? $res_status : ''; ?>"
                            ><?php echo isset($res_message) ? $res_message : ''; ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="block_with_links_under_form">
                <a class="links_under_form" href="/">На главную</a>
                <a class="links_under_form" href="/<?php echo $table_name; ?>">К таблице</a>
            </div>
        </div>

        <div class="footer">
            <p>Разработал: Зябиров Ф.Р.</p>
        </div>

    </div>
    <?php
        #getMy($query);
    ?>
</body>
</html>