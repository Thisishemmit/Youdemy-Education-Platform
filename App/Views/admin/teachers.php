<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers - Admin Dashboard</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full bg-gray-50">
    <div class="flex min-h-screen font-[Inter]">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 p-8 ml-64">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-[#252525]">Teachers</h1>
                <?php if ($pendingCount > 0): ?>
                    <a href="/admin/teachers/pending" class="flex items-center gap-2 px-4 py-2 bg-[#1fda92] text-[#252525] rounded-lg hover:bg-opacity-90">
                        <span class="font-medium">Pending Applications</span>
                        <span class="flex items-center justify-center w-6 h-6 bg-white rounded-full text-sm font-semibold"><?php echo $pendingCount; ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($this->hasFlash('/admin/teachers')): ?>
                <?php 
                    $flash = $this->getFlash('/admin/teachers');
                    $bgColor = $flash['type'] === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
                ?>
                <div class="<?php echo $bgColor; ?> border px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline"><?php echo $flash['message']; ?></span>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($teachers as $teacher): ?>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-[#1fda92] flex items-center justify-center text-[#252525] font-bold text-xl">
                                <?php echo strtoupper(substr($teacher->getUsername(), 0, 1)); ?>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg text-[#252525]"><?php echo $teacher->getUsername(); ?></h3>
                                <p class="text-gray-500"><?php echo $teacher->getEmail(); ?></p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    <p><strong>Joined:</strong> <?php echo date('M d, Y', strtotime($teacher->getCreatedAt())); ?></p>
                                    <p><strong>Courses:</strong> <?php echo count($teacher->getCourses() ?? []); ?></p>
                                </div>

                                <?php
                                    $statusColors = [
                                        'active' => 'bg-green-100 text-green-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'suspended' => 'bg-red-100 text-red-800',
                                        'rejected' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $statusColor = $statusColors[$teacher->getStatus()] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-3 py-1 rounded-full text-xs font-medium <?php echo $statusColor; ?>">
                                    <?php echo ucfirst($teacher->getStatus()); ?>
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                <?php if ($teacher->canBeSuspended()): ?>
                                    <form action="/admin/teachers/suspend" method="POST" class="flex-1">
                                        <input type="hidden" name="teacher_id" value="<?php echo $teacher->getId(); ?>">
                                        <button type="submit" class="w-full bg-red-100 text-red-600 py-2 rounded-lg font-semibold hover:bg-red-200">
                                            Suspend
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <?php if ($teacher->canBeActivated()): ?>
                                    <form action="/admin/teachers/activate" method="POST" class="flex-1">
                                        <input type="hidden" name="teacher_id" value="<?php echo $teacher->getId(); ?>">
                                        <button type="submit" class="w-full bg-[#1fda92] text-[#252525] py-2 rounded-lg font-semibold hover:bg-opacity-90">
                                            Activate
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($teachers)): ?>
                    <div class="col-span-full text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <i data-lucide="users" class="w-8 h-8 text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Teachers Found</h3>
                        <p class="text-gray-500">There are no teachers registered in the system</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
