<?php extract($def_vars); ?>

<div class="block_with_links_under_form">
    <a class="links_under_form" href="/">На главную</a>
    <a class="links_under_form" href="/<?php echo $table_name; ?>/add">Добавить рабочее место</a>
</div>
<hr>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_wp_name)    ? $field_wp_name    : ''; ?></th>
            <th><?php echo isset($field_employee)   ? $field_employee   : ''; ?></th>
            <th><?php echo isset($field_department) ? $field_department : ''; ?></th>
            <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
            <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
            <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
            <th colspan="2">Действия</th>
        </tr>
        <?php foreach ($current_table as $row) : ?>
            <tr>
                <?= '<td>' . $row->$id_column . '</td>' ?>
                <?= '<td>' . $row->wp_name . '</td>' ?>
                <?= '<td>' . $row->employee->short . '</td>' ?>
                <?= '<td>' . $row->department->dept_name . '</td>' ?>
                <?= '<td>' . $row->location->location_name . '</td>' ?>
                <?= '<td>' . $row->status->status_name . '</td>' ?>
                <?= '<td>' . $row->note . '</td>' ?>
                <?= '<td><a href="/' . $table_name . '/edit/' . $row->$id_column . '">Изменить</a></td>' ?>
                <?= '<td><a href="/' . $table_name . '/delete/' . $row->$id_column . '">Удалить</a></td>' ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>