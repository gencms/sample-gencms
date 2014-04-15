<h1><?php echo lang('registration_user_heading');?></h1>
<p><?php echo lang('registration_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/registration_user");?>

      <p>
            <?php echo lang('create_user_email_label', 'email');?> <br />
            <?php echo form_input($email);?>
      </p>

      <p>
            <?php echo lang('create_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
            <?php echo form_input($password_confirm);?>
      </p>

      <p>
            <?php echo lang('create_user_select_group_label', 'groups');?> <br />
          <?php echo form_dropdown('groups', $groups, '1'); ?>
      </p>


      <p><?php echo form_submit('submit', lang('registration_user_submit_btn'));?></p>

<?php echo form_close();?>
