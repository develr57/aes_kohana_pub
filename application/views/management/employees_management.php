<?php extract($def_vars); ?>

<div class="block_with_links_under_form">
    <a class="links_under_form" href="/">На главную</a>
    <a class="links_under_form" href="/<?php echo $table_name; ?>/add">Добавить сотрудника</a>
</div>
<hr>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_surname)    ? $field_surname    : ''; ?></th>
            <th><?php echo isset($field_name)       ? $field_name       : ''; ?></th>
            <th><?php echo isset($field_patronymic) ? $field_patronymic : ''; ?></th>
            <th><?php echo isset($field_short)      ? $field_short      : ''; ?></th>
            <th><?php echo isset($field_position)   ? $field_position   : ''; ?></th>
            <th><?php echo isset($field_department) ? $field_department : ''; ?></th>
            <th colspan="2">Действия</th>
        </tr>
        <?php foreach ($current_table as $row): ?>
            <tr>
                <?='<td>'.$row->$id_column.             '</td>'?>
                <?='<td>'.$row->surname.                '</td>'?>
                <?='<td>'.$row->name.                   '</td>'?>
                <?='<td>'.$row->patronymic.             '</td>'?>
                <?='<td>'.$row->short.                  '</td>'?>
                <?='<td>'.$row->position.               '</td>'?>
                <?='<td>'.$row->department->dept_name.  '</td>'?>
                <?='<td><a href="/'.$table_name.'/edit/'.$row->$id_column.'">Изменить</a></td>'?>
                <?='<td><a href="/'.$table_name.'/delete/'.$row->$id_column.'">Удалить</a></td>'?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>