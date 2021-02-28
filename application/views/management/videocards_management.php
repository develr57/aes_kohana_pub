<?php extract($def_vars); ?>

<div class="block_with_links_under_form">
    <a class="links_under_form" href="/">На главную</a>
    <a class="links_under_form" href="/<?php echo $table_name; ?>/add">Добавить видеокарту</a>
</div>
<hr>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_devtype)        ? $field_devtype        : ''; ?></th>
            <th><?php echo isset($field_vendor)         ? $field_vendor         : ''; ?></th>
            <th><?php echo isset($field_gpu_vendor)     ? $field_gpu_vendor     : ''; ?></th>
            <th><?php echo isset($field_model)          ? $field_model          : ''; ?></th>
            <th><?php echo isset($field_mem_capacity)   ? $field_mem_capacity   : ''; ?></th>
            <th><?php echo isset($field_location)       ? $field_location       : ''; ?></th>
            <th><?php echo isset($field_status)         ? $field_status         : ''; ?></th>
            <th><?php echo isset($field_sysunit)        ? $field_sysunit        : ''; ?></th>
            <th><?php echo isset($field_note)           ? $field_note           : ''; ?></th>
            <th colspan="2">Действия</th>
        </tr>
        <?php foreach ($current_table as $row): ?>
            <tr>
                <?='<td>'.$row->$id_column.             '</td>'?>
                <?='<td>'.$row->devtype->devtype_name.  '</td>'?>
                <?='<td>'.$row->vendor->vendor_name.    '</td>'?>
                <td>
                    <?php
                        foreach ($select_gpu_vendor as $gv_key => $gv_value)
                        {
                            if ($row->gpu_vendor == $gv_key)
                            {
                                echo $gv_value;
                                break;
                            }
                        }
                                                               ?>
                </td>
                <?='<td>'.$row->model.                  '</td>'?>
                <td>
                    <?php
                        if ($row->mem_capacity < 1024)
                        {
                            echo $row->mem_capacity.'MB';

                        } else
                        {   
                            $size_gb = $row->mem_capacity/1024;
                            echo $size_gb.'GB';
                        }                                      ?>
                </td>
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