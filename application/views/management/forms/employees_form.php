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
            <th><?php echo isset($field_surname)    ? $field_surname    : ''; ?></th>
            <th><?php echo isset($field_name)       ? $field_name       : ''; ?></th>
            <th><?php echo isset($field_patronymic) ? $field_patronymic : ''; ?></th>
            <th><?php echo isset($field_short)      ? $field_short      : ''; ?></th>
            <th><?php echo isset($field_position)   ? $field_position   : ''; ?></th>
            <th><?php echo isset($field_department) ? $field_department : ''; ?></th>
        </tr>
            <tr>
                <?='<td>'.$editable_line->$id_column.           '</td>'?>
                <?='<td>'.$editable_line->surname.              '</td>'?>
                <?='<td>'.$editable_line->name.                 '</td>'?>
                <?='<td>'.$editable_line->patronymic.           '</td>'?>
                <?='<td>'.$editable_line->short.                '</td>'?>
                <?='<td>'.$editable_line->position.             '</td>'?>
                <?='<td>'.$editable_line->department->dept_name.'</td>'?>
            </tr>
    </table>
</div>
<?php } ?>

<div class="block_inside_form">
    <div class="form_block_pair">
        <div class="label_and_input">
            <input type="text" name="id" hidden value="<?php echo isset($id) ? $id :''; ?>">
            <label class="form_label"><?php echo $field_surname; ?>:</label>
            <input class="input_text" type="text" name="surname" required value=
                "<?php if (isset($res_status) && $res_status == 'fail' && isset($surname)) echo $surname; ?>">
        </div>
        <div class="label_and_input">
            <label class="form_label"><?php echo $field_name; ?>:</label>
            <input class="input_text" type="text" name="name" required value=
                "<?php if (isset($res_status) && $res_status == 'fail' && isset($name)) echo $name; ?>">
        </div>
        <div class="label_and_input">
            <label class="form_label"><?php echo $field_patronymic; ?>:</label>
            <input class="input_text" type="text" name="patronymic" required value=
                "<?php if (isset($res_status) && $res_status == 'fail' && isset($patronymic)) echo $patronymic; ?>">
        </div>
    </div>
    <div class="form_block_pair">
        <div class="label_and_input">
            <label class="form_label"><?php echo $field_position; ?>:</label>
            <input class="input_text" type="text" name="position" required value=
                "<?php if (isset($res_status) && $res_status == 'fail' && isset($position)) echo $position; ?>">
        </div>
        
        <div class="label_and_select">
            <label class="form_label"><?php echo $field_department; ?>:</label>
            <select class="input_text" name="dept_id" required>
                <option>Выберите отдел</option>
                <?php foreach ($select_department as $sel_dept): ?>
                <option value="<?= $sel_dept->dept_id ?>"
                    <?php
                        if (isset($dept_id))
                        {
                            if ($sel_dept->dept_id == $dept_id) echo " selected";
                        }
                    ?>
                ><?= $sel_dept->dept_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<?php //getMy(get_defined_vars()); ?>