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
                    <td><?php echo $report->post_owner; ?></td>
                    <td><textarea class="form-control" rows="6"><?php echo $report->post_content; ?></textarea></td>
                    <td><textarea class="form-control" rows="6"><?php echo $report->reason; ?></textarea></td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <form class="form-inline" action="" method="post">
                                    <button type="submit" name="ban_account"
                                        class="btn btn-success btn-sm btn-block mb-1">BAN AUTHOR </button>
                                    <button type="submit" name="archive_report"
                                        class="btn btn-success btn-sm btn-block mb-1">ARCHIVE </button>
                                    <a
                                        href="<?php echo home_url() . '/spf-forum/posts/' . $report->topic_id . '/1'; ?>">Open
                                        topic</a>
                            </span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $report->reporter_id; ?>">
                        <input type="hidden" name="report_id" value="<?php echo $report->id; ?>">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>