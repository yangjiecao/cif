<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('blog/create'); ?>

    <label for="name">Name</label>
    <input type="input" name="name" /><br />

    <label for="degree">Degree</label>
    <textarea name="degree"></textarea><br />

    <input type="submit" name="submit" value="Create news item" />

</form>