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
        <h1 class="text-2xl font-bold mb-4 text-center">Login to your account</h1>
        <?php if ($this->hasFlash('login')): $flash = $this->getFlash('login'); ?>
            <div class="bg-red-400 text-white p-2 mb-4 text-center">
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>
        <form action="/login" method="post" class="flex flex-col space-y-4">
            <input
                type="email"
                name="email"
                placeholder="Email"
                class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#1fda92]" />
            <input
                type="password"
                name="password"
                placeholder="Password"
                class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#1fda92]" />
            <button
                type="submit"
                class="bg-[#1fda92] text-[#252525] font-bold p-2 rounded">
                Sign In
            </button>
        </form>
        <p class="text-center mt-4">
            Don't have an account?
            <a href="/register" class="text-[#1fda92] font-bold">Register</a>
        </p>
    </div>
</body>

</html>