<?php extract($def_vars); ?>

<div class="block_with_links_under_form">
    <a class="links_under_form" href="/">На главную</a>
    <a class="links_under_form" href="/<?php echo $table_name; ?>/add">Добавить тип АКБ</a>
</div>
<hr>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_bat_voltage) ? $field_bat_voltage : ''; ?></th>
            <th><?php echo isset($field_bat_capacity) ? $field_bat_capacity : ''; ?></th>
            <th colspan="2">Действия</th>
        </tr>
        <?php foreach ($current_table as $row): ?>
            <tr>
                <?='<td>'.$row->$id_column.'</td>'?>
                <?='<td>'.$row->bat_voltage.'</td>'?>
                <?='<td>'.$row->bat_capacity.'</td>'?>
                <?='<td><a href="/'.$table_name.'/edit/'.$row->$id_column.'">Изменить</a></td>'?>
                <?='<td><a href="/'.$table_name.'/delete/'.$row->$id_column.'">Удалить</a></td>'?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>