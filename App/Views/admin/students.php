<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - Youdemy</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full font-[Inter] bg-gray-50">
    <div class="flex">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 ml-64 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#252525]">Manage Students</h1>
                <p class="text-gray-600 mt-1">View and manage student accounts</p>
            </div>

            <div class="relative z-10">
                <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                    <h2 class="text-xl font-bold text-[#252525] mb-6">Student List</h2>

                    <?php if (empty($students)): ?>
                        <div class="text-center py-8">
                            <i data-lucide="user-x" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                            <p class="text-gray-500">No students found</p>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left bg-gray-50">
                                        <th class="p-4 font-semibold text-[#252525]">Username</th>
                                        <th class="p-4 font-semibold text-[#252525]">Email</th>
                                        <th class="p-4 font-semibold text-[#252525]">Status</th>
                                        <th class="p-4 font-semibold text-[#252525]">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    <?php foreach ($students as $student): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="p-4">
                                                <div class="font-medium text-[#252525]"><?= htmlspecialchars($student->getUserName()) ?></div>
                                            </td>
                                            <td class="p-4 text-gray-600"><?= htmlspecialchars($student->getEmail()) ?></td>
                                            <?php
                                                $statusColors = [
                                                    'active' => 'bg-green-100 text-green-800',
                                                    'suspended' => 'bg-red-100 text-red-800'
                                                ];
                                                $statusColor = $statusColors[$student->getStatus()] ?? 'bg-gray-100 text-gray-800';
                                            ?>
                                            <td class="p-4">
                                                <span class="px-3 py-1 rounded-full text-xs font-medium <?php echo $statusColor; ?>">
                                                    <?php echo ucfirst($student->getStatus()); ?>
                                                </span>
                                            </td>
                                            <td class="p-4">
                                                <div class="flex items-center space-x-4">
                                                    <?php if ($student->canBeSuspended()): ?>
                                                        <form action="/admin/students/suspend" method="POST" class="inline">
                                                            <input type="hidden" name="student_id" value="<?= $student->getId() ?>">
                                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                                <i data-lucide="user-x" class="w-5 h-5"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($student->canBeActivated()): ?>
                                                        <form action="/admin/students/activate" method="POST" class="inline">
                                                            <input type="hidden" name="student_id" value="<?= $student->getId() ?>">
                                                            <button type="submit" class="text-green-600 hover:text-green-800">
                                                                <i data-lucide="user-check" class="w-5 h-5"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>