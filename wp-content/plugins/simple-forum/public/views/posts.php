<?php if (is_array($data['posts'])): ?>
<div id="pagination-top" class="row">
  <?php include('pagination.php'); ?>
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
          Written by <?php echo $post['username']; ?>
          on <?php echo $post['posted_at']; ?>
        </h4>
        <p class="card-text"><?php echo $post['post_content']; ?></p>
      </div>
    <?php endforeach; ?>
  </div>
<div id="pagination-bottom" class="row">
  <?php include('pagination.php'); ?>
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