		<div class="panel panel-default">
	        <div class="head">
                  <h1>Edit User
                  		<span class="but">
                  			<?php echo anchor("auth/list_users", "<i class=\"fa icon-list fa-fw\"></i> View All", 'class="btn btn-info"') ?>
                  		</span>
                  </h1>
            </div> 
		   
			<div class="inner" id="cms_content_area">

                <?php if( !empty($message) ){ ?>
	                <div class="alert alert-error">  
					  <a class="close" data-dismiss="alert">x</a>  
					  <?php echo $message ?>  
					</div> 
				<?php } ?>

					<form id="cms_form" method="post" action="<?php echo site_url("auth/user_edit/$id") ?>">
		                <fieldset>
							<div class="leftfloat">  							   
							   <div class="<?php if (form_error('fullname')) echo 'form-group has-error'; ?>">
		                         <label for="fullname">Full Name</label>
                                 <?php echo form_error('fullname'); ?>
							     <input id="fullname" name="fullname" class="form-control" type="text" value="<?php echo set_value('fullname', $user->username) ?>">
							   </div>
							   <div class="<?php if (form_error('email')) echo 'form-group has-error'; ?>">
		                         <label for="email">Email</label>
                                 <?php echo form_error('email'); ?>
							     <input id="email" name="email" class="form-control" type="email" value="<?php echo set_value('email', $user->email) ?>">
							   </div>
							   <div class="<?php if (form_error('username')) echo 'form-group has-error'; ?>">
		                         <label for="username">Username</label>
                                 <?php echo form_error('username'); ?>
							     <input id="username" name="username" class="form-control" type="text" value="<?php echo set_value('username', $user->username) ?>">
							   </div>
							   <div class="<?php if (form_error('password')) echo 'form-group has-error'; ?>">
		                         <label for="password">Password</label>
                                 <?php echo form_error('password'); ?>
							     <input id="password" name="password" class="form-control" type="password">
							   </div>
							   		
							   <?php echo form_hidden("id", $id) ?>	
									   
						   </div>						  						   
		                </fieldset>
		                <div class="submit">
							<button type="submit" class="btn btn-info btn-lg"><i class="fa icon-save fa-fw"></i> Save</button>
						</div>
					</form>

	         </div>
		</div>
