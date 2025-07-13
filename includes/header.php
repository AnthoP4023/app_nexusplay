<?php
require_once 'includes/functions.php';
?>

<header class="header">
    <div class="nav-container">
        <!-- LOGO -->
        <div class="logo">
            <img src="images/logo.png" alt="NexusPlay Logo" class="logo-img">
            <span class="logo-text">NexusPlay</span>
        </div>

        <!-- BUSCADOR -->
        <div class="search-container">
            <!-- BÚSQUEDA DESKTOP -->
            <form class="search-form desktop-search" action="search.php" method="GET">
                <input type="text" name="q" placeholder="Buscar juegos..." class="search-input">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            
            <!-- BÚSQUEDA MÓVIL -->
            <div class="mobile-search">
                <button class="search-toggle" onclick="toggleMobileSearch()">
                    <i class="fas fa-search"></i>
                </button>
                <form class="mobile-search-form" id="mobileSearchForm" action="search.php" method="GET">
                    <input type="text" name="q" placeholder="Buscar juegos..." class="mobile-search-input">
                    <button type="submit" class="mobile-search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                    <button type="button" class="mobile-search-close" onclick="closeMobileSearch()">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- PLATAFORMAS (SOLO DESKTOP) -->
        <div class="platforms-nav desktop-only">
            <a href="platform.php?platform=pc" class="platform-btn pc" title="PC Gaming">
                <i class="fas fa-desktop"></i>
                <span>PC</span>
            </a>
            <a href="platform.php?platform=playstation" class="platform-btn ps" title="PlayStation">
                <i class="fab fa-playstation"></i>
                <span>PS</span>
            </a>
            <a href="platform.php?platform=xbox" class="platform-btn xbox" title="Xbox">
                <i class="fab fa-xbox"></i>
                <span>Xbox</span>
            </a>
        </div>

        <!-- ICONOS -->
        <div class="nav-icons">
            <!-- Noticias -->
            <a href="news.php" class="nav-icon" title="Noticias">
                <i class="fas fa-newspaper"></i>
                <span>Noticias</span>
            </a>

            <!-- Carrito -->
            <a href="cart.php" class="nav-icon" title="Carrito">
                <i class="fas fa-shopping-cart"></i>
                <span>Carrito</span>
            </a>

            <!-- Login/Perfil -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.php" class="nav-icon" title="Perfil">
                    <i class="fas fa-user"></i>
                    <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </a>
                <!-- Cerrar Sesión -->
                <a href="auth/logout.php" class="nav-icon logout" title="Cerrar Sesión">
                    <i class="fas fa-door-open"></i>
                    <span>Salir</span>
                </a>
            <?php else: ?>
                <a href="auth/login.php" class="nav-icon" title="Iniciar Sesión">
                    <i class="fas fa-user"></i>
                    <span>Login</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
function toggleMobileSearch() {
    const searchForm = document.getElementById('mobileSearchForm');
    const searchInput = searchForm.querySelector('.mobile-search-input');
    searchForm.classList.add('active');
    searchInput.focus();
}

function closeMobileSearch() {
    const searchForm = document.getElementById('mobileSearchForm');
    searchForm.classList.remove('active');
}

// Cerrar búsqueda móvil si se hace clic fuera
window.onclick = function(event) {
    if (!event.target.closest('.mobile-search')) {
        const searchForm = document.getElementById('mobileSearchForm');
        if (searchForm && searchForm.classList.contains('active')) {
            searchForm.classList.remove('active');
        }
    }
}
</script>