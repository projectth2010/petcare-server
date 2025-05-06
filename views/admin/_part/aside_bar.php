<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="../public/dist/img/ic_logo.png" alt="Friday" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Friday Pet</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <?php

        // Example: retrieving username from session
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest User';

        // Example: generating an avatar URL dynamically (e.g., via Gravatar)
        // If you have an email instead, you can do:
        // $email = $_SESSION['email'];
        // $hash = md5(strtolower(trim($email)));
        // $avatarUrl = "https://www.gravatar.com/avatar/$hash?s=160&d=identicon";
        // For demonstration, we'll use a placeholder image service:
        $avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($username) . "&size=160";
        // The above uses ui-avatars.com to generate an avatar. 
        ?>

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <!-- Show dynamic avatar URL -->
                <img
                    src="<?php echo $avatarUrl; ?>"
                    class="img-circle elevation-2"
                    alt="User Image"
                    style="width: 2.1rem; height: 2.1rem;">
            </div>
            <div class="info">
                <!-- Show the username dynamically -->
                <a href="#" class="d-block">
                    <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php echo $self->generateMenu($self->menus(), 2); ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>