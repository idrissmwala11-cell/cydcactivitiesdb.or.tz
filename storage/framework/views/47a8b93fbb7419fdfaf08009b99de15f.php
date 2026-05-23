

<?php $__env->startSection('title', 'My Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .user-search-credit {
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
        animation: userSearchCreditPulse 4.6s ease-in-out infinite;
    }

    .user-search-credit i {
        color: #6366f1;
        font-size: 0.82rem;
    }

    @keyframes userSearchCreditPulse {
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
    <!-- Search Section -->
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
                                       id="userSearchInput"
                                       placeholder="Search your submissions (topics, activities, names, etc.)..."
                                       autocomplete="off">
                                <button class="btn btn-primary" type="button" id="userSearchBtn" data-search-url="<?php echo e(route('user.search.ajax')); ?>">
                                    <i class="bi bi-search me-1"></i>Search
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="user-search-credit">
                                <i class="bi bi-stars"></i>
                                Developer (idriss mwala)
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Center Data Summary -->
    <div class="row mb-4">
        <div class="col-12">
            <div
                class="card dashboard-card border-0 shadow-sm"
                onmouseenter="document.getElementById('centerSummaryCollapse').classList.remove('d-none'); document.getElementById('centerSummaryToggle').setAttribute('aria-expanded','true'); document.getElementById('centerSummaryChevron').classList.remove('bi-chevron-right'); document.getElementById('centerSummaryChevron').classList.add('bi-chevron-down');"
                onmouseleave="document.getElementById('centerSummaryCollapse').classList.add('d-none'); document.getElementById('centerSummaryToggle').setAttribute('aria-expanded','false'); document.getElementById('centerSummaryChevron').classList.remove('bi-chevron-down'); document.getElementById('centerSummaryChevron').classList.add('bi-chevron-right');"
            >
                <div class="card-header bg-transparent border-0 pb-0">
                    <button
                        id="centerSummaryToggle"
                        class="btn w-100 text-start border-0 p-0 shadow-none d-flex justify-content-between align-items-center flex-wrap gap-2"
                        type="button"
                        aria-expanded="false"
                        aria-controls="centerSummaryCollapse"
                        style="cursor: default;"
                    >
                        <div>
                            <h5 class="card-title mb-1 text-dark">
                                <i class="bi bi-table text-primary me-2"></i>
                                Center Data Summary
                            </h5>
                            <p class="text-muted mb-0">
                                Counts below include all users using center ID
                                <span class="fw-semibold text-dark"><?php echo e($centerId ?: 'Not Set'); ?></span>.
                            </p>
                            <small class="text-primary d-inline-flex align-items-center gap-1 mt-1">
                                <i class="bi bi-hand-index-thumb"></i>
                                Point your cursor here and your data summary will drop down below for viewing.
                            </small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary-subtle text-primary fs-6">
                                Total: <?php echo e(number_format($totalCenterDataRecords ?? 0)); ?>

                            </span>
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-chevron-right" id="centerSummaryChevron"></i>
                            </span>
                        </div>
                    </button>
                </div>
                <div id="centerSummaryCollapse" class="d-none">
                    <div class="card-body">
                        <?php if(($centerDataSummary ?? collect())->count() > 0): ?>
                            <div class="row g-2">
                                <?php $__currentLoopData = $centerDataSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $summary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body p-2">
                                                <div class="d-flex align-items-start justify-content-between gap-2 mb-1">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="rounded-circle bg-<?php echo e($summary['color']); ?> bg-opacity-10 d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px;">
                                                            <i class="bi <?php echo e($summary['icon']); ?> text-<?php echo e($summary['color']); ?>" style="font-size: 0.75rem;"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold mb-0" style="font-size: 0.76rem; line-height: 1.2;"><?php echo e($summary['title']); ?></div>
                                                            <small class="text-muted" style="font-size: 0.62rem; line-height: 1;"><?php echo e(str_replace('_', ' ', strtoupper($summary['key']))); ?></small>
                                                        </div>
                                                    </div>
                                                    <span class="badge bg-dark-subtle text-dark px-2 py-1" style="font-size: 0.66rem;">
                                                        <?php echo e(number_format($summary['count'])); ?>

                                                    </span>
                                                </div>

                                                <?php if($summary['count'] > 0): ?>
                                                    <span class="badge bg-success-subtle text-success" style="font-size: 0.62rem;">Has data</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning-subtle text-warning" style="font-size: 0.62rem;">No data yet</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <span class="fw-semibold text-dark" style="font-size: 0.76rem;">Total Records</span>
                                <span class="badge bg-primary px-2 py-1" style="font-size: 0.68rem;">
                                    <?php echo e(number_format($totalCenterDataRecords ?? 0)); ?> Combined Center Total
                                </span>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-database-x text-muted" style="font-size: 2.5rem;"></i>
                                <p class="text-muted mt-2 mb-0">No center data summary available yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <div class="row mb-4" id="userSearchResults" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-search me-2"></i>
                        Your Search Results
                        <span class="badge bg-primary ms-2" id="userResultsCount">0</span>
                    </h5>
                </div>
                <div class="card-body" id="userSearchResultsContent">
                    <!-- Results will be loaded here via Ajax -->
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4 align-items-stretch">
        <!-- User Statistics -->
        <div class="col-xl-4 col-lg-5">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="h4 mb-1"><?php echo e(number_format($stats['available_skills'])); ?></h3>
                            <p class="text-muted mb-0">Skills to Learn</p>
                        </div>
                        <div class="col-auto">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-play-circle text-info"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="<?php echo e(route('skills-to-learn.videos')); ?>" class="btn btn-info btn-sm text-white">
                            <i class="bi bi-camera-video me-1"></i>Explore Videos
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Skills to Learn Videos -->
        <div class="col-xl-8 col-lg-7">
            <div class="card dashboard-card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h5 class="card-title mb-1">
                                <i class="bi bi-play-btn-fill text-info me-2"></i>
                                Skills to Learn
                            </h5>
                            <p class="text-muted mb-0">Watch recent learning videos uploaded by admin</p>
                        </div>

                        <a href="<?php echo e(route('skills-to-learn.videos')); ?>" class="btn btn-outline-info">
                            <i class="bi bi-arrow-right-circle me-1"></i>Watch All Videos
                        </a>
                    </div>
                </div>
                <div class="card-body p-3">
                    <?php if(isset($skillVideos) && $skillVideos->count() > 0): ?>
                        <div class="row g-3">
                            <?php $__currentLoopData = $skillVideos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">

                                        <div class="ratio ratio-16x9 bg-dark">
                                            <video controls class="w-100 h-100" style="object-fit: cover;">
                                                <source src="<?php echo e(asset('storage/' . $video->video_path)); ?>" type="video/mp4">
                                            </video>
                                        </div>

                                        <div class="card-body p-2">
                                            <h6 class="fw-semibold mb-1 small">
                                                <?php echo e($video->title ?? 'Untitled Video'); ?>

                                            </h6>

                                            <p class="text-muted small mb-2">
                                                <?php echo e(\Illuminate\Support\Str::limit($video->description ?? 'No description available.', 50)); ?>

                                            </p>

                                            <small class="text-muted">
                                                <?php echo e(optional($video->created_at)->format('d M Y')); ?>

                                            </small>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-camera-video-off text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2 mb-0">No videos available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Entry Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil-square text-primary me-2"></i>
                        Data Entry Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="<?php echo e(route('talent-attendance.create')); ?>" class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-calendar-plus d-block mb-1"></i>
                                <small>Talent Attendance</small>
                            </a>
                        </div>

                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="<?php echo e(route('skills-attendance.create')); ?>" class="btn btn-outline-success w-100 py-3">
                                <i class="bi bi-calendar2-plus d-block mb-1"></i>
                                <small>Skills Attendance</small>
                            </a>
                        </div>

                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="<?php echo e(route('curriculum-attendance.create')); ?>" class="btn btn-outline-info w-100 py-3">
                                <i class="bi bi-journal-plus d-block mb-1"></i>
                                <small>Curriculum Data</small>
                            </a>
                        </div>

                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="<?php echo e(route('talents.create')); ?>" class="btn btn-outline-warning w-100 py-3">
                                <i class="bi bi-star-fill d-block mb-1"></i>
                                <small>Talent Info</small>
                            </a>
                        </div>

                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="<?php echo e(route('skills-information.create')); ?>" class="btn btn-outline-secondary w-100 py-3">
                                <i class="bi bi-tools d-block mb-1"></i>
                                <small>Skills Info</small>
                            </a>
                        </div>

                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="<?php echo e(route('parents-information.create')); ?>" class="btn btn-outline-dark w-100 py-3">
                                <i class="bi bi-people-fill d-block mb-1"></i>
                                <small>Parents Info</small>
                            </a>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="<?php echo e(route('submissions.masomo-ya-mtaala.create')); ?>" class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-book d-block mb-1"></i>
                                <small>Curriculum Studies</small>
                            </a>
                        </div>

                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="<?php echo e(route('base-leaders.create')); ?>" class="btn btn-outline-info w-100 py-3">
                                <i class="bi bi-person-badge d-block mb-1"></i>
                                <small>Base Leader</small>
                            </a>
                        </div>

                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-outline-warning w-100 py-3">
                                <i class="bi bi-person-gear d-block mb-1"></i>
                                <small>My Profile</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Recent Activities -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history text-info me-2"></i>
                        My Recent Activities
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($myRecentAttendance->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Activity</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $myRecentAttendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($attendance->date); ?></td>
                                            <td><?php echo e($attendance->activity ?? 'Talent Session'); ?></td>
                                            <td><span class="badge bg-success">Present</span></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No recent activities found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function() {
    let searchTimeout;
    const searchInput = $('#userSearchInput');
    const searchBtn = $('#userSearchBtn');
    const searchResults = $('#userSearchResults');
    const searchResultsContent = $('#userSearchResultsContent');
    const resultsCount = $('#userResultsCount');
    const searchUrl = searchBtn.data('search-url');

    searchBtn.on('click', function() {
        performSearch();
    });

    searchInput.on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            performSearch();
        }
    });

    searchInput.on('input', function() {
        clearTimeout(searchTimeout);
        const query = $(this).val().trim();

        if (query.length === 0) {
            searchResults.hide();
            return;
        }

        searchTimeout = setTimeout(function() {
            performSearch();
        }, 500);
    });

    function performSearch() {
        const query = searchInput.val().trim();

        if (query.length === 0) {
            searchResults.hide();
            return;
        }

        searchBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Searching...');

        $.ajax({
            url: searchUrl,
            method: 'POST',
            data: {
                q: query,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                displayResults(response);
            },
            error: function(xhr, status, error) {
                console.error('Search error:', error);
                searchResultsContent.html('<div class="alert alert-danger">An error occurred while searching. Please try again.</div>');
                searchResults.show();
            },
            complete: function() {
                searchBtn.prop('disabled', false).html('<i class="bi bi-search me-1"></i>Search');
            }
        });
    }

    function displayResults(response) {
        if (response.results && response.results.length > 0) {
            let html = '<div class="row g-3">';
            response.results.forEach(function(result) {
                html += `
                    <div class="col-lg-6">
                        <div class="card border-start border-primary border-3 h-100 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <span class="badge bg-primary-subtle text-primary">${result.type ?? ''}</span>
                                    <small class="text-muted">${result.date ?? ''}</small>
                                </div>
                                <h6 class="mb-1">${result.title ?? ''}</h6>
                                <p class="text-muted small mb-2">${result.description ?? ''}</p>
                                <div class="small text-dark mb-1">
                                    <i class="bi bi-geo-alt me-1 text-primary"></i>${result.location ?? 'Record location'}
                                </div>
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                                    <span class="badge bg-success-subtle text-success">Your record</span>
                                    <a href="${result.url ?? '#'}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-box-arrow-up-right me-1"></i>Open Record
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            searchResultsContent.html(html);
            resultsCount.text(response.results.length);
        } else {
            searchResultsContent.html('<div class="text-center py-4"><i class="bi bi-search text-muted" style="font-size: 3rem;"></i><p class="text-muted mt-2">No results found for your search.</p></div>');
            resultsCount.text('0');
        }
        searchResults.show();
    }

});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/dashboard/user.blade.php ENDPATH**/ ?>