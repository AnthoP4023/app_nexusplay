<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusPlay - Tienda de Videojuegos</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="main-content">
        <!-- BANNER PRINCIPAL CON IMAGEN DE FONDO -->
        <section class="hero-banner">
            <div class="hero-overlay">
                <div class="hero-content">
                    <h1 class="hero-title">Bienvenido a NexusPlay</h1>
                    <p class="hero-subtitle">Tu tienda de videojuegos favorita</p>
                    <div class="hero-buttons">
                        <a href="games.php" class="btn btn-primary">Ver Juegos</a>
                        <a href="platform.php" class="btn btn-secondary">Plataformas</a>
                    </div>
                </div>
                <div class="hero-image">
                    <!-- Imagen destacada del banner -->
                    <img src="images/hero-gaming.jpg" alt="Gaming Hero" class="hero-img">
                </div>
            </div>
        </section>

        <!-- SECCIÓN DE PLATAFORMAS -->
        <section class="platforms-section">
            <div class="container">
                <div class="platforms-banner">
                    <a href="platform.php?platform=pc" class="platform-card pc">
                        <i class="fas fa-desktop"></i>
                        <span>PC</span>
                    </a>
                    <a href="platform.php?platform=playstation" class="platform-card ps">
                        <i class="fab fa-playstation"></i>
                        <span>PlayStation</span>
                    </a>
                    <a href="platform.php?platform=xbox" class="platform-card xbox">
                        <i class="fab fa-xbox"></i>
                        <span>Xbox</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- SECCIÓN DE TENDENCIAS -->
        <section class="trending-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Tendencias</h2>
                    <a href="games.php" class="view-all">Ver todos <i class="fas fa-chevron-right"></i></a>
                </div>
                <div class="trending-grid">
                    <!-- Los juegos se cargarán dinámicamente desde la BD -->
                    <div class="trending-card">
                        <div class="trending-image">
                            <img src="images/juegos/cyberpunk2077.jpg" alt="Cyberpunk 2077">
                            <div class="discount-badge">-25%</div>
                        </div>
                        <div class="trending-info">
                            <h3>Cyberpunk 2077</h3>
                            <div class="price">
                                <span class="current-price">49.99 €</span>
                                <span class="original-price">66.99 €</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="trending-card">
                        <div class="trending-image">
                            <img src="images/rimworld.jpg" alt="RimWorld">
                            <div class="discount-badge">-22%</div>
                        </div>
                        <div class="trending-info">
                            <h3>RimWorld - Odyssey</h3>
                            <div class="price">
                                <span class="current-price">18.39 €</span>
                                <span class="original-price">23.59 €</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="trending-card">
                        <div class="trending-image">
                            <img src="images/lies_of_p.jpg" alt="Lies of P">
                            <div class="discount-badge">-24%</div>
                        </div>
                        <div class="trending-info">
                            <h3>Lies of P: Overlord</h3>
                            <div class="price">
                                <span class="current-price">22.92 €</span>
                                <span class="original-price">30.16 €</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>