<?php extract($def_vars); ?>

<div class="block_with_links_under_form">
    <a class="links_under_form" href="/">На главную</a>
    <a class="links_under_form" href="/<?php echo $table_name; ?>/add">Добавить оперативную память</a>
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
            <th><?php echo isset($field_size)       ? $field_size       : ''; ?></th>
            <th><?php echo isset($field_ramtype)    ? $field_ramtype    : ''; ?></th>
            <th><?php echo isset($field_speed)      ? $field_speed      : ''; ?></th>
            <th><?php echo isset($field_formfactor) ? $field_formfactor : ''; ?></th>
            <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
            <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
            <th><?php echo isset($field_sysunit)    ? $field_sysunit    : ''; ?></th>
            <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
            <th colspan="2">Действия</th>
        </tr>
        <?php foreach ($current_table as $row): ?>
            <tr>
                <?='<td>'.$row->$id_column.             '</td>'?>
                <?='<td>'.$row->devtype->devtype_name.  '</td>'?>
                <?='<td>'.$row->vendor->vendor_name.    '</td>'?>
                <?='<td>'.$row->model.                  '</td>'?>
                <?php
                    echo '<td>';
                    if ($row->size < 1024)
                    {
                        echo $row->size.'MB';

                    } else
                    {   
                        $size_gb = $row->size/1024;
                        echo $size_gb.'GB';
                    }
                    echo '</td>';                              ?>
                <?='<td>'.$row->ramtype->ramtype_name.  '</td>'?>
                <?='<td>'.$row->speed.                  '</td>'?>
                <?='<td>'.$row->formfactor.             '</td>'?>
                <?='<td>'.$row->location->location_name.'</td>'?>
                <?='<td>'.$row->status->status_name.    '</td>'?>
                <?='<td>'.$row->su_id.                  '</td>'?>
                <?='<td>'.$row->note.                   '</td>'?>
                <?='<td><a href="/'.$table_name.'/edit/'.$row->$id_column.'">Изменить</a></td>'?>
                <?='<td><a href="/'.$table_name.'/delete/'.$row->$id_column.'">Удалить</a></td>'?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
?>