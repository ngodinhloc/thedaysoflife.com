<div class="admin-content" id="div-edit-info">
  <input type="hidden" id="tag" name="tag" value="<?php echo $this->data["tag"]; ?>"/>
  <input type="text" class="form-control" id="title" name="title" value="<?php echo $this->data["info"]['title']; ?>"/><br>
  <textarea class="form-control" rows="3" id="content" name="content"><?php echo str_replace("<br>", "\\n", $this->data["info"]['content']); ?></textarea><br>
  <div class="form-group registering  col-xs-12">
    <button type="submit" class="btn btn-primary" id="update-info">Update</button>
    <span id="ajax-loader" class="error"></span>
  </div>
</div>
<div id="confirm"></div>
<script>
  CKEDITOR.replace('content', {
    customConfig: 'config_admin.js'
  });
</script>