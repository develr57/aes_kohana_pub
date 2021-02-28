<?php
extract($def_vars);
if (isset($result)) extract($result);
?>

<div class="block_inside_form">
    <div class="form_block_pair">
        <input type="text" name="id" hidden value="<?php echo isset($id) ? $id :''; ?>">
        <div class="label_and_input">
            <label class="form_label"><?php echo $label_field; ?>:</label>
            <input class="input_text" type="text" name="text_value" required value=
                "<?php if (isset($res_status) && $res_status == 'fail' && isset($text_value)) echo $text_value ; ?>"
            >
        </div>
    </div>
    <div class="form_block_pair">
    </div>
</div>