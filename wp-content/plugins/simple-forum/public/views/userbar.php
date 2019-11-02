    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo get_permalink() . 'forums'; ?>">Forum</a>        
                </li> 
                <?php if (SPF_AccountController::is_auth()): ?>
                    <li class="nav-item">
                        <p> Welcome 
                        <strong><?php echo $_SESSION['account']->username;?></strong>
                        </p>
                    </li>  
                <?php endif; ?>
                <li class="nav-item">
                    <?php if (SPF_AccountController::is_auth()): ?>
                        <a class="nav-link" href="<?php echo get_permalink() . '/profile'; ?>">Profile</a>
                    <?php else: ?>
                        <a class="nav-link" href="<?php echo get_permalink() . 'login'; ?>">Login</a>
                    <?php endif; ?>
                </li>
            <li class="nav-item">
                <?php if (SPF_AccountController::is_auth()): ?>
                    <a class="nav-link" href="<?php echo get_permalink() . 'logout'; ?>">Logout</a>
                <?php else: ?>
                    <a class="nav-link" href="<?php echo get_permalink() . 'register'; ?>">Register</a>
                <?php endif; ?>
            </li>
        </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav> 