<footer style="background:#0f172a;color:#cbd5e1;padding:18px 24px;border-top:1px solid rgba(255,255,255,0.08);">
    <div style="max-width:1100px;margin:0 auto;display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:space-between;font-size:0.85rem;">
        <div style="display:flex;align-items:center;gap:12px;color:#94a3b8;">
            <span style="font-weight:600;color:#e2e8f0;">ISQM System</span>
            <span style="opacity:0.7;">© <?php echo e(date('Y')); ?> All rights reserved.</span>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:10px;text-transform:uppercase;letter-spacing:0.04em;">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" style="color:#94a3b8;text-decoration:none;">Dashboard</a>
                <a href="<?php echo e(route('isqm.index')); ?>" style="color:#94a3b8;text-decoration:none;">Register</a>
                <a href="<?php echo e(route('reports.index')); ?>" style="color:#94a3b8;text-decoration:none;">Reports</a>
                <a href="<?php echo e(route('settings.edit')); ?>" style="color:#94a3b8;text-decoration:none;">Settings</a>
            <?php else: ?>
                <a href="<?php echo e(route('home')); ?>" style="color:#94a3b8;text-decoration:none;">Home</a>
                <a href="<?php echo e(route('login')); ?>" style="color:#94a3b8;text-decoration:none;">Login</a>
            <?php endif; ?>
        </div>
    </div>
</footer>

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/components/footer.blade.php ENDPATH**/ ?>