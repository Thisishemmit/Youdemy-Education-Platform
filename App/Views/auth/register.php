<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="assets/js/tailwind.js"></script>
    <!-- inter font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 font-[Inter]">
    <div class="bg-white p-8 rounded shadow-md max-w-md w-full">
        <h1 class="text-2xl font-bold mb-4 text-center">Create Account</h1>
        <?php if($this->hasFlash('register')): $flash = $this->getFlash('register'); ?>
            <div class="bg-red-400 text-white p-2 mb-4 text-center">
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>
        <form action="/register" method="post" class="flex flex-col space-y-4">
            <input
                type="text"
                name="name"
                placeholder="Username"
                class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#1fda92]"
            />
            <input
                type="email"
                name="email"
                placeholder="Email"
                class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#1fda92]"
            />
            <input
                type="password"
                name="password"
                placeholder="Password"
                class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#1fda92]"
            />
            <select
                name="role"
                class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#1fda92]"
            >
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select>
            <button
                type="submit"
                class="bg-[#1fda92] text-[#252525] font-bold p-2 rounded">
                Sign Up
            </button>
        </form>
        <p class="text-center mt-4">
            Already have an account?
            <a href="/login" class="text-[#1fda92] font-bold">Login</a>
        </p>
    </div>
</body>
</html>
