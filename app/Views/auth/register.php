<div class="app-container" style="justify-content: center; align-items: center; min-height: 60vh;">
    <div class="page-wrapper" style="max-width: 400px;">
        <h2 style="text-align: center;">Register</h2>
        <?php if (isset($error)): ?>
            <p style="color: red; text-align: center;"><?php echo $error; ?></p>
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
            <button type="submit" class="btn btn-block" style="padding: 0.75rem;">Register</button>
        </form>
        <p style="text-align: center; margin-top: 1rem;">
            Already have an account? <a href="/login">Login here</a>
        </p>
    </div>
</div>
