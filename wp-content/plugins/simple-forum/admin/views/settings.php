<div class="wrap">
    <h1>SETTINGS</h1>
    <hr>
</div>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">name</th>
            <th scope="col">value</th>
            <th scope="col">description</th>
            <th scope="col">manage</th>
        </tr>
    </thead>
    <tbody>
        <?php if (is_array($data['settings'])): ?>
        <?php foreach ($data['settings'] as $setting): ?>
        <form class="form-inline" action="" method="post">
            <tr>
                <td><?php echo $setting->name; ?></td>
                <td><input type="text" name="setting_value" value="<?php echo $setting->value; ?>"></td>
                <td><?php echo $setting->name; ?></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="submit" name="update_setting" class="btn btn-success btn-sm">UPDATE <i
                                    class="fa fa-angle-right"></i></button>
                        </span>
                    </div>
                    <input type="hidden" name="setting_name" value="<?php echo $setting->name; ?>">
                </td>
            </tr>
        </form>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>