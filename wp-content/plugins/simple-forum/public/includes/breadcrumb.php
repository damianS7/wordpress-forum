<ol class="breadcrumb">
    <?php if (strpos(get_query_var('spf_view'), 'topics') !== false): ?>
    <?php if (isset($data['forum'])): ?>
    <li class="breadcrumb-item"><a href="<?php echo SimpleForum::view_url('forums'); ?>">SPF Forums</a></li>
    <li class="breadcrumb-item"><?php echo $data['forum']->name; ?></li>
    <?php endif; ?>
    <?php elseif (strpos(get_query_var('spf_view'), 'posts') !== false): ?>
    <?php if (isset($data['topic'])): ?>
    <li class="breadcrumb-item"><a href="<?php echo SimpleForum::view_url('forums'); ?>">SPF Forums</a></li>
    <li class="breadcrumb-item"><a
            href="<?php echo SimpleForum::pagination_url('topics', $data['topic']->forum_id, 1); ?>"><?php echo $data['topic']->subforum; ?></a>
    </li>
    <li class="breadcrumb-item"><?php echo substr($data['topic']->title, 0, 5); ?></li>
    <?php endif; ?>
    <?php elseif (strpos(get_query_var('spf_view'), 'forums') !== false): ?>
    <li class="breadcrumb-item">SPF Forums</li>
    <?php endif; ?>
</ol>