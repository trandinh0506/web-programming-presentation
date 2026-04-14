<div class="app-container" style="justify-content: center; align-items: center; min-height: 60vh;">
    <div class="page-wrapper" style="max-width: 400px;">
        <h2 style="text-align: center;">Login</h2>
        <?php if (isset($error)): ?>
            <p style="color: red; text-align: center;"><?php echo $error; ?></p>
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
            <button type="submit" class="btn btn-block" style="padding: 0.75rem;">Login</button>
        </form>
    </div>
</div>
