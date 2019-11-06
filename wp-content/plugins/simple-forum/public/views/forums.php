<?php if (isset($data['forums'])): ?>
<div class="card text-white bg-primary mb-3">
    <div class="card-header">Forums</div>
    <?php foreach ($data['forums'] as $forum): // Listado de categorias?>
    <div class="card-body">
        <h4 class="card-title">
            <a href="<?php echo SimpleForum::pagination_url('topics', $forum->id, 1); ?>" class="card-link">
                <?php echo $forum->name; ?>
            </a>
        </h4>
        <p class="card-text"><?php echo $forum->description; ?></p>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>