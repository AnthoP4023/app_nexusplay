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

        <!-- BUSCADOR CON PLATAFORMAS DENTRO -->
        <div class="search-with-platforms" id="searchWithPlatforms">
            <!-- Estado inicial: Plataformas + Lupa -->
            <div class="platforms-inside" id="platformsInside">
                <a href="platform.php?platform=pc" class="platform-icon">
                    <i class="fas fa-desktop"></i>
                    <span>PC</span>
                </a>
                <a href="platform.php?platform=playstation" class="platform-icon">
                    <i class="fab fa-playstation"></i>
                    <span>PlayStation</span>
                </a>
                <a href="platform.php?platform=xbox" class="platform-icon">
                    <i class="fab fa-xbox"></i>
                    <span>Xbox</span>
                </a>
            </div>
            
            <!-- Botón lupa -->
            <button class="search-trigger-btn" id="searchTriggerBtn" onclick="expandSearchInput()">
                <i class="fas fa-search"></i>
            </button>
            
            <!-- Input expandido (oculto inicialmente) -->
            <form class="search-input-form" id="searchInputForm" action="search.php" method="GET" style="display: none;">
                <input type="text" name="q" placeholder="Buscar juegos..." class="search-input-field" id="searchInputField">
                <button type="submit" class="search-submit-icon">
                    <i class="fas fa-search"></i>
                </button>
                <button type="button" class="search-cancel-btn" onclick="collapseSearchInput()">
                    <i class="fas fa-times"></i>
                </button>
            </form>
        </div>

        <!-- ICONOS NAVEGACIÓN -->
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

<!-- BARRA DE PLATAFORMAS MÓVIL -->
<div class="mobile-platforms-bar" id="mobilePlatformsBar">
    <div class="mobile-platforms-content">
        <a href="platform.php?platform=pc" class="mobile-platform-icon">
            <i class="fas fa-desktop"></i>
            <span>PC</span>
        </a>
        <a href="platform.php?platform=playstation" class="mobile-platform-icon">
            <i class="fab fa-playstation"></i>
            <span>PlayStation</span>
        </a>
        <a href="platform.php?platform=xbox" class="mobile-platform-icon">
            <i class="fab fa-xbox"></i>
            <span>Xbox</span>
        </a>
    </div>
</div>

<script>
function expandSearchInput() {
    const platformsInside = document.getElementById('platformsInside');
    const searchTriggerBtn = document.getElementById('searchTriggerBtn');
    const searchInputForm = document.getElementById('searchInputForm');
    const searchInputField = document.getElementById('searchInputField');
    
    // Ocultar plataformas y botón lupa
    platformsInside.style.display = 'none';
    searchTriggerBtn.style.display = 'none';
    
    // Mostrar input de búsqueda
    searchInputForm.style.display = 'flex';
    
    // Enfocar el input
    setTimeout(() => {
        searchInputField.focus();
    }, 100);
}

function collapseSearchInput() {
    const platformsInside = document.getElementById('platformsInside');
    const searchTriggerBtn = document.getElementById('searchTriggerBtn');
    const searchInputForm = document.getElementById('searchInputForm');
    const searchInputField = document.getElementById('searchInputField');
    
    // Limpiar input
    searchInputField.value = '';
    
    // Ocultar input de búsqueda
    searchInputForm.style.display = 'none';
    
    // Mostrar plataformas y botón lupa
    platformsInside.style.display = 'flex';
    searchTriggerBtn.style.display = 'flex';
}

// Cerrar con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        collapseSearchInput();
    }
});

// Cerrar si se hace clic fuera
document.addEventListener('click', function(e) {
    const searchWithPlatforms = document.getElementById('searchWithPlatforms');
    const searchInputForm = document.getElementById('searchInputForm');
    
    if (!searchWithPlatforms.contains(e.target) && searchInputForm.style.display === 'flex') {
        collapseSearchInput();
    }
});

// Script para ocultar/mostrar barra móvil al hacer scroll
let lastScrollTop = 0;
const mobilePlatformsBar = document.getElementById('mobilePlatformsBar');

window.addEventListener('scroll', function() {
    if (window.innerWidth <= 768) {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > lastScrollTop) {
            // Scrolling down - hide bar
            mobilePlatformsBar.classList.add('hidden');
        } else {
            // Scrolling up - show bar
            mobilePlatformsBar.classList.remove('hidden');
        }
        
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }
});
</script>