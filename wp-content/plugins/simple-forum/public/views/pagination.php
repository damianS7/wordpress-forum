<?php if (is_array($data['pagination'])): ?>
<div class="mt-2">
    <ul class="pagination pagination-sm">
        <li class="page-item">
            <a class="page-link" href="<?php echo SimpleForum::view_url() . $data['pagination']['first']; ?>">&laquo;</a>
        </li>
        <li class="page-item <?php echo (SimpleForum::get_query_var('spf_pagination') <= $data['pagination']['first'])  ? 'disabled' : ''; ?>">                
            <a class="page-link" href="<?php echo SimpleForum::view_url() . $data['pagination']['prev']; ?>">&lt;</a>
        </li>
        <li class="page-item">
            <strong class="page-link">Page <?php echo $data['pagination']['actual']; ?> of <?php echo $data['pagination']['last']; ?></strong>
        </li>
        <li class="page-item <?php echo (SimpleForum::get_query_var('spf_pagination') >= $data['pagination']['last'])  ? 'disabled' : ''; ?>">
           <a class="page-link" href="<?php echo SimpleForum::view_url() . $data['pagination']['next']; ?>">&gt;</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?php echo SimpleForum::view_url() . $data['pagination']['last']; ?>">&raquo;</a>
        </li>
    </ul>
</div>
<?php endif; ?>