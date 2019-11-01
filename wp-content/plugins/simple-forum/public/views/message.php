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