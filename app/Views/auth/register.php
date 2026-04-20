<div class="app-container auth-wrapper">
    <div class="page-wrapper auth-card">
        <h2 class="text-center">Register</h2>
        <?php if (isset($error)): ?>
            <p class="text-danger text-center"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="/register" method="POST">
            <div class="filter-group">
                <label>Username:</label>
                <input type="text" name="username" required class="filter-input">
            </div>
            <div class="filter-group">
                <label>Password:</label>
                <input type="password" name="password" required class="filter-input">
            </div>
            <div class="filter-group">
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" required class="filter-input">
            </div>
            <button type="submit" class="btn btn-block btn-md">Register</button>
        </form>
        <p class="text-center mt-1">
            Already have an account? <a href="/login">Login here</a>
        </p>
    </div>
</div>
