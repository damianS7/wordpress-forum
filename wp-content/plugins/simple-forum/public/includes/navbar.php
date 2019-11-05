<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo SimpleForum::view_url('forums'); ?>">Forum</a>        
            </li> 
            <li class="nav-item">
                <?php if (SPF_AccountController::is_auth()): ?>
                    <a class="nav-link" href="<?php echo SimpleForum::view_url('profile'); ?>">Profile</a>
                <?php else: ?>
                    <a class="nav-link" href="<?php echo SimpleForum::view_url('login'); ?>">Login</a>
                <?php endif; ?>
            </li>
        <li class="nav-item">
            <?php if (SPF_AccountController::is_auth()): ?>
                <a class="nav-link" href="<?php echo SimpleForum::view_url('logout'); ?>">Logout</a>
            <?php else: ?>
                <a class="nav-link" href="<?php echo SimpleForum::view_url('register') ?>">Register</a>
            <?php endif; ?>
        </li>
    </ul>
    <form method="POST" action="<?php echo SimpleForum::view_url('search'); ?>" class="form-inline">
        <input class="form-control input-sm" name="query" type="text" placeholder="Search">
    </form>
    </div>
</nav> 