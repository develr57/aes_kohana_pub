<?php extract($def_vars); ?>

<div class="block_with_links_under_form">
    <a class="links_under_form" href="/">На главную</a>
    <a class="links_under_form" href="/<?php echo $table_name; ?>/add">Добавить оргтехнику</a>
</div>
<hr>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_devtype)    ? $field_devtype    : ''; ?></th>
            <th><?php echo isset($field_vendor)     ? $field_vendor     : ''; ?></th>
            <th><?php echo isset($field_model)      ? $field_model      : ''; ?></th>
            <th><?php echo isset($field_format)     ? $field_format     : ''; ?></th>
            <th><?php echo isset($field_print_tech) ? $field_print_tech : ''; ?></th>
            <th><?php echo isset($field_print_color)? $field_print_color: ''; ?></th>
            <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
            <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
            <th><?php echo isset($field_workplace)  ? $field_workplace  : ''; ?></th>
            <th><?php echo isset($field_fa)         ? $field_fa         : ''; ?></th>
            <th><?php echo isset($field_inv_num)    ? $field_inv_num    : ''; ?></th>
            <th><?php echo isset($field_inv_status) ? $field_inv_status : ''; ?></th>
            <th><?php echo isset($field_com_date)   ? $field_com_date   : ''; ?></th>
            <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
            <th colspan="2">Действия</th>
        </tr>
        <?php foreach ($current_table as $row): ?>
            <tr>
                <?='<td>'.$row->$id_column.'</td>'?>
                <?='<td>'.$row->devtype->devtype_name.'</td>'?>
                <?='<td>'.$row->vendor->vendor_name.'</td>'?>
                <?='<td>'.$row->model.'</td>'?>
                <?='<td>'.$row->format.'</td>'?>
                <?php
                echo '<td>';
                foreach ($select_print_tech as $pt_key => $pt_val)
                {
                    if ($row->print_tech == $pt_key) echo $pt_val;
                }
                echo '</td>';
                echo '<td>';
                foreach ($select_print_color as $pc_key => $pc_val)
                {
                    if ($row->print_color == $pc_key) echo $pc_val;
                }
                echo '</td>';
                ?>
                <?='<td>'.$row->location->location_name.'</td>'?>
                <?='<td>'.$row->status->status_name.'</td>'?>
                <?='<td>'.$row->workplace->wp_name.'</td>'?>
                <?='<td>'.$row->fa.'</td>'?>
                <?='<td>'.$row->inv_num.'</td>'?>
                <?php
                    echo $row->inv_status == 'G' ?
                    '<td>Числится</td>' :
                    '<td>Не числится</td>';
                ?>
                <?php
                    echo is_null($row->com_date) ?
                    '<td></td>' : 
                    '<td>'.date("d.m.Y", $row->com_date).'</td>';
                ?>
                <?='<td>'.$row->note.'</td>'?>
                <?='<td><a href="/'.$table_name.'/edit/'.$row->$id_column.'">Изменить</a></td>'?>
                <?='<td><a href="/'.$table_name.'/delete/'.$row->$id_column.'">Удалить</a></td>'?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
//echo date("d.m.Y", mktime(0, 0, 0, 7, 2, 2019));
?>