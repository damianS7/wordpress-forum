<div class="wrap">
  <h1>REPORTS</h1>
</div>
<hr> 


<div class="row">
  <div class="container">
    <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Post owner</th>
      <th scope="col">Post</th>
      <th scope="col">Report</th>
      <th scope="col">Manage</th>
    </tr>
  </thead>
  <tbody>
<?php if (isset($data['reports'])): ?>
<?php foreach ($data['reports'] as $report): ?>
<tr>
  <form class="form-inline" action="" method="post">
    <td><?php echo $report->post_owner; ?></td>
    <td><textarea class="form-control" rows="6"><?php echo $report->post_content; ?></textarea></td>
    <td><textarea class="form-control" rows="6"><?php echo $report->reason; ?></textarea></td>
    <td>
            <div class="input-group">
                <span class="input-group-btn">
                    <button type="submit" name="ban_account" class="btn btn-success btn-sm btn-block mb-1">BAN AUTHOR <i class="fa fa-angle-right"></i></button>
                    <button type="submit" name="update_account" class="btn btn-success btn-sm btn-block mb-1">DELETE POST <i class="fa fa-angle-right"></i></button>
                    <button type="submit" name="update_account" class="btn btn-success btn-sm btn-block mb-1">OPEN TOPIC <i class="fa fa-angle-right"></i></button>
                </span>
            </div>
            <input type="hidden" name="account_id" value="<?php echo $report->id; ?>">
            <input type="hidden" name="banned" value="<?php echo $report->id; ?>">
        </form>
    </td>
</tr>
<?php endforeach; ?>
<?php endif; ?>  
</tbody>
</table>
  </div>
</div>


