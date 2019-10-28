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
  <div class="mt-2">
    <ul class="pagination pagination-sm">
      <li class="page-item disabled">
        <a class="page-link" href="#">&laquo;</a>
      </li>
      <li class="page-item active">
        <a class="page-link" href="#">1</a>
      </li>
      <li class="page-item">
        <a class="page-link" href="#">&raquo;</a>
      </li>
    </ul>
  </div>
<?php endif; ?>
<?php if (SimpleForumAuth::is_auth()): ?>
<form method="POST" action="">
  <fieldset>
    <div class="form-group">
      <label for="exampleTextarea">Say something in this post ...</label>
      <textarea class="form-control" name="spf_posts_content" rows="3"></textarea>
    </div>
    <button type="submit" name="spf_submit" class="btn btn-block btn-primary">NEW POST</button>
  </fieldset>
  <input type="hidden" name="spf_posts_user_id" value="1">
  <input type="hidden" name="spf_posts_topic_id" value="<?php echo get_query_var('page'); ?>">
</form>
<?php else: ?>
Please create an account to send an answer
<?php endif; ?>
<?php if (!empty($data['error_message'])): ?>
  <div class="alert alert-danger">
    <?php echo $data['error_message']; ?>
  </div>
<?php endif; ?>
<?php if (!empty($data['success_message'])): ?>
  <div class="alert alert-success">
    <?php echo $data['success_message']; ?>
  </div>
<?php endif; ?>
