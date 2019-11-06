<?php if (is_array($data['posts'])): ?>
<div id="pagination-top" class="row">
  <?php include(PLUGIN_DIR . 'public/includes/pagination.php'); ?>
</div>
  <div class="card text-white bg-primary mb-3">
    <div class="card-header">
      <strong>
        <?php echo strtoupper($data['topic']->title); ?>
      </strong>
    </div>
    <?php foreach ($data['posts'] as $post): // Listado de categorias?>
      <div class="card-body">
        <h4 class="card-title">
          Written by <?php echo $post->username; ?>
          on <?php echo $post->posted_at; ?>
        </h4>
        <?php if ($post->banned == '1'): ?>
          <i class="card-text">This message is hidden because the owner is banned.</i>
        <?php else: ?>
          <p class="card-text"><?php echo $post->post_content; ?></p>
        <?php endif; ?>
        <a href="<?php echo SimpleForum::view_url('report', $post->id); ?>" class="card-link">Report</a>
      </div>
    <?php endforeach; ?>
  </div>
<div id="pagination-bottom" class="row">
  <?php include(PLUGIN_DIR . 'public/includes/pagination.php'); ?>
</div>
<?php endif; ?>
<div class="row">
  <div class="col-sm-12">
    <?php if (SPF_AccountController::is_auth()): ?>
    <form method="POST">
      <fieldset>
        <div class="form-group">
          <textarea class="form-control" name="content" rows="4" placeholder="Say something ..."></textarea>
        </div>
        <button type="submit" class="btn btn-block btn-primary">NEW POST</button>
      </fieldset>
    </form>
    <?php else: ?>
    Please create an account to send an answer
    <?php endif; ?>
    </div>
</div>