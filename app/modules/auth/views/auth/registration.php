<div class="row">
   <div class="header col-md-12"></div>
</div>
 
<div class="row">   
   
      <div class="pimPane" style="width:100%"><!-- update class for registr-->
            <div class="head">
               <h1> NEW APPLICANT REGISTRATION</h1>
            </div> 
         
         <div class="inner">


             <?php echo form_open("auth/registration_user");?>
                <fieldset>
                      <div class="leftfloat">

                          <div id="infoMessage"><?php echo $message;?></div>

                                 <div class="input required">
                                     <?php echo lang('create_user_email_label', 'email');?>
                                     <?php echo form_input($email);?>
                                 </div>

                                 <div class="input required">
                                     <?php echo lang('create_user_password_label', 'password');?>
                                     <?php echo form_input($password);?>
                                 </div>

                                 <div class="input required">
                                     <?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
                                     <?php echo form_input($password_confirm);?>
                                 </div>

                          <div class="input required">
                              <?php echo lang('create_user_select_group_label', 'groups');?>
                              <?php echo form_dropdown('groups', $groups, '1', 'class="form-control"'); ?>
                          </div>


                            </div>
                               <div><button class="btn btn-primary" ><?php echo lang('registration_user_submit_btn'); ?></button>
                                   <?php //echo form_submit('submit', lang('registration_user_submit_btn'),"class='btn btn-primary'");?> </div>
                </fieldset>
            </form>
      
      </div> <!-- inner -->
   </div>
</div>