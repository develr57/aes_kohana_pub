<?php extract($def_vars); ?>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_devtype)    ? $field_devtype    : ''; ?></th>
            <th><?php echo isset($field_vendor)     ? $field_vendor     : ''; ?></th>
            <th><?php echo isset($field_model)      ? $field_model      : ''; ?></th>
            <th><?php echo isset($field_power)      ? $field_power      : ''; ?></th>
            <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
            <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
            <th><?php echo isset($field_sysunit)    ? $field_sysunit    : ''; ?></th>
            <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
            <th>Действия</th>
        </tr>
        <?php foreach ($pwrsupplies as $pwrsupply): ?>
            <tr>
                <?='<td>'.$pwrsupply->$id_column.             '</td>'?>
                <?='<td>'.$pwrsupply->devtype->devtype_name.  '</td>'?>
                <?='<td>'.$pwrsupply->vendor->vendor_name.    '</td>'?>
                <?='<td>'.$pwrsupply->model.                  '</td>'?>
                <?='<td>'.$pwrsupply->power.                  '</td>'?>
                <?='<td>'.$pwrsupply->location->location_name.'</td>'?>
                <?='<td>'.$pwrsupply->status->status_name.    '</td>'?>
                <?='<td>'.$pwrsupply->su_id.                  '</td>'?>
                <?='<td>'.$pwrsupply->note.                   '</td>'?>
                <td><a href="/sysunits/operations/<?= $su_id ?>/<?= $operation ?>/<?= $pwrsupply->ps_id ?>/pwrsupply/<?= $old_id ?>">Выбрать</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>