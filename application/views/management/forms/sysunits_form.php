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
            <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
            <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
            <th><?php echo isset($field_workplace)  ? $field_workplace  : ''; ?></th>
            <th><?php echo isset($field_fa)         ? $field_fa         : ''; ?></th>
            <th><?php echo isset($field_inv_num)    ? $field_inv_num    : ''; ?></th>
            <th><?php echo isset($field_inv_status) ? $field_inv_status : ''; ?></th>
            <th><?php echo isset($field_com_date)   ? $field_com_date   : ''; ?></th>
            <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
        </tr>
        <tr>
            <?='<td>'.$editable_line->$id_column.'</td>'?>
            <?='<td>'.$editable_line->devtype->devtype_name.'</td>'?>
            <?='<td>'.$editable_line->vendor->vendor_name.'</td>'?>
            <?='<td>'.$editable_line->model.'</td>'?>
            <?='<td>'.$editable_line->location->location_name.'</td>'?>
            <?='<td>'.$editable_line->status->status_name.'</td>'?>
            <?='<td>'.$editable_line->wp_id.'</td>'?>
            <?='<td>'.$editable_line->fa.'</td>'?>
            <?='<td>'.$editable_line->inv_num.'</td>'?>
            <?php
                echo $editable_line->inv_status == 'G' ?
                '<td>Числится</td>' :
                '<td>Не числится</td>';
            ?>
            <?php
            echo "<td>";
            if (isset($res_status) && $res_status == 'fail' &&
                isset($com_date) && is_numeric($com_date))
                echo date("d.m.Y", $com_date);
            echo "</td>";
            ?>
            <?='<td>'.$editable_line->note.'</td>'?>
        </tr>
    </table>
</div>
<?php } ?>

<div class="block_inside_form">
    <div class="form_block_pair">

        <input type="text" name="id" hidden value="<?php echo isset($id) ? $id :''; ?>">

        <div class="label_and_select">
            <label class="form_label"><?=$field_devtype?>:</label>
            <select class="input_text" name="devtype_id" required>
                <?php foreach ($select_devtypes as $devtype): ?>
                <option value="<?=$devtype->devtype_id?>"
                    <?php
                        if (isset($res_status) && $res_status == 'fail' && isset($devtype_id))
                            if ($devtype->devtype_id == $devtype_id) echo ' selected';
                    ?>
                ><?=$devtype->devtype_name?></option>
            <?php endforeach; ?>
            </select>
        </div>

        <div class="label_and_select">
            <label class="form_label"><?=$field_vendor?>:</label>
            <select class="input_text" name="vendor_id">
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
                "<?php if (isset($res_status) && $res_status == 'fail' && isset($model)) echo $model; ?>">
        </div>

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

    </div>

    <div class="form_block_pair">

        <div class="label_and_input">
            <label class="form_label"><?=$field_fa; ?>:</label>
            <input class="input_text" type="text" name="fa" value=
                "<?php if (isset($res_status) && $res_status == 'fail' && isset($fa)) echo $fa; ?>"
            >
        </div>

        <div class="label_and_input">
            <label class="form_label"><?=$field_inv_num?>:</label>
            <input class="input_text" type="text" name="inv_num" value=
                "<?php if (isset($res_status) && $res_status == 'fail' && isset($inv_num))
                echo $inv_num; ?>"
            >
        </div>

        <div class="label_and_select">
            <label class="form_label"><?=$field_inv_status?>:</label>
            <select class="input_text" name="inv_status">
                <option selected="" value="G">Числится</option>
                <option value="B">Не числится</option>
            </select>
        </div>

        <div class="label_and_input">
            <label class="form_label"><?=$field_com_date?>:</label>
            <input class="input_text tcal tcalInput" type="text" name="com_date" id="date" value=
            "<?php
            if (isset($res_status) && $res_status == 'fail' &&
                isset($com_date) && is_numeric($com_date))
                echo date("d.m.Y", $com_date);
            ?>"
            pattern="<?=$date_pattern?>"
            >
        </div>

        <div class="label_and_input">
            <label class="form_label"><?= $field_note; ?>:</label>
            <input class="input_text" type="textarea" name="note"
                value="<?php if (isset($res_status) && $res_status == 'fail' && isset($note)) echo $note; ?>">
        </div>

    </div>
</div>

<?php //getMy(get_defined_vars()); ?>