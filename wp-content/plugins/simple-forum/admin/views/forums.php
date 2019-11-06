<div class="wrap">
    <h1>FORUMS</h1>
    <hr>
</div>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Forum</th>
            <th scope="col">Description</th>
            <th scope="col">Manage</th>
        </tr>
    </thead>
    <tbody>
        <?php if (is_array($data['forums'])): ?>
        <?php foreach ($data['forums'] as $forum): ?>
        <tr>
            <th scope="row"><?php echo $forum->id; ?></th>
            <td><?php echo $forum->name; ?></td>
            <td><?php echo $forum->description; ?></td>
            <td>
                <form class="form-inline" action="" method="post">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="submit" name="delete_forum" class="btn btn-success btn-sm">DELETE <i
                                    class="fa fa-angle-right"></i></button>
                        </span>
                    </div>
                    <input type="hidden" name="forum_id" value="<?php echo $forum->id; ?>">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<form method="POST">
    <fieldset>
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Forum name">
        </div>
        <div class="form-group">
            <textarea type="text" class="form-control" name="description" placeholder="Forum description"></textarea>
        </div>
        <button type="submit" name="create_forum" class="btn btn-block btn-primary">NEW FORUM</button>
    </fieldset>
</form>