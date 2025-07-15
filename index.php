<?php
session_start();
require_once 'config/database.php';

// Obtener noticias recientes para el carrusel
$noticias_query = "SELECT * FROM noticias ORDER BY fecha_publicacion DESC LIMIT 5";
$noticias_result = $conn->query($noticias_query);

// Obtener juegos en tendencia
$tendencias_query = "SELECT j.*, p.nombre as plataforma_nombre FROM juegos j 
                    LEFT JOIN plataformas p ON j.plataforma_id = p.id 
                    ORDER BY j.fecha_agregado DESC LIMIT 6";
$tendencias_result = $conn->query($tendencias_query);

// Obtener juegos recomendados (los mejor valorados)
$recomendados_query = "SELECT j.*, p.nombre as plataforma_nombre, 
                      COALESCE(AVG(r.puntuacion), 0) as promedio_rating
                      FROM juegos j 
                      LEFT JOIN plataformas p ON j.plataforma_id = p.id
                      LEFT JOIN resenas r ON j.id = r.juego_id
                      GROUP BY j.id 
                      ORDER BY promedio_rating DESC, j.fecha_agregado DESC 
                      LIMIT 6";
$recomendados_result = $conn->query($recomendados_query);

// Obtener reseñas recientes
$resenas_query = "SELECT r.*, j.titulo as juego_titulo, u.username, j.imagen
                 FROM resenas r 
                 JOIN juegos j ON r.juego_id = j.id 
                 JOIN usuarios u ON r.usuario_id = u.id 
                 ORDER BY r.fecha_resena DESC 
                 LIMIT 6";
$resenas_result = $conn->query($resenas_query);

// Obtener más vendidos (basado en detalles de pedido)
$mas_vendidos_query = "SELECT j.*, p.nombre as plataforma_nombre, 
                      COUNT(dp.juego_id) as total_vendidos
                      FROM juegos j 
                      LEFT JOIN plataformas p ON j.plataforma_id = p.id
                      LEFT JOIN detalles_pedido dp ON j.id = dp.juego_id
                      LEFT JOIN pedidos pe ON dp.pedido_id = pe.id
                      WHERE pe.estado = 'completado' OR pe.estado IS NULL
                      GROUP BY j.id 
                      ORDER BY total_vendidos DESC, j.fecha_agregado DESC 
                      LIMIT 6";
$mas_vendidos_result = $conn->query($mas_vendidos_query);

// Obtener categorías
$categorias_query = "SELECT c.*, COUNT(j.id) as total_juegos 
                    FROM categorias c 
                    LEFT JOIN juegos j ON c.id = j.categoria_id 
                    GROUP BY c.id 
                    ORDER BY total_juegos DESC";
$categorias_result = $conn->query($categorias_query);
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
        <!-- CARRUSEL DE NOTICIAS -->
        <section class="news-carousel-section">
            <div class="container">
                <div class="carousel-container">
                    <div class="carousel-track" id="newsCarousel">
                        <?php if ($noticias_result && $noticias_result->num_rows > 0): ?>
                            <?php while ($noticia = $noticias_result->fetch_assoc()): ?>
                                <div class="carousel-slide" style="background-image: url('images/noticias/<?php echo $noticia['imagen'] ?: 'default-news.jpg'; ?>');">
                                    <div class="slide-overlay"></div>
                                    <div class="slide-content">
                                        <div class="slide-text">
                                            <span class="slide-category">NOTICIAS</span>
                                            <h2><?php echo htmlspecialchars($noticia['titulo']); ?></h2>
                                            <p><?php echo htmlspecialchars(substr($noticia['contenido'], 0, 150)) . '...'; ?></p>
                                            <a href="news.php" class="btn btn-primary">Leer más</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-btn carousel-btn-prev" onclick="moveCarousel(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="carousel-btn carousel-btn-next" onclick="moveCarousel(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <div class="carousel-indicators" id="carouselIndicators"></div>
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
                <div class="games-grid">
                    <?php if ($tendencias_result && $tendencias_result->num_rows > 0): ?>
                        <?php while ($juego = $tendencias_result->fetch_assoc()): ?>
                            <div class="game-card">
                                <div class="game-image">
                                    <img src="images/juegos/<?php echo $juego['imagen'] ?: 'default.jpg'; ?>" alt="<?php echo htmlspecialchars($juego['titulo']); ?>">
                                    <div class="game-overlay">
                                        <a href="game_view.php?id=<?php echo $juego['id']; ?>" class="btn-overlay">Ver detalles</a>
                                    </div>
                                </div>
                                <div class="game-info">
                                    <h3><?php echo htmlspecialchars($juego['titulo']); ?></h3>
                                    <p class="game-platform"><?php echo htmlspecialchars($juego['plataforma_nombre']); ?></p>
                                    <div class="game-price">
                                        <span class="current-price">$<?php echo number_format($juego['precio'], 2); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- SECCIÓN DE CARACTERÍSTICAS -->
        <section class="features-section">
            <div class="container">
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <h3>Súper rápido</h3>
                        <p>Descarga digital instantánea</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Fiable y seguro</h3>
                        <p>Variedad de juegos</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3>Atención al cliente</h3>
                        <p>Agente disponible 24/7</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3>Calificación</h3>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span>4.0</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TE RECOMENDAMOS -->
        <section class="recommended-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Te recomendamos</h2>
                    <a href="games.php" class="view-all">Ver todos <i class="fas fa-chevron-right"></i></a>
                </div>
                <div class="games-grid">
                    <?php if ($recomendados_result && $recomendados_result->num_rows > 0): ?>
                        <?php while ($juego = $recomendados_result->fetch_assoc()): ?>
                            <div class="game-card recommended">
                                <div class="game-image">
                                    <img src="images/juegos/<?php echo $juego['imagen'] ?: 'default.jpg'; ?>" alt="<?php echo htmlspecialchars($juego['titulo']); ?>">
                                    <div class="recommended-badge">Recomendado</div>
                                    <div class="game-overlay">
                                        <a href="game_view.php?id=<?php echo $juego['id']; ?>" class="btn-overlay">Ver detalles</a>
                                    </div>
                                </div>
                                <div class="game-info">
                                    <h3><?php echo htmlspecialchars($juego['titulo']); ?></h3>
                                    <p class="game-platform"><?php echo htmlspecialchars($juego['plataforma_nombre']); ?></p>
                                    <div class="game-rating">
                                        <?php 
                                        $rating = round($juego['promedio_rating']);
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rating) {
                                                echo '<i class="fas fa-star"></i>';
                                            } else {
                                                echo '<i class="far fa-star"></i>';
                                            }
                                        }
                                        ?>
                                        <span>(<?php echo number_format($juego['promedio_rating'], 1); ?>)</span>
                                    </div>
                                    <div class="game-price">
                                        <span class="current-price">$<?php echo number_format($juego['precio'], 2); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- RESEÑAS -->
        <section class="reviews-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Reseñas recientes</h2>
                </div>
                <div class="reviews-grid">
                    <?php if ($resenas_result && $resenas_result->num_rows > 0): ?>
                        <?php while ($resena = $resenas_result->fetch_assoc()): ?>
                            <div class="review-card">
                                <div class="review-header">
                                    <div class="review-game">
                                        <img src="images/juegos/<?php echo $resena['imagen'] ?: 'default.jpg'; ?>" alt="<?php echo htmlspecialchars($resena['juego_titulo']); ?>">
                                        <div>
                                            <h4><?php echo htmlspecialchars($resena['juego_titulo']); ?></h4>
                                            <p>Por <?php echo htmlspecialchars($resena['username']); ?></p>
                                        </div>
                                    </div>
                                    <div class="review-rating">
                                        <?php 
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $resena['puntuacion']) {
                                                echo '<i class="fas fa-star"></i>';
                                            } else {
                                                echo '<i class="far fa-star"></i>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="review-content">
                                    <p><?php echo htmlspecialchars(substr($resena['comentario'], 0, 120)) . '...'; ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- MÁS VENDIDOS -->
        <section class="bestsellers-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Más vendidos</h2>
                    <a href="games.php" class="view-all">Ver todos <i class="fas fa-chevron-right"></i></a>
                </div>
                <div class="games-grid">
                    <?php if ($mas_vendidos_result && $mas_vendidos_result->num_rows > 0): ?>
                        <?php $rank = 1; ?>
                        <?php while ($juego = $mas_vendidos_result->fetch_assoc()): ?>
                            <div class="game-card bestseller">
                                <div class="game-image">
                                    <img src="images/juegos/<?php echo $juego['imagen'] ?: 'default.jpg'; ?>" alt="<?php echo htmlspecialchars($juego['titulo']); ?>">
                                    <div class="bestseller-badge">#<?php echo $rank; ?></div>
                                    <div class="game-overlay">
                                        <a href="game_view.php?id=<?php echo $juego['id']; ?>" class="btn-overlay">Ver detalles</a>
                                    </div>
                                </div>
                                <div class="game-info">
                                    <h3><?php echo htmlspecialchars($juego['titulo']); ?></h3>
                                    <p class="game-platform"><?php echo htmlspecialchars($juego['plataforma_nombre']); ?></p>
                                    <p class="sales-count"><?php echo $juego['total_vendidos']; ?> vendidos</p>
                                    <div class="game-price">
                                        <span class="current-price">$<?php echo number_format($juego['precio'], 2); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php $rank++; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- CATEGORÍAS -->
        <section class="categories-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Explora por categorías</h2>
                </div>
                <div class="categories-grid">
                    <?php if ($categorias_result && $categorias_result->num_rows > 0): ?>
                        <?php while ($categoria = $categorias_result->fetch_assoc()): ?>
                            <a href="games.php?categoria=<?php echo $categoria['id']; ?>" class="category-card">
                                <div class="category-icon">
                                    <i class="fas fa-gamepad"></i>
                                </div>
                                <h3><?php echo htmlspecialchars($categoria['nombre']); ?></h3>
                                <p><?php echo $categoria['total_juegos']; ?> juegos</p>
                            </a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script>
        // Carrusel de noticias
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const totalSlides = slides.length;

        function showSlide(index) {
            const carousel = document.getElementById('newsCarousel');
            currentSlide = (index + totalSlides) % totalSlides;
            carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
            updateIndicators();
        }

        function moveCarousel(direction) {
            showSlide(currentSlide + direction);
        }

        function updateIndicators() {
            const indicators = document.getElementById('carouselIndicators');
            indicators.innerHTML = '';
            for (let i = 0; i < totalSlides; i++) {
                const indicator = document.createElement('button');
                indicator.className = `indicator ${i === currentSlide ? 'active' : ''}`;
                indicator.onclick = () => showSlide(i);
                indicators.appendChild(indicator);
            }
        }

        // Auto-play del carrusel
        if (totalSlides > 1) {
            updateIndicators();
            setInterval(() => {
                moveCarousel(1);
            }, 5000);
        }

        // Smooth scrolling para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>