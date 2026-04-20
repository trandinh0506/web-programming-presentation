<div class="app-container auth-wrapper">
    <div class="page-wrapper auth-card">
        <h2 class="text-center">Login</h2>
        <?php if (isset($error)): ?>
            <p class="text-danger text-center"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="/login" method="POST">
            <div class="filter-group">
                <label>Username:</label>
                <input type="text" name="username" required class="filter-input">
            </div>
            <div class="filter-group">
                <label>Password:</label>
                <input type="password" name="password" required class="filter-input">
            </div>
            <button type="submit" class="btn btn-block btn-md">Login</button>
        </form>
    </div>
</div>
