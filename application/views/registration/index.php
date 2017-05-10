<div class="row">
	<div class="small-12 large-6 large-offset-3 columns">
        <?php if (validation_errors() !== '') : ?>
            <div class="row">
                <div class="small-12 columns">
                    <div class="callout alert">
                        <?php echo validation_errors(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row">
	<div class="small-12 columns">
	<?php echo form_open('registration/create'); ?>
		<div class="row">
			<div class="small-12 columns">
				<h2 class="center">Registration Information</h2>
			</div>
		</div>
		<div class="row">
			<div class="small-12 large-3 large-offset-3 columns">
				<label>First Name
					<input type="text" value="<?php echo set_value('first_name'); ?>" name="first_name" />
				</label>
			</div>
			<div class="small-12 large-3 columns">
				<label>Last Name
					<input type="text" value="<?php echo set_value('last_name'); ?>" name="last_name" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 large-3 large-offset-3 columns">
				<label>Username
					<input type="text" value="<?php echo set_value('username'); ?>" name="username" />
				</label>
			</div>
			<div class="small-12 large-3 columns">
				<label>Email Address
					<input type="text" value="<?php echo set_value('email_address'); ?>" name="email_address" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 large-3 large-offset-3 columns">
				<label>Password
					<input type="password" name="password" />
				</label>
			</div>
			<div class="small-12 large-3 columns">
				<label>Confirm Password
					<input type="password" name="passconf" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 large-4 large-offset-4 columns">
                <input type="submit" name="submit" class="expanded button" value="Register" />
            </div>
		</div>
	</form>
</div>