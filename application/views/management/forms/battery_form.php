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
            <th><?php echo isset($field_bat_voltage) ? $field_bat_voltage : ''; ?></th>
            <th><?php echo isset($field_bat_capacity) ? $field_bat_capacity : ''; ?></th>
        </tr>
            <tr>
                <?='<td>'.$editable_line->$id_column.'</td>'?>
                <?='<td>'.$editable_line->bat_voltage.'</td>'?>
                <?='<td>'.$editable_line->bat_capacity.'</td>'?>
            </tr>
    </table>
</div>
<?php } ?>

<div class="block_inside_form">
    <div class="form_block_pair">
        <div class="label_and_select">
            <input type="text" name="id" hidden value="<?php echo isset($id) ? $id :''; ?>">
            <label class="form_label"><?php echo $field_bat_voltage; ?></label>
            <select class="input_text" name="bat_voltage" required="">
                <option selected="12" value="12">12V</option>
                <option value="24">24V</option>
            </select>
        </div>
        <div class="label_and_select">
            <label class="form_label"><?php echo $field_bat_capacity; ?></label>
            <select class="input_text" name="bat_capacity" required="">
                <option disabled="" selected="">Выберите</option>
                <option value="7">7 A/h</option>
                <option value="7.2">7.2 A/h</option>
                <option value="7.5">7.5 A/h</option>
                <option value="9">9  A/h</option>
                <option value="12">12 A/h</option>
                <option value="17">17 A/h</option>
                <option value="18">18 A/h</option>
                <option value="24">24 A/h</option>
                <option value="26">26 A/h</option>
                <option value="28">28 A/h</option>
                <option value="33">33 A/h</option>
                <option value="34">34 A/h</option>
                <option value="40">40 A/h</option>
                <option value="50">50 A/h</option>
                <option value="65">65 A/h</option>
            </select>
        </div>
    </div>
    <div class="form_block_pair">
    </div>
</div>

<?php #debug(get_defined_vars()); ?>