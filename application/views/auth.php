<?php
isset($result) ? extract($result) : '';
?>
<h2 style="text-align: center;"><?= $title ?></h2>
<div class="auth_block">
    <form action="/auth" method="POST">

        <div class="label_and_input">
            <label class="form_label"><?=$field_login?>:</label>
            <input class="input_text" type="text" name="login" value=
                "<?php if (isset($res_status) && $res_status == 'fail' && isset($login)) echo $login; ?>"
            required>
        </div>

        <div class="label_and_input">
            <label class="form_label"><?=$field_password?>:</label>
            <input class="input_text" type="password" name="password" value=
                "<?php if (isset($res_status) && $res_status == 'fail' && isset($model)) echo $model; ?>"
            required>
        </div>

        <div class="form_bottom">
            <input class="submit submit_flex" type="submit"
                name="GO" value="Войти">
            <div class=
                "query_status <?php echo isset($res_status) ? $res_status : ''; ?>"
                ><?php echo isset($res_message) ? $res_message : ''; ?>
            </div>
        </div>

    </form>
</div>