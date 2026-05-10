<nav class="fixed w-full z-50 top-0 start-0 border-b border-gray-200 bg-white/90 backdrop-blur-md transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <div class="flex-shrink-0 flex items-center">
                <a href="index.php" class="flex items-center gap-2 text-2xl font-extrabold text-blue-600 tracking-tight font-[Poppins] hover:opacity-80 transition">
                    <i class="fa-solid fa-paper-plane"></i> TripKampus
                </a>
            </div>

            <div class="hidden md:flex space-x-8">
                <a href="index.php" class="text-gray-600 hover:text-blue-600 font-medium transition duration-300 text-sm uppercase tracking-wide">Beranda</a>
                <a href="index.php#trips" class="text-gray-600 hover:text-blue-600 font-medium transition duration-300 text-sm uppercase tracking-wide">Paket Trip</a>
                <a href="index.php#kenapa-kami" class="text-gray-600 hover:text-blue-600 font-medium transition duration-300 text-sm uppercase tracking-wide">Keunggulan</a>
            </div>

            <div class="hidden md:flex items-center space-x-3">
                <?php if(isset($_SESSION['user_login'])): ?>
                    <div class="flex items-center gap-3 pl-6 border-l border-gray-300">
                        <div class="text-right hidden lg:block">
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Member</p>
                            <p class="text-sm font-bold text-gray-800 leading-none"><?= $_SESSION['user_nama']; ?></p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-md">
                            <?= substr($_SESSION['user_nama'], 0, 1); ?>
                        </div>
                        <a href="logout.php" class="ml-2 text-gray-400 hover:text-red-500 transition p-2 rounded-full hover:bg-red-50" title="Logout">
                            <i class="fa-solid fa-power-off text-lg"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="px-5 py-2.5 text-sm font-bold text-blue-600 hover:text-blue-700 transition">
                        Masuk
                    </a>
                    <a href="register.php" class="px-6 py-2.5 text-sm font-bold bg-blue-600 text-white rounded-full hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                        Daftar Sekarang
                    </a>
                <?php endif; ?>
            </div>

            <div class="md:hidden flex items-center">
                <button class="text-gray-600 hover:text-blue-600 focus:outline-none p-2">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>

        </div>
    </div>
</nav>