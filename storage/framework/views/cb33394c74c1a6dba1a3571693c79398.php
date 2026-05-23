

<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .admin-search-credit {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.42rem 0.78rem;
        border-radius: 999px;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(37, 99, 235, 0.06));
        border: 1px solid rgba(99, 102, 241, 0.14);
        color: #5b6475;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        animation: adminSearchCreditPulse 4.6s ease-in-out infinite;
    }

    .admin-search-credit i {
        color: #6366f1;
        font-size: 0.82rem;
    }

    @keyframes adminSearchCreditPulse {
        0%, 100% {
            opacity: 0.42;
            transform: translateY(0);
        }
        50% {
            opacity: 0.88;
            transform: translateY(-1px);
        }
    }
</style>
<div class="fade-in">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-gradient-danger text-dark rounded-4 p-4 shadow">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h3 mb-2">
                            <i class="bi bi-shield-check me-2"></i>
                            Admin Dashboard
                        </h1>
                        <p class="mb-0 opacity-75">Advanced system management and user control</p>
                    </div>
                    <div class="col-md-4 text-end d-none d-md-block">
                        <i class="bi bi-gear" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text"
                                       class="form-control"
                                       id="adminSearchInput"
                                       placeholder="Search all submissions (center names, topics, activities, etc.)..."
                                       autocomplete="off">
                                <?php if(Route::has('admin.search.ajax')): ?>
                                    <button class="btn btn-primary" type="button" id="adminSearchBtn" data-search-url="<?php echo e(route('admin.search.ajax')); ?>">
                                        <i class="bi bi-search me-1"></i>Search
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-secondary" type="button" disabled>
                                        <i class="bi bi-search me-1"></i>Search Unavailable
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="admin-search-credit">
                                <i class="bi bi-stars"></i>
                                Developer (idriss mwala)
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mb-4" id="searchResults" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-search me-2"></i>
                        Search Results
                        <span class="badge bg-primary ms-2" id="resultsCount">0</span>
                    </h5>
                </div>
                <div class="card-body" id="searchResultsContent"></div>
            </div>
        </div>
    </div>

    
    <?php if(($stats['pending_users'] ?? 0) > 0): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning-subtle">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-warning-emphasis">
                                <i class="bi bi-clock-history me-2"></i>
                                Pending User Approvals
                                <span class="badge bg-warning ms-2"><?php echo e($stats['pending_users']); ?></span>
                            </h5>

                            <?php if(Route::has('admin.users.index')): ?>
                                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-gear me-1"></i>Manage All Users
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php if(isset($pendingUsers) && $pendingUsers->count() > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Center ID</th>
                                            <th>Cluster</th>
                                            <th>Registered</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $pendingUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                            <i class="bi bi-person text-warning"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-medium"><?php echo e($user->center_id ?? 'No Center ID'); ?></div>
                                                            <small class="text-muted">ID: <?php echo e($user->id); ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted"><?php echo e($user->email); ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark"><?php echo e($user->center_id ?? 'Not provided'); ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-muted"><?php echo e($user->cluster_name ?? 'Not provided'); ?></span>
                                                </td>
                                                <td>
                                                    <small class="text-muted"><?php echo e(optional($user->created_at)->diffForHumans()); ?></small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <?php if(Route::has('admin.users.approve')): ?>
                                                            <form method="POST" action="<?php echo e(route('admin.users.approve', $user)); ?>" class="d-inline">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PATCH'); ?>
                                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to approve this user?')">
                                                                    <i class="bi bi-check-lg"></i>
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>

                                                        <?php if(Route::has('admin.users.reject')): ?>
                                                            <form method="POST" action="<?php echo e(route('admin.users.reject', $user)); ?>" class="d-inline">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PATCH'); ?>
                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to reject this user?')">
                                                                    <i class="bi bi-x-lg"></i>
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if(($stats['pending_users'] ?? 0) > 10 && Route::has('admin.users.index')): ?>
                                <div class="text-center mt-3">
                                    <p class="text-muted mb-2">Showing 10 of <?php echo e($stats['pending_users']); ?> pending users</p>
                                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>View All Pending Users
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 text-muted">No Pending Users</h5>
                                <p class="text-muted">All users have been reviewed and approved or rejected.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-people text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success">
                                <i class="bi bi-arrow-up"></i> +12%
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold"><?php echo e(number_format($stats['total_users'] ?? 0)); ?></h3>
                    <p class="text-muted mb-2">Total Users</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                    </div>
                    <small class="text-muted mt-1">75% of target reached</small>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-file-earmark-text text-info" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info-subtle text-info">
                                <i class="bi bi-arrow-up"></i> Active
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold"><?php echo e(number_format($stats['total_submissions'] ?? 0)); ?></h3>
                    <p class="text-muted mb-2">Total Submissions</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 85%"></div>
                    </div>
                    <small class="text-muted mt-1">All submissions visible</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-person-plus text-success" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success">
                                <i class="bi bi-arrow-up"></i> +8%
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold"><?php echo e(number_format($stats['recent_users'] ?? 0)); ?></h3>
                    <p class="text-muted mb-2">New Users (7 days)</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%"></div>
                    </div>
                    <small class="text-muted mt-1">Growing steadily</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-shield-check text-info" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info-subtle text-info">
                                <i class="bi bi-shield"></i> Secure
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold"><?php echo e(number_format($stats['admin_users'] ?? 0)); ?></h3>
                    <p class="text-muted mb-2">Admin Users</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 90%"></div>
                    </div>
                    <small class="text-muted mt-1">System secured</small>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-clock-history text-warning" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-warning-subtle text-warning">
                                <i class="bi bi-hourglass-split"></i> Pending
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold"><?php echo e(number_format($stats['pending_users'] ?? 0)); ?></h3>
                    <p class="text-muted mb-2">Pending Approval</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e(($stats['pending_users'] ?? 0) > 0 ? min((($stats['pending_users'] ?? 0) / max(($stats['total_users'] ?? 1), 1)) * 100, 100) : 0); ?>%"></div>
                    </div>
                    <small class="text-muted mt-1">Awaiting review</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle text-success" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success">
                                <i class="bi bi-check"></i> Approved
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold"><?php echo e(number_format($stats['approved_users'] ?? 0)); ?></h3>
                    <p class="text-muted mb-2">Approved Users</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e(($stats['approved_users'] ?? 0) > 0 ? min((($stats['approved_users'] ?? 0) / max(($stats['total_users'] ?? 1), 1)) * 100, 100) : 0); ?>%"></div>
                    </div>
                    <small class="text-muted mt-1">Active accounts</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-x-circle text-danger" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-danger-subtle text-danger">
                                <i class="bi bi-x"></i> Rejected
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold"><?php echo e(number_format($stats['rejected_users'] ?? 0)); ?></h3>
                    <p class="text-muted mb-2">Rejected Users</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo e(($stats['rejected_users'] ?? 0) > 0 ? min((($stats['rejected_users'] ?? 0) / max(($stats['total_users'] ?? 1), 1)) * 100, 100) : 0); ?>%"></div>
                    </div>
                    <small class="text-muted mt-1">Denied access</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-people text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <?php if(Route::has('admin.users.index')): ?>
                                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-gear"></i> Manage
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold"><?php echo e(number_format($stats['total_users'] ?? 0)); ?></h3>
                    <p class="text-muted mb-2">Total Users</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                    </div>
                    <small class="text-muted mt-1">All registered users</small>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-star-fill text-warning" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-warning-subtle text-warning">
                                <i class="bi bi-star"></i> Talents
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold"><?php echo e(number_format($stats['total_talents'] ?? 0)); ?></h3>
                    <p class="text-muted mb-2">Total Talents</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 85%"></div>
                    </div>
                    <small class="text-muted mt-1">Talent database growing</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-plus-circle text-success" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success">
                                <i class="bi bi-arrow-up"></i> Recent
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold"><?php echo e(number_format($stats['recent_talents'] ?? 0)); ?></h3>
                    <p class="text-muted mb-2">New Talents (7 days)</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 70%"></div>
                    </div>
                    <small class="text-muted mt-1">Recent submissions</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-mortarboard text-info" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info-subtle text-info">
                                <i class="bi bi-book"></i> Training
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold"><?php echo e(number_format($stats['talents_needing_training'] ?? 0)); ?></h3>
                    <p class="text-muted mb-2">Need Training</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 55%"></div>
                    </div>
                    <small class="text-muted mt-1">Require development</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-trophy text-danger" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-danger-subtle text-danger">
                                <i class="bi bi-award"></i> Competed
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold"><?php echo e(number_format($stats['talents_with_competitions'] ?? 0)); ?></h3>
                    <p class="text-muted mb-2">Have Competed</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 40%"></div>
                    </div>
                    <small class="text-muted mt-1">Competition experience</small>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-database text-info me-2"></i>
                        Data Management Categories
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <?php if(Route::has('talent-attendance.index')): ?>
                                <a href="<?php echo e(route('talent-attendance.index')); ?>" class="card text-decoration-none border-start border-primary border-3 h-100">
                                    <div class="card-body text-center p-3">
                                        <i class="bi bi-calendar-check text-primary" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2 mb-1">Talent Attendance</h6>
                                        <small class="text-muted">View all talent sessions</small>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <?php if(Route::has('skills-attendance.index')): ?>
                                <a href="<?php echo e(route('skills-attendance.index')); ?>" class="card text-decoration-none border-start border-success border-3 h-100">
                                    <div class="card-body text-center p-3">
                                        <i class="bi bi-tools text-success" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2 mb-1">Skills Attendance</h6>
                                        <small class="text-muted">View all skills sessions</small>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <?php if(Route::has('curriculum-attendance.index')): ?>
                                <a href="<?php echo e(route('curriculum-attendance.index')); ?>" class="card text-decoration-none border-start border-info border-3 h-100">
                                    <div class="card-body text-center p-3">
                                        <i class="bi bi-book text-info" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2 mb-1">Curriculum Data</h6>
                                        <small class="text-muted">View all curriculum records</small>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <?php if(Route::has('parents-information.index')): ?>
                                <a href="<?php echo e(route('parents-information.index')); ?>" class="card text-decoration-none border-start border-warning border-3 h-100">
                                    <div class="card-body text-center p-3">
                                        <i class="bi bi-people text-warning" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2 mb-1">Parents Information</h6>
                                        <small class="text-muted">View all parent records</small>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-lg-3 col-md-6">
                            <?php if(Route::has('talents.index')): ?>
                                <a href="<?php echo e(route('talents.index')); ?>" class="card text-decoration-none border-start border-secondary border-3 h-100">
                                    <div class="card-body text-center p-3">
                                        <i class="bi bi-star text-secondary" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2 mb-1">Talents Information</h6>
                                        <small class="text-muted">View all talent profiles</small>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <?php if(Route::has('skills-information.index')): ?>
                                <a href="<?php echo e(route('skills-information.index')); ?>" class="card text-decoration-none border-start border-danger border-3 h-100">
                                    <div class="card-body text-center p-3">
                                        <i class="bi bi-tools text-danger" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2 mb-1">Skills Information</h6>
                                        <small class="text-muted">View all skills data</small>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <?php if(Route::has('base-leaders.index')): ?>
                                <a href="<?php echo e(route('base-leaders.index')); ?>" class="card text-decoration-none border-start border-primary border-3 h-100">
                                    <div class="card-body text-center p-3">
                                        <i class="bi bi-person-badge text-primary" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2 mb-1">Base Leaders</h6>
                                        <small class="text-muted">View all leader records</small>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-lg-3 col-md-6">
                            <?php if(Route::has('center-leadership.index')): ?>
                                <a href="<?php echo e(route('center-leadership.index')); ?>" class="card text-decoration-none border-start border-success border-3 h-100">
                                    <div class="card-body text-center p-3">
                                        <i class="bi bi-geo-alt text-success" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2 mb-1">Center Leadership</h6>
                                        <small class="text-muted"><?php echo e($stats['total_center_leadership'] ?? 0); ?> records</small>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-clipboard-check text-info me-2"></i>
                            Recent User Submissions for Review
                        </h5>
                        <span class="badge bg-info"><?php echo e(isset($recentSubmissions) ? $recentSubmissions->count() : 0); ?> items</span>
                    </div>
                </div>

                <div class="card-body">
                    <?php if(isset($recentSubmissions) && $recentSubmissions->count() > 0): ?>
                        <div class="row g-3">
                            <?php $__currentLoopData = $recentSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-6">
                                    <div class="card border-start border-<?php echo e($submission['color'] ?? 'secondary'); ?> border-3 h-100">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-start">
                                                <div class="bg-<?php echo e($submission['color'] ?? 'secondary'); ?> bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i class="<?php echo e($submission['icon'] ?? 'bi bi-file-earmark'); ?> text-<?php echo e($submission['color'] ?? 'secondary'); ?>"></i>
                                                </div>

                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <span class="badge bg-<?php echo e($submission['color'] ?? 'secondary'); ?> bg-opacity-10 text-<?php echo e($submission['color'] ?? 'secondary'); ?>">
                                                            <?php echo e($submission['type'] ?? 'Submission'); ?>

                                                        </span>
                                                        <small style="color: #000000 !important;">
                                                            <?php echo e(isset($submission['date']) && $submission['date'] ? $submission['date']->diffForHumans() : ''); ?>

                                                        </small>
                                                    </div>

                                                    <h6 class="mb-1" style="color: #000000 !important;">
                                                        <?php echo e($submission['title'] ?? 'Untitled'); ?>

                                                    </h6>

                                                    <p class="mb-2 small" style="color: #000000 !important;">
                                                        Submitted by: <?php echo e($submission['user'] ?? 'Unknown User'); ?>

                                                    </p>

                                                    <div class="d-flex gap-2">
                                                        <?php if(!empty($submission['route']) && Route::has($submission['route'])): ?>
                                                            <a href="<?php echo e(route($submission['route'], $submission['id'] ?? null)); ?>" class="btn btn-outline-<?php echo e($submission['color'] ?? 'secondary'); ?> btn-sm">
                                                                <i class="bi bi-eye me-1"></i>View Details
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="btn btn-secondary btn-sm disabled">
                                                                <i class="bi bi-exclamation-triangle me-1"></i>Route Missing
                                                            </span>
                                                        <?php endif; ?>

                                                        <span class="badge bg-success">
                                                            <i class="bi bi-check-circle me-1"></i>Submitted
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#allSubmissionsModal">
                                <i class="bi bi-list-ul me-2"></i>View All Submissions
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-clipboard-check text-muted" style="font-size: 3rem;"></i>
                            <h5 class="text-muted mt-3">No Recent Submissions</h5>
                            <p class="text-muted">All user submissions have been reviewed</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-people-fill text-primary me-2"></i>
                            User Management
                        </h5>
                        <div>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="bi bi-person-plus"></i> Add User
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Attendance</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $allUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i class="bi bi-person text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?php echo e($user->center_id ?? 'No Center ID'); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo e($user->role === 'admin' ? 'danger' : 'primary'); ?>">
                                                <?php echo e(ucfirst($user->role)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                                $status = $user->status ?? 'pending';
                                                $statusClass = match($status) {
                                                    'approved' => 'success',
                                                    'rejected' => 'danger',
                                                    default => 'warning',
                                                };
                                            ?>
                                            <span class="badge bg-<?php echo e($statusClass); ?>">
                                                <?php echo e(ucfirst($status)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?php echo e($user->talent_attendance_count ?? 0); ?></span>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?php echo e(optional($user->created_at)->format('M d, Y')); ?></small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?php echo e(route('admin.users.center-profile', $user)); ?>" class="btn btn-outline-success" title="Open Center Profile">
                                                    <i class="bi bi-play-fill"></i>
                                                </a>

                                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal<?php echo e($user->id); ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <?php if(Route::has('admin.users.toggle-status')): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $user)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-outline-warning" title="<?php echo e(($user->status ?? 'pending') === 'approved' ? 'Set as Rejected' : 'Set as Approved'); ?>">
                                                            <i class="bi bi-arrow-repeat"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>

                                                <?php if($user->id !== auth()->id() && Route::has('admin.users.delete')): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.users.delete', $user)); ?>" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <?php echo e($allUsers->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__currentLoopData = $allUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="editUserModal<?php echo e($user->id); ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <?php if(Route::has('admin.users.update')): ?>
                        <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <div class="modal-header border-bottom-0 pb-0">
                                <h5 class="modal-title fw-bold">Edit User: <?php echo e($user->center_id ?? 'No Center ID'); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body pt-3">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Center ID</label>
                                    <input type="text" class="form-control form-control-lg" name="center_id" value="<?php echo e($user->center_id); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control form-control-lg" name="email" value="<?php echo e($user->email); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Role</label>
                                    <select class="form-select form-select-lg" name="role" required>
                                        <option value="user" <?php echo e($user->role === 'user' ? 'selected' : ''); ?>>User</option>
                                        <option value="admin" <?php echo e($user->role === 'admin' ? 'selected' : ''); ?>>Admin</option>
                                    </select>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label fw-semibold">Status</label>
                                    <select class="form-select form-select-lg" name="status" required>
                                        <option value="pending" <?php echo e(($user->status ?? 'pending') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                                        <option value="approved" <?php echo e(($user->status ?? 'pending') === 'approved' ? 'selected' : ''); ?>>Approved</option>
                                        <option value="rejected" <?php echo e(($user->status ?? 'pending') === 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 pt-0">
                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary px-4">Update User</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="modal-header">
                            <h5 class="modal-title">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning mb-0">Update route not available.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-table text-primary me-2"></i>
                        User Management Dashboard
                    </h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm" id="exportBtn">
                            <i class="bi bi-download me-1"></i>Export
                        </button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bi bi-plus-lg me-1"></i>Add User
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" id="tableSearch" placeholder="Search users...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="roleFilter">
                                <option value="">All Roles</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="moderator">Moderator</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control form-control-sm" id="dateFilter">
                        </div>
                        <div class="col-md-3">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="advancedFilters">
                                    <i class="bi bi-funnel"></i> Advanced
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">
                            Showing <strong>1-3</strong> of <strong>47</strong> users
                        </div>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">...</a></li>
                                <li class="page-item"><a class="page-link" href="#">16</a></li>
                                <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mb-4">
        <div class="col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-plus text-primary me-2"></i>
                        Recent Users
                    </h5>
                </div>
                <div class="card-body">
                    <?php if(isset($recentUsers) && $recentUsers->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item border-0 px-0 py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bi bi-person text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0"><?php echo e($user->center_id ?? 'No Center ID'); ?></h6>
                                            <small class="text-muted"><?php echo e($user->email); ?></small>
                                        </div>
                                        <span class="badge bg-<?php echo e($user->role === 'admin' ? 'danger' : 'primary'); ?>">
                                            <?php echo e(ucfirst($user->role)); ?>

                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-3">
                            <i class="bi bi-person-x text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2 mb-0">No recent users</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="allSubmissionsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-clipboard-data me-2"></i>
                    All User Submissions
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <?php if(Route::has('parents-information.index')): ?>
                            <a href="<?php echo e(route('parents-information.index')); ?>" class="card text-decoration-none h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2">Parents Information</h6>
                                    <small class="text-muted">Review parent submissions</small>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4">
                        <?php if(Route::has('base-leaders.index')): ?>
                            <a href="<?php echo e(route('base-leaders.index')); ?>" class="card text-decoration-none h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-badge text-success" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2">Base Leaders</h6>
                                    <small class="text-muted">Review leader applications</small>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4">
                       <?php if(Route::has('submissions.special-program.index')): ?>
    <a href="<?php echo e(route('submissions.special-program.index')); ?>" class="card text-decoration-none h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-star text-warning" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2">Special Programs</h6>
                                    <small class="text-muted">Review program submissions</small>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4">
                        <?php if(Route::has('admin.masomo-ya-mtaala.index')): ?>
                            <a href="<?php echo e(route('admin.masomo-ya-mtaala.index')); ?>" class="card text-decoration-none h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-book text-info" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2">Curriculum Lessons</h6>
                                    <small class="text-muted">Review lesson reports</small>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4">
                        <?php if(Route::has('curriculum-attendance.index')): ?>
                            <a href="<?php echo e(route('curriculum-attendance.index')); ?>" class="card text-decoration-none h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-calendar-check text-secondary" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2">Curriculum Attendance</h6>
                                    <small class="text-muted">Review attendance records</small>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4">
                        <?php if(Route::has('skills-attendance.index')): ?>
                            <a href="<?php echo e(route('skills-attendance.index')); ?>" class="card text-decoration-none h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-tools text-danger" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2">Skills Attendance</h6>
                                    <small class="text-muted">Review skills sessions</small>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4">
                        <?php if(Route::has('skills-information.index')): ?>
                            <a href="<?php echo e(route('skills-information.index')); ?>" class="card text-decoration-none h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-tools text-info" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2">Skills Information</h6>
                                    <small class="text-muted">Review skills data</small>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function approveSubmission(type, id) {
    if (confirm('Are you sure you want to approve this ' + type + ' submission?')) {
        alert('Submission approved!');
    }
}

$(document).ready(function () {
    let searchTimeout;

    $('#adminSearchBtn').click(function () {
        performAdminSearch();
    });

    $('#adminSearchInput').keypress(function (e) {
        if (e.which === 13) {
            performAdminSearch();
        }
    });

    $('#adminSearchInput').on('input', function () {
        clearTimeout(searchTimeout);
        const query = $(this).val().trim();

        if (query.length === 0) {
            $('#searchResults').hide();
            return;
        }

        if (query.length >= 2) {
            searchTimeout = setTimeout(function () {
                performAdminSearch();
            }, 500);
        }
    });

    function performAdminSearch() {
        const query = $('#adminSearchInput').val().trim();
        const searchUrl = $('#adminSearchBtn').data('search-url');

        if (!searchUrl || query.length === 0) {
            $('#searchResults').hide();
            return;
        }

        $('#searchResults').show();
        $('#searchResultsContent').html('<div class="text-center py-4"><i class="bi bi-hourglass-split"></i> Searching...</div>');
        $('#resultsCount').text('...');

        $.ajax({
            url: searchUrl,
            method: 'POST',
            data: {
                q: query,
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function (response) {
                if (response.success) {
                    displayAdminSearchResults(response.results, response.count);
                } else {
                    $('#searchResultsContent').html('<div class="alert alert-warning">Search failed. Please try again.</div>');
                }
            },
            error: function () {
                $('#searchResultsContent').html('<div class="alert alert-danger">An error occurred while searching. Please try again.</div>');
            }
        });
    }

    function displayAdminSearchResults(results, count) {
        $('#resultsCount').text(count);

        if (count === 0) {
            $('#searchResultsContent').html('<div class="text-center py-4 text-muted"><i class="bi bi-search"></i><br>No results found for your search.</div>');
            return;
        }

        let html = '<div class="row g-3">';

        results.forEach(function (result) {
            const statusColor = result.status === 'approved' ? 'success' : (result.status === 'rejected' ? 'danger' : 'warning');

            html += `
                <div class="col-lg-6">
                    <div class="card border-start border-${statusColor} border-3 h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-${statusColor} bg-opacity-10 text-${statusColor}">${result.type ?? ''}</span>
                                <small class="text-muted">${result.date ?? ''}</small>
                            </div>
                            <h6 class="mb-1">${result.title ?? ''}</h6>
                            <p class="text-muted mb-2 small">${result.description ?? ''}</p>
                            <div class="small text-dark mb-1">
                                <i class="bi bi-person me-1 text-${statusColor}"></i>Uploaded by: ${result.submitted_by ?? result.user ?? ''}
                            </div>
                            <div class="small text-dark mb-3">
                                <i class="bi bi-geo-alt me-1 text-${statusColor}"></i>Open in: ${result.location ?? 'Record location'}
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="${result.url ?? '#'}" class="btn btn-outline-${statusColor} btn-sm">
                                    <i class="bi bi-eye me-1"></i>Open Record
                                </a>
                                <span class="badge bg-${statusColor}">${result.status ?? ''}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        html += '</div>';
        $('#searchResultsContent').html(html);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/dashboard/admin.blade.php ENDPATH**/ ?>