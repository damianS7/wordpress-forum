<div class="alert alert-primary">
    Results for: <strong><?php echo $data['search']; ?></strong>
</div>

<div class="list-group">
    <?php if (is_array($data['topics'])): ?>
    <?php foreach ($data['topics'] as $topic):  ?>
    <a href="<?php echo SimpleForum::view_url('posts', $topic->id, 1); ?>"
        class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"><?php echo $topic->title; ?></h5>
            <small class="text-muted"><?php echo $topic->created_at; ?></small>
        </div>
        <p class="mb-1"><?php echo $topic->content; ?></p>
        <small class="text-muted">Author: <?php echo $topic->author; ?></small>
    </a>
    <?php endforeach; ?>
    <?php endif;?>
</div>