<style>
    #news_editor,
    #news_previewer {
        width: 100%;
        height: 600px;
        display: inline-block;
    }
    #news_editor {
        padding: 5px;
    }
    .crevasse_previewer.github_theme {
        padding-left: 5px;
        padding-right: 5px;
    }
</style>
<h2><?php echo $title; ?></h2>
<?php if (validation_errors() !== '') : ?>
    <div class="row">
        <div class="small-12 columns">
            <div class="callout alert">
                <?php echo validation_errors(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php echo form_open('news/create'); ?>
    <div class="row">
        <div class="small-6 columns">
	        <label>Title
	           <input type="text" name="title" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <label>Blurb
                <input type="text" name="blurb" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
	        <label for="text">Text
                <div class="row">
                    <div class="small-6 columns">
                        <textarea name="text" id="news_editor"></textarea>
                    </div>
                    <div class="small-6 columns">
                        <div id="news_previewer"></div>
                    </div>
                </div>
            </label>
        </div>
    </div>
	<input type="submit" name="submit" class="button" value="Submit" />
</form>