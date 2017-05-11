<div class="row">
    <div class="small-12 columns">
        <h2 class="center"><?php echo $title; ?></h2>
    </div>
</div>
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
        <?php echo form_open('registration/resend'); ?>
            <div class="row">
                <div class="small-12 columns">
                    <label>Username
                       <input type="text" name="username" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="small-12 columns">
                    <label>Email Address
                        <input type="text" name="email" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="small-12 large-4 large-offset-4 columns">
                    <input type="submit" name="submit" class="expanded button" value="Send Email" />
                </div>
            </div>
        </form>
    </div>
</div>