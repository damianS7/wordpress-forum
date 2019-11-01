<?php include_once('userbar.php'); ?>
<?php include_once('breadcrumb.php'); ?>
<?php if (is_array($data['posts'])): ?>
  <div class="card text-white bg-primary mb-3">
    <div class="card-header"><?php echo $data['topic']->title; ?></div>
    <?php foreach ($data['posts'] as $post): // Listado de categorias?>
      <div class="card-body">
        <h4 class="card-title">
          <?php echo $post['posted_at']; ?>
          <?php echo $post['username']; ?>
        </h4>
        <p class="card-text"><?php echo $post['post_content']; ?></p>
      </div>
    <?php endforeach; ?>
  </div>
<?php include_once('pagination.php'); ?>
<?php endif; ?>
<?php if (SPF_AccountController::is_auth()): ?>
<form method="POST" action="">
  <fieldset>
    <div class="form-group">
      <label for="exampleTextarea">Say something in this post ...</label>
      <textarea class="form-control" name="content" rows="3"></textarea>
    </div>
    <button type="submit" name="spf_submit" class="btn btn-block btn-primary">NEW POST</button>
  </fieldset>
  <input type="hidden" name="topic_id" value="<?php echo get_query_var('page'); ?>">
</form>
<?php else: ?>
Please create an account to send an answer
<?php endif; ?>
<?php include_once('message.php'); ?>
