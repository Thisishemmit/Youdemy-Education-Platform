<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tags - Admin Dashboard</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full bg-gray-50">
    <div class="flex min-h-screen font-[Inter]">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 p-8 ml-64">
            <div class="max-w-4xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-[#252525]">Course Tags</h1>
                    <button onclick="document.getElementById('createTagModal').classList.remove('hidden')" 
                            class="bg-[#1fda92] text-[#252525] px-4 py-2 rounded-lg font-semibold hover:bg-opacity-90">
                        Add Tag
                    </button>
                </div>

                <?php if ($this->hasFlash('/admin/tags')): ?>
                    <?php 
                        $flash = $this->getFlash('/admin/tags');
                        $bgColor = $flash['type'] === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
                    ?>
                    <div class="<?php echo $bgColor; ?> border px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="block sm:inline"><?php echo $flash['message']; ?></span>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <?php if (!empty($tags)): ?>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($tags as $tag): ?>
                                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-gray-100 rounded-full">
                                        <span class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($tag->getName()); ?></span>
                                        <form action="/admin/tags/delete" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this tag?');">
                                            <input type="hidden" name="tag_id" value="<?php echo $tag->getId(); ?>">
                                            <button type="submit" class="text-gray-500 hover:text-red-600">
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                    <i data-lucide="hash" class="w-8 h-8 text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No Tags</h3>
                                <p class="text-gray-500">Get started by creating a new tag</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Create Tag Modal -->
    <div id="createTagModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-[#252525]">Create Tag</h3>
                <button onclick="document.getElementById('createTagModal').classList.add('hidden')" class="text-gray-600 hover:text-gray-800">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form action="/admin/tags/create" method="POST">
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" id="name" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1fda92]">
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" 
                            onclick="document.getElementById('createTagModal').classList.add('hidden')"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button type="submit" class="bg-[#1fda92] text-[#252525] px-4 py-2 rounded-lg font-semibold hover:bg-opacity-90">
                        Create Tag
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
