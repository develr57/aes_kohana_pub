<?php
extract($def_vars);
if (isset($result)) extract($result);
if (isset($editable_line))
{
?>
<div class="editable_line_block">
    <p>Редактируемая запись:</p>
    <table class="table_above_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_devtype)    ? $field_devtype    : ''; ?></th>
            <th><?php echo isset($field_vendor)     ? $field_vendor     : ''; ?></th>
            <th><?php echo isset($field_model)      ? $field_model      : ''; ?></th>
            <th><?php echo isset($field_socket)     ? $field_socket     : ''; ?></th>
            <th><?php echo isset($field_soc_count)  ? $field_soc_count  : ''; ?></th>
            <th><?php echo isset($field_ramtype)    ? $field_ramtype    : ''; ?></th>
            <th><?php echo isset($field_slot_count) ? $field_slot_count : ''; ?></th>
            <th><?php echo isset($field_video_out)  ? $field_video_out  : ''; ?></th>
            <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
            <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
            <th><?php echo isset($field_sysunit)    ? $field_sysunit    : ''; ?></th>
            <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
        </tr>
        <tr>
            <?='<td>'.$editable_line->$id_column.               '</td>'?>
            <?='<td>'.$editable_line->devtype->devtype_name.    '</td>'?>
            <?='<td>'.$editable_line->vendor->vendor_name.      '</td>'?>
            <?='<td>'.$editable_line->model.                    '</td>'?>
            <?='<td>'.$editable_line->socket->socket.           '</td>'?>
            <?='<td>'.$editable_line->soc_count.                '</td>'?>
            <?='<td>'.$editable_line->ramtype->ramtype_name.    '</td>'?>
            <?='<td>'.$editable_line->slot_count.               '</td>'?>
            <?php
            echo '<td>';
            foreach ($select_video_out as $vo_key => $vo_val)
            {
                if ($editable_line->video_out == $vo_key) echo $vo_val;
            }
            echo '</td>';
            ?>
            <?='<td>'.$editable_line->location->location_name.  '</td>'?>
            <?='<td>'.$editable_line->status->status_name.      '</td>'?>
            <?='<td>'.$editable_line->su_id.                    '</td>'?>
            <?='<td>'.$editable_line->note.                     '</td>'?>
        </tr>
    </table>
</div>
<?php } ?>

<div class="block_inside_form">
    <div class="form_block_pair">

        <input type="text" name="id" hidden value="<?php echo isset($id) ? $id :''; ?>">
        <input type="text" name="devtype_id" hidden value="<?php echo isset($devtype_id) ? $devtype_id :''; ?>">

        <div class="label_and_select">
            <label class="form_label"><?=$field_vendor?>:</label>
            <select class="input_text" name="vendor_id" required>
                <option value="">Выберите вендора</option>
                <?php foreach ($select_vendors as $vendor): ?>
                <option value="<?=$vendor->vendor_id?>"
                    <?php
                        if (isset($res_status) && $res_status == 'fail' && isset($vendor_id))
                            if ($vendor->vendor_id == $vendor_id) echo ' selected';
                    ?>
                ><?=$vendor->vendor_name?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="label_and_input">
            <label class="form_label"><?=$field_model?>:</label>
            <input class="input_text" type="text" name="model" value=
                "<?php if (isset($res_status) && $res_status == 'fail' && isset($model)) echo $model; ?>"
            >
        </div>

        <div class="label_and_select">
            <label class="form_label"><?=$field_socket?>:</label>
            <select class="input_text" name="socket_id" required>
                <option value="">Выберите сокет</option>
                <?php foreach ($select_sockets as $sel_socket): ?>
                <option value="<?=$sel_socket->socket_id?>"
                    <?php
                        if (isset($res_status) && $res_status == 'fail' && isset($socket_id))
                            if ($sel_socket->socket_id == $socket_id) echo ' selected';
                    ?>
                ><?=$sel_socket->socket?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="label_and_select">
            <label class="form_label"><?=$field_soc_count?>:</label>
            <select class="input_text" name="soc_count" required>
                <?php foreach ($select_soc_count as $sel_soc_count): ?>
                <option value="<?=$sel_soc_count?>"
                <?php
                if (isset($res_status) && $res_status == 'fail' && isset($soc_count))
                    if ($sel_soc_count == $soc_count) echo ' selected';
                ?>
                ><?=$sel_soc_count?></option>
            <?php endforeach; ?>
            </select>
        </div>

        <div class="label_and_select">
            <label class="form_label"><?=$field_ramtype?>:</label>
            <select class="input_text" name="ramtype_id" required>
                <option value="">Выберите тип ОЗУ</option>
                <?php foreach ($select_ramtypes as $sel_ramtype): ?>
                <option value="<?=$sel_ramtype->ramtype_id?>"
                    <?php
                        if (isset($res_status) && $res_status == 'fail' && isset($ramtype_id))
                            if ($sel_ramtype->ramtype_id == $ramtype_id) echo ' selected';
                    ?>
                ><?=$sel_ramtype->ramtype_name?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="label_and_select">
            <label class="form_label"><?=$field_slot_count?>:</label>
            <select class="input_text" name="slot_count" required>
                <?php foreach ($select_slot_count as $sel_slot_count): ?>
                <option value="<?=$sel_slot_count?>"
                <?php
                if (isset($res_status) && $res_status == 'fail' && isset($slot_count))
                    if ($sel_slot_count == $slot_count) echo ' selected';
                ?>
                ><?=$sel_slot_count?></option>
            <?php endforeach; ?>
            </select>
        </div>

        <div class="label_and_select">
            <label class="form_label"><?=$field_video_out?>:</label>
            <select class="input_text" name="video_out" required>
                <option value="">Выберите</option>
                <?php foreach ($select_video_out as $vo_key => $vo_val): ?>
                <option value="<?=$vo_key?>"
                <?php
                if (isset($res_status) && $res_status == 'fail' && isset($video_out))
                    if ($vo_key == $video_out) echo ' selected';
                ?>
                ><?=$vo_val?></option>
            <?php endforeach; ?>
            </select>
        </div>

    </div>

    <div class="form_block_pair">

        <div class="label_and_select">
            <label class="form_label"><?=$field_location?>:</label>
            <select class="input_text" name="location_id" required>
                <option value="">Выберите локацию</option>
                <?php foreach ($select_locations as $location): ?>
                <option value="<?=$location->location_id?>"
                <?php
                    if (isset($res_status) && $res_status == 'fail' && isset($location_id))
                        if ($location->location_id == $location_id) echo ' selected';
                ?>
                ><?=$location->location_name?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="label_and_select">
            <label class="form_label"><?=$field_status?>:</label>
            <select class="input_text" name="status_id" required>
                <option value="">Выберите статус</option>
                <?php foreach ($select_statuses as $status): ?>
                <option value="<?=$status->status_id?>"
                    <?php
                        if (isset($res_status) && $res_status == 'fail' && isset($status_id))
                            if ($status->status_id == $status_id) echo ' selected';
                    ?>
                ><?=$status->status_name?></option>
                <?php endforeach; ?>
            </select>
        </div>
    
        <div class="label_and_input">
            <label class="form_label"><?= $field_note; ?>:</label>
            <input class="input_text" type="textarea" name="note"
                value="<?php if (isset($res_status) && $res_status == 'fail' && isset($note)) echo $note; ?>">
        </div>

    </div>
</div>

<?php //getMy(get_defined_vars()); ?>