<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Content - Teacher Dashboard</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full bg-gray-50">
    <div class="flex min-h-screen font-[Inter]">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 p-8 ml-64">
            <div class="max-w-4xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-[#252525]">Create Course Content</h1>
                    <a href="/teacher/courses" class="text-gray-600 hover:text-gray-800">
                        <i data-lucide="arrow-left" class="w-6 h-6"></i>
                    </a>
                </div>

                <?php if ($this->hasFlash('/teacher/courses/create')): ?>
                    <?php
                        $flash = $this->getFlash('/teacher/courses/create');
                        $bgColor = $flash['type'] === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
                    ?>
                    <div class="<?php echo $bgColor; ?> border px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="block sm:inline"><?php echo $flash['message']; ?></span>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-lg shadow">
                    <form action="/teacher/courses/create" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Content Type</label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="content_type" value="video" class="form-radio text-[#1fda92]" >
                                    <span class="ml-2">Video</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="content_type" value="document" class="form-radio text-[#1fda92]" >
                                    <span class="ml-2">Document</span>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="course_title" class="block text-sm font-medium text-gray-700 mb-1">Course Title</label>
                                <input type="text" id="course_title" name="course_title"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1fda92]">
                            </div>
                            <div>
                                <label for="course_description" class="block text-sm font-medium text-gray-700 mb-1">Course Description</label>
                                <textarea id="course_description" name="course_description" rows="4"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1fda92]"></textarea>
                            </div>
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Course Category</label>
                            <select id="category" name="category_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1fda92]">
                                <option value="">Select a category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category->getId(); ?>">
                                        <?php echo htmlspecialchars($category->getName()); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Course Tags</label>
                            <div class="relative">
                                <input type="text" id="tagInput"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1fda92]"
                                       placeholder="Type to search tags...">
                                <div id="tagSuggestions" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                    <!-- Suggestions will be populated here -->
                                </div>
                                <div id="selectedTags" class="flex flex-wrap gap-2 mt-2">
                                    <!-- Selected tags will be shown here -->
                                </div>
                                <input type="hidden" name="tags" id="tagsInput">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Course Thumbnail</label>
                            <div class="flex flex-col justify-center">
                                <label class="block mb-4">
                                    <span class="sr-only">Choose thumbnail</span>
                                    <input type="file" name="thumbnail" accept="image/jpeg,image/png"
                                           class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-lg file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-[#1fda92] file:text-[#252525]
                                                  hover:file:bg-opacity-90">
                                </label>
                                <div class="text-sm text-gray-500 space-y-1">
                                    <p>• Maximum file size: 1MB</p>
                                    <p>• Supported formats: JPG, PNG</p>
                                    <p>• Recommended size: 16:9 aspect ratio</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="content_title" class="block text-sm font-medium text-gray-700 mb-1">Content Title</label>
                                <input type="text" id="content_title" name="content_title"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1fda92]">
                            </div>
                            <div>
                                <label for="content_description" class="block text-sm font-medium text-gray-700 mb-1">Content Description</label>
                                <textarea id="content_description" name="content_description" rows="4"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1fda92]"></textarea>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Content File</label>
                            <div class="flex flex-col justify-center">
                                <label class="block mb-4">
                                    <span class="sr-only">Choose content file</span>
                                    <input type="file" name="content_file" id="content_file"
                                           class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-lg file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-[#1fda92] file:text-[#252525]
                                                  hover:file:bg-opacity-90">
                                </label>
                                <div class="text-sm text-gray-500">
                                    <p>• Videos: MP4 format</p>
                                    <p>• Documents: PDF, DOCX formats</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="/teacher/courses"
                               class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="bg-[#1fda92] text-[#252525] px-4 py-2 rounded-lg font-semibold hover:bg-opacity-90">
                                Create Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        document.querySelectorAll('input[name="content_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const contentFile = document.getElementById('content_file');
                if (this.value === 'video') {
                    contentFile.setAttribute('accept', 'video/mp4');
                } else if (this.value === 'document') {
                    contentFile.setAttribute('accept', 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                }
            });
        });

        const tags = <?php echo json_encode(array_map(function($tag) {
            return ['id' => $tag->getId(), 'name' => $tag->getName()];
        }, $tags)); ?>;

        const tagInput = document.getElementById('tagInput');
        const tagSuggestions = document.getElementById('tagSuggestions');
        const selectedTags = document.getElementById('selectedTags');
        const tagsInput = document.getElementById('tagsInput');
        let selectedTagIds = [];

        function showSuggestions(searchText) {
            const matchingTags = tags.filter(tag =>
                tag.name.toLowerCase().includes(searchText.toLowerCase()) &&
                !selectedTagIds.includes(tag.id)
            );

            if (matchingTags.length > 0 && searchText) {
                tagSuggestions.innerHTML = matchingTags.map(tag => `
                    <div class="px-3 py-2 hover:bg-gray-100 cursor-pointer"
                         onclick="selectTag(${tag.id}, '${tag.name}')">
                        ${tag.name}
                    </div>
                `).join('');
                tagSuggestions.classList.remove('hidden');
            } else {
                tagSuggestions.classList.add('hidden');
            }
        }

        function selectTag(id, name) {
            if (!selectedTagIds.includes(id)) {
                selectedTagIds.push(id);
                const tagElement = document.createElement('div');
                tagElement.className = 'inline-flex items-center gap-1 px-3 py-1 bg-gray-100 rounded-full';
                tagElement.innerHTML = `
                    <span class="text-sm font-medium text-gray-800">${name}</span>
                    <button type="button" onclick="removeTag(${id}, this.parentElement)"
                            class="text-gray-500 hover:text-red-600">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                `;
                selectedTags.appendChild(tagElement);
                lucide.createIcons();
                tagsInput.value = selectedTagIds.join(',');
            }
            tagInput.value = '';
            tagSuggestions.classList.add('hidden');
        }

        function removeTag(id, element) {
            selectedTagIds = selectedTagIds.filter(tagId => tagId !== id);
            element.remove();
            tagsInput.value = selectedTagIds.join(',');
        }

        document.addEventListener('click', function(e) {
            if (!tagInput.contains(e.target) && !tagSuggestions.contains(e.target)) {
                tagSuggestions.classList.add('hidden');
            }
        });

        tagInput.addEventListener('input', () => showSuggestions(tagInput.value));
        tagInput.addEventListener('focus', () => showSuggestions(tagInput.value));
    </script>
</body>
</html>
