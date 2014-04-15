<div class="col-md-6 col-md-offset-3 panel panel-default">

        <h1 class="margin-base-vertical">Content Management System Login</h1>
          
          <?php if( !empty($message) ){ ?>
              <div class="alert alert-error">  
                <!-- <a class="close" data-dismiss="alert">x</a>   -->
                <?php echo $message ?>  
              </div> 
          <?php } ?>        

        <?php echo form_open("auth/login", 'class="margin-base-vertical"');?>
          <p class="input-group">
            <span class="input-group-addon"><span class="icon-envelope"></span></span>
            <input type="text" class="form-control input-lg" name="identity" placeholder="cms_user@domain.com" />
          </p>

          <p class="input-group">
            <span class="input-group-addon"><span class="icon-key"></span></span>
            <input type="password" class="form-control input-lg" name="password" />
          </p>

          <p class="help-block text-center"><small>Please use your e-mail and Password to login.</small></p>
          <p class="text-right">
            <button type="submit" class="btn btn-success btn-lg"><i class="fa icon-signin fa-fw"></i> Login</button>
          </p>
          </span>
        </form>

        <div class="margin-base-vertical">
          
        </div>

</div><!-- // panel -->
