<div class="wrap">
  <h1>ACCOUNTS</h1>
</div>
<hr> 
  <div class="row">
    <div class="container">  
      <form class="form-inline" action="" method="post">
        <input type="text" name="account_username" value="<?php if (isset($data['last_search'])) {
    echo $data['last_search'];
} ?>" class="form-control" placeholder="Find account by username">
        <button type="submit" name="search_account" class="btn btn-success btn-sm">SEARCH <i class="fa fa-angle-right"></i></button>
      </form>
    </div>
  </div>
  <hr>

<div class="row">
  <div class="container">
    <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Username</th>
      <th scope="col">Password</th>
      <th scope="col">Email</th>
      <th scope="col">Banned</th>
      <th scope="col">Confirmed</th>
      <th scope="col">Manage</th>
    </tr>
  </thead>
  <tbody>
<?php if (isset($data['accounts'])): ?>
<?php foreach ($data['accounts'] as $account): ?>
<tr>
  <form class="form-inline" action="" method="post">
    <td><?php echo $account->id; ?></th>
    <td><input type="text" name="account_username" class="form-control" value="<?php echo $account->username; ?>"></td>
    <td><input type="text" name="account_password" class="form-control" value="" placeholder="set new password"></td>
    <td><input type="text" name="account_mail" class="form-control" value="<?php echo $account->email; ?>"></td>
    <td><?php echo $account->banned; ?></td>
    <td><?php echo $account->activated; ?></td>
    <td>
            <div class="input-group">
                <span class="input-group-btn">
                    <button type="submit" name="ban_account" class="btn btn-success btn-sm btn-block mb-1">BAN <i class="fa fa-angle-right"></i></button>
                    <button type="submit" name="confirm_account" class="btn btn-success btn-sm btn-block mb-1">ACTIVATE <i class="fa fa-angle-right"></i></button>
                    <button type="submit" name="update_account" class="btn btn-success btn-sm btn-block mb-1">UPDATE <i class="fa fa-angle-right"></i></button>
                    <button type="submit" name="reset_password" class="btn btn-success btn-sm btn-block mb-1">RESET PWD <i class="fa fa-angle-right"></i></button>
                </span>
            </div>
            <input type="hidden" name="account_id" value="<?php echo $account->id; ?>">
            <input type="hidden" name="banned" value="<?php echo $account->banned; ?>">
        </form>
    </td>
</tr>
<?php endforeach; ?>
<?php endif; ?>  
</tbody>
</table>
  </div>
</div>


