<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Teachers - Admin Dashboard</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full bg-gray-50">
    <div class="flex min-h-screen font-[Inter]">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 p-8 ml-64">
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-[#252525]">Pending Teachers</h1>
                    <a href="/admin/teachers" class="text-[#252525] hover:text-[#1fda92] font-medium flex items-center gap-2">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                        Back to Teachers
                    </a>
                </div>

                <?php if ($this->hasFlash('/admin/teachers/pending')): ?>
                    <?php 
                        $flash = $this->getFlash('/admin/teachers/pending');
                        $bgColor = $flash['type'] === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
                    ?>
                    <div class="<?php echo $bgColor; ?> border px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="block sm:inline"><?php echo $flash['message']; ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($teachers as $teacher): ?>
                    <?php if ($teacher->getStatus() === 'pending'): ?>
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
                                <div class="text-sm text-gray-600">
                                    <p><strong>Joined:</strong> <?php echo date('M d, Y', strtotime($teacher->getCreatedAt())); ?></p>
                                </div>
                                
                                <div class="flex gap-2">
                                    <form action="/admin/teachers/verify" method="POST" class="flex-1">
                                        <input type="hidden" name="teacher_id" value="<?php echo $teacher->getId(); ?>">
                                        <button type="submit" class="w-full bg-[#1fda92] text-[#252525] py-2 rounded-lg font-semibold hover:bg-opacity-90">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="/admin/teachers/reject" method="POST" class="flex-1">
                                        <input type="hidden" name="teacher_id" value="<?php echo $teacher->getId(); ?>">
                                        <button type="submit" class="w-full bg-red-100 text-red-600 py-2 rounded-lg font-semibold hover:bg-red-200">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if (!$hasPendingTeachers): ?>
                    <div class="col-span-full text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <i data-lucide="check" class="w-8 h-8 text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Approvals</h3>
                        <p class="text-gray-500">All teacher applications have been reviewed</p>
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
