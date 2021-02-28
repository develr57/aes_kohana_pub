<?php extract($def_vars); ?>

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
            <th>Действия</th>
        </tr>
        <?php foreach ($videocards as $videocard): ?>
            <tr>
                <?='<td>'.$videocard->$id_column.             '</td>'?>
                <?='<td>'.$videocard->devtype->devtype_name.  '</td>'?>
                <?='<td>'.$videocard->vendor->vendor_name.    '</td>'?>
                <td>
                    <?php
                        foreach ($select_gpu_vendor as $gv_key => $gv_value)
                        {
                            if ($videocard->gpu_vendor == $gv_key)
                            {
                                echo $gv_value;
                                break;
                            }
                        }
                                                               ?>
                </td>
                <?='<td>'.$videocard->model.                  '</td>'?>
                <td>
                    <?php
                        if ($videocard->mem_capacity < 1024)
                        {
                            echo $videocard->mem_capacity.'MB';

                        } else
                        {   
                            $size_gb = $videocard->mem_capacity/1024;
                            echo $size_gb.'GB';
                        }                                      ?>
                </td>
                <?='<td>'.$videocard->location->location_name.'</td>'?>
                <?='<td>'.$videocard->status->status_name.    '</td>'?>
                <?='<td>'.$videocard->su_id.                  '</td>'?>
                <?='<td>'.$videocard->note.                   '</td>'?>
                <td><a href="/sysunits/operations/<?= $su_id ?>/<?= $operation ?>/<?= $videocard->vc_id ?>/videocard/<?= $old_id ?>">Выбрать</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
?>