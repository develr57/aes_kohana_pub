<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/styles.css" type="text/css" />
    <link rel="shortcut icon" href="/images/favicon_152x60.png" type="image/png" />
    <link rel="stylesheet" type="text/css" href="/calendar/tcal.css" />
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

            <?php echo $content; ?>
            
        </div>

        <div class="footer">
            <p>Разработал: Зябиров Ф.Р.</p>
        </div>

    </div>
</body>
</html>