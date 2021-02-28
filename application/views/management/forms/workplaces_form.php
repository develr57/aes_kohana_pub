<?php
extract($def_vars);
if (isset($result)) extract($result);
if (isset($editable_line)) {
?>
    <div class="editable_line_block">
        <p>Редактируемая запись:</p>
        <table class="table_above_form">
            <tr>
                <th>ID</th>
                <th><?php echo isset($field_wp_name)    ? $field_wp_name    : ''; ?></th>
                <th><?php echo isset($field_employee)   ? $field_employee   : ''; ?></th>
                <th><?php echo isset($field_department) ? $field_department : ''; ?></th>
                <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
                <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
                <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
            </tr>
            <tr>
                <?= '<td>' . $editable_line->$id_column . '</td>' ?>
                <?= '<td>' . $editable_line->wp_name . '</td>' ?>
                <?= '<td>' . $editable_line->employee->short . '</td>' ?>
                <?= '<td>' . $editable_line->department->dept_id . '</td>' ?>
                <?= '<td>' . $editable_line->location->location_name . '</td>' ?>
                <?= '<td>' . $editable_line->status->status_name . '</td>' ?>
                <?= '<td>' . $editable_line->note . '</td>' ?>
            </tr>
        </table>
    </div>
<?php } ?>

<div class="block_inside_form">
    <div class="form_block_pair">

        <input type="text" name="id" hidden value="<?php echo isset($id) ? $id : ''; ?>">

        <div class="label_and_input">
            <label class="form_label"><?= $field_wp_name ?>:</label>
            <input class="input_text" type="text" name="wp_name"
                value="<?php if (isset($res_status) && $res_status == 'fail' && isset($wp_name)) echo $wp_name; ?>">
        </div>

        <div class="label_and_select">
            <label class="form_label"><?= $field_employee ?>:</label>
            <select class="input_text" name="emp_id" required>
                <option>Выберите сотрудника</option>
                <?php foreach ($select_employees as $employee) : ?>
                    <option value="<?= $employee->emp_id ?>"
                    <?php
                    if (isset($res_status) && $res_status == 'fail' && isset($emp_id))
                        if ($employee->emp_id == $emp_id) echo ' selected';
                    ?>><?= $employee->short ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="label_and_select">
            <label class="form_label"><?php echo $field_department; ?>:</label>
            <select class="input_text" name="dept_id" required>
                <option>Выберите отдел</option>
                <?php foreach ($select_departments as $sel_dept) : ?>
                    <option value="<?= $sel_dept->dept_id ?>"
                    <?php
                    if (isset($dept_id)) if ($sel_dept->dept_id == $dept_id) echo " selected";
                    ?>><?= $sel_dept->dept_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>

    </div>

    <div class="form_block_pair">

    <div class="label_and_select">
            <label class="form_label"><?= $field_location ?>:</label>
            <select class="input_text" name="location_id" required>
                <option value="">Выберите локацию</option>
                <?php foreach ($select_locations as $location) : ?>
                    <option value="<?= $location->location_id ?>"
                        <?php
                        if (isset($res_status) && $res_status == 'fail' && isset($location_id))
                            if ($location->location_id == $location_id) echo ' selected';
                        ?>><?= $location->location_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="label_and_select">
            <label class="form_label"><?= $field_status ?>:</label>
            <select class="input_text" name="status_id">
                <?php foreach ($select_statuses as $status) : ?>
                    <option value="<?= $status->status_id ?>"
                        <?php
                        if (isset($res_status) && $res_status == 'fail' && isset($status_id))
                            if ($status->status_id == $status_id) echo ' selected';
                        ?>><?= $status->status_name ?></option>
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

<?php //getMy(get_defined_vars()); 
?>