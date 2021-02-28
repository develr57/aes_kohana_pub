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
            <th><?php echo isset($field_devg) ? $field_devg : ''; ?></th>
            <th><?php echo isset($field_devt) ? $field_devt : ''; ?></th>
        </tr>
            <tr>
                <?='<td>'.$editable_line->$id_column.'</td>'?>
                <?='<td>'.$editable_line->devgroup->devgroup_name.'</td>'?>
                <?='<td>'.$editable_line->devtype_name.'</td>'?>
            </tr>
    </table>
</div>
<?php } ?>

<div class="block_inside_form">
    <div class="form_block_pair">
        <div class="label_and_select">
            <input type="text" name="id" hidden value="<?php echo isset($id) ? $id :''; ?>">
            <label class="form_label"><?php echo $field_devg; ?></label>
            <select class="input_text" name="devgroup_id" required="">
                <option value="">Выберите группу</option>
                <?php foreach ($select_devgroups as $sel_devgroup): ?>
                <option value="<?= $sel_devgroup->devgroup_id ?>"
                    <?php
                        if (isset($devgroup_id))
                        {
                            if ($sel_devgroup->devgroup_id == $devgroup_id) echo " selected";
                        }
                    ?>
                        ><?= $sel_devgroup->devgroup_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="label_and_input">
            <label class="form_label"><?php echo $field_devt; ?>:</label>
            <input class="input_text" type="text" name="devtype_name" required value=
                "<?php if (isset($res_status) && $res_status == 'fail' && isset($devtype_name)) echo $devtype_name; ?>">
        </div>
    </div>
    <div class="form_block_pair">
    </div>
</div>

<?php #debug(get_defined_vars()); ?>