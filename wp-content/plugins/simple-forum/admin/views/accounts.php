<div class="wrap">
    <h1>ACCOUNTS</h1>
    <hr> 
</div>
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
<?php if (is_array($data['accounts'])): ?>
<?php foreach ($data['accounts'] as $account): ?>
<tr>
  <form class="form-inline" action="" method="post">
    <td><?php echo $account->id; ?></th>
    <td><input type="text" name="account_username" value="<?php echo $account->username; ?>"></td>
    <td><input type="text" name="account_password" value="" placeholder="Press reset pwd after set password"></td>
    <td><input type="text" name="account_mail" value="<?php echo $account->email; ?>"></td>
    <td><?php echo $account->banned; ?></td>
    <td><?php echo $account->activated; ?></td>
    <td>
            <div class="input-group">
                <span class="input-group-btn">
                    <button type="submit" name="delete_account" class="btn btn-success btn-sm">DELETE <i class="fa fa-angle-right"></i></button>
                    <button type="submit" name="ban_account" class="btn btn-success btn-sm">BAN <i class="fa fa-angle-right"></i></button>
                    <button type="submit" name="confirm_account" class="btn btn-success btn-sm">CONFIRM <i class="fa fa-angle-right"></i></button>
                    <button type="submit" name="update_account" class="btn btn-success btn-sm">UPDATE <i class="fa fa-angle-right"></i></button>
                    <button type="submit" name="reset_password" class="btn btn-success btn-sm">RESET PWD <i class="fa fa-angle-right"></i></button>
                </span>
            </div>
            <input type="hidden" name="account_id" value="<?php echo $account->id; ?>">
        </form>
    </td>
</tr>
<?php endforeach; ?>
<?php endif; ?>  
</tbody>
</table>
