    <ol class="breadcrumb">
        <?php if (strpos(get_query_var('spf_view'), 'topics') !== false): ?>
            <li class="breadcrumb-item"><a href="<?php echo get_permalink() . 'forums'; ?>">SPF Forums</a></li>
            <li class="breadcrumb-item"><?php echo $data['forum']->name; ?></li>
        <?php elseif (strpos(get_query_var('spf_view'), 'posts') !== false): ?>
            <li class="breadcrumb-item"><a href="<?php echo get_permalink() . 'forums'; ?>">SPF Forums</a></li>
            <li class="breadcrumb-item"><a href="<?php echo get_permalink() . 'topics/' . $data['topic']->forum_id; ?>"><?php echo $data['topic']->subforum; ?></a></li>
            <li class="breadcrumb-item"><?php echo substr($data['topic']->title, 0, 5); ?></li>
        <?php elseif (strpos(get_query_var('spf_view'), 'forums') !== false): ?>
            <li class="breadcrumb-item">SPF Forums</li>
        <?php endif; ?>
    </ol>