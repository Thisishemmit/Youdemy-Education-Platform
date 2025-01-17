<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Admin Dashboard</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full bg-gray-50">
    <div class="flex min-h-screen font-[Inter]">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 p-8 ml-64">
            <div class="max-w-4xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-[#252525]">Course Categories</h1>
                    <button onclick="document.getElementById('createCategoryModal').classList.remove('hidden')" 
                            class="bg-[#1fda92] text-[#252525] px-4 py-2 rounded-lg font-semibold hover:bg-opacity-90">
                        Add Category
                    </button>
                </div>

                <?php if ($this->hasFlash('/admin/categories')): ?>
                    <?php 
                        $flash = $this->getFlash('/admin/categories');
                        $bgColor = $flash['type'] === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
                    ?>
                    <div class="<?php echo $bgColor; ?> border px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="block sm:inline"><?php echo $flash['message']; ?></span>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <?php if (!empty($categories)): ?>
                            <div class="divide-y">
                                <?php foreach ($categories as $category): ?>
                                    <div class="py-4 flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-[#252525]"><?php echo htmlspecialchars($category->getName()); ?></h3>
                                            <?php if ($category->getDescription()): ?>
                                                <p class="text-gray-500 text-sm mt-1"><?php echo htmlspecialchars($category->getDescription()); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <form action="/admin/categories/delete" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            <input type="hidden" name="category_id" value="<?php echo $category->getId(); ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                    <i data-lucide="folder" class="w-8 h-8 text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No Categories</h3>
                                <p class="text-gray-500">Get started by creating a new category</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Create Category Modal -->
    <div id="createCategoryModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-[#252525]">Create Category</h3>
                <button onclick="document.getElementById('createCategoryModal').classList.add('hidden')" class="text-gray-600 hover:text-gray-800">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form action="/admin/categories/create" method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" id="name" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1fda92]">
                </div>
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1fda92]"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" 
                            onclick="document.getElementById('createCategoryModal').classList.add('hidden')"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button type="submit" class="bg-[#1fda92] text-[#252525] px-4 py-2 rounded-lg font-semibold hover:bg-opacity-90">
                        Create Category
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
