<!DOCTYPE HTML>
<html>
	<head>
		<title>Construcciones_RS</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
		<div id="wrapper">

			<!-- Header -->
			<header id="header">
				<div class="logo">
                <link rel="icon" type="image/vnd.microsoft.icon" href="logo.ico">
					<span class="icon fa-gem"></span>
				</div>
				<div class="content">
					<div class="inner">
						<h1>Construcciones RS</h1>
						<p>Tu lo piensas, nosotros lo dise&ntilde;amos.</p>
					</div>
				</div>
				<nav>
					<ul>
						<li><a href="#intro">Intro</a></li>
						<li><a href="#work">Trabajos</a></li>
						<li><a href="#about">Acerca de</a></li>
						<li><a href="#contact">Contacto</a></li>
					</ul>
				</nav>
			</header>

			<!-- Main -->
			<div id="main">

				<!-- Intro -->
				<article id="intro">
					<h2 class="major">Introducci&oacute;n</h2>
					<span class="image main"><img src="images/pic01.jpg" alt="" /></span>
					<p>Soluciones de construcci&oacute;n en maderer&iacute;a.</p>
				</article>

				<!-- Work -->
				<article id="work">
					<h2 class="major">Trabajos</h2>
					
					<!-- CSS para el slider de im�genes -->
					<style>
						* {
							box-sizing: border-box;
							margin: 0;
							padding: 0;
						}

						body {
							font-family: Arial, sans-serif;
							background: #111;
							color: white;
						}

						.container {
							display: flex;
							flex-direction: row;
							height: 80vh; /* Reducido a 80% de la altura de la ventana */
							overflow: hidden;
						}

						.slider {
							flex: 4;
							position: relative;
							overflow: hidden;
							display: flex;
							align-items: center;
							justify-content: center;
							background: #2C2F36;
						}

						.slides {
							display: flex;
							transition: transform 0.8s ease;
							height: 100%; /* Asegura que las im�genes ocupen el 100% de la altura del slider */
							width: 100%;
						}

						.slide {
							min-width: 100%;
							display: flex;
							align-items: center;
							justify-content: center;
						}

						/* Modificar para la primera imagen */
						.slide img:first-child {
							width: 100%;
							height: 100%;
							object-fit: cover; /* Esto asegura que la imagen cubra todo el espacio sin deformarse */
						}

						/* Las siguientes im�genes pueden ser m�s peque�as */
						.slide img {
							width: 100%;
							height: auto;
							max-height: 40vh; /* Reducido a 40% de la altura de la ventana */
							object-fit: contain;
						}

						.thumbnails {
							flex: 1;
							background: #222;
							padding: 10px;
							display: flex;
							flex-direction: column;
							gap: 10px;
							overflow-y: auto;
						}

						.thumbnail {
							cursor: pointer;
							border: 2px solid transparent;
							transition: border 0.3s;
						}

						.thumbnail.active {
							border-color: #fff;
						}

						.thumbnail img {
							width: 100%;
							height: 30px; /* Reducido a 30px de alto */
							object-fit: cover;
							border-radius: 3px;
						}

						@media (max-width: 768px) {
							.container {
								flex-direction: column;
								height: auto;
							}

							.slider {
								order: 1;
								height: auto;
							}

							.slides {
								flex-direction: row;
								height: auto;
							}

							.slide img {
								height: auto;
								max-height: 40vh; /* Reducido a 40% de la altura de la ventana */
							}

							.thumbnails {
								order: 2;
								flex-direction: row;
								flex-wrap: nowrap;
								overflow-x: auto;
								overflow-y: hidden;
								width: 100%;
								height: auto;
							}

							.thumbnail {
								min-width: 80px;
								flex-shrink: 0;
							}
						}
					</style>

					<!-- Slider de Im�genes -->
					<div class="container">
						<div class="slider" id="slider">
							<div class="slides" id="slides"></div>
						</div>

						<div class="thumbnails" id="thumbnails"></div>
					</div>

					<!-- Script para controlar el slider -->
					<script>
						const totalImages = 5;
						const slidesContainer = document.getElementById('slides');
						const thumbnailsContainer = document.getElementById('thumbnails');
						let currentIndex = 0;
						let startX = 0;
						let isDragging = false;
						let slideInterval;

						// Generar din�micamente las im�genes
						for (let i = 1; i <= totalImages; i++) {
							const slide = document.createElement('div');
							slide.className = 'slide';
							if (i === 1) slide.classList.add('active');
							slide.innerHTML = `<img src="images/img${i.toString().padStart(2, '0')}.jpg" alt="Imagen ${i}">`;
							slidesContainer.appendChild(slide);

							const thumb = document.createElement('div');
							thumb.className = 'thumbnail';
							if (i === 1) thumb.classList.add('active');
							thumb.dataset.index = i - 1;
							thumb.innerHTML = `<img src="images/img${i.toString().padStart(2, '0')}.jpg" alt="Miniatura ${i}">`;
							thumbnailsContainer.appendChild(thumb);
						}

						const slides = document.querySelectorAll('.slide');
						const thumbnails = document.querySelectorAll('.thumbnail');

						function showSlide(index) {
							if (index >= slides.length) index = 0;
							if (index < 0) index = slides.length - 1;

							slidesContainer.style.transform = `translateX(-${index * 100}%)`;
							thumbnails.forEach(t => t.classList.remove('active'));
							thumbnails[index].classList.add('active');
							currentIndex = index;
						}

						thumbnails.forEach(thumb => {
							thumb.addEventListener('click', () => {
								const index = parseInt(thumb.getAttribute('data-index'));
								showSlide(index);
								restartAutoSlide();
							});
						});

						// Swipe m�vil
						slidesContainer.addEventListener('touchstart', (e) => {
							startX = e.touches[0].clientX;
							isDragging = true;
						});

						slidesContainer.addEventListener('touchmove', (e) => {
							if (!isDragging) return;
							const touchX = e.touches[0].clientX;
							const diffX = touchX - startX;

							if (Math.abs(diffX) > 50) {
								showSlide(currentIndex + (diffX < 0 ? 1 : -1));
								isDragging = false;
							}
						});

						slidesContainer.addEventListener('touchend', () => {
							isDragging = false;
						});

						function startAutoSlide() {
							slideInterval = setInterval(() => {
								showSlide(currentIndex + 1);
							}, 5000);
						}

						function restartAutoSlide() {
							clearInterval(slideInterval);
							startAutoSlide();
						}

						showSlide(0);
						startAutoSlide();
					</script>

				</article>

				<!-- About -->
				<article id="about">
					<h2 class="major">Acerca de</h2>
					<span class="image main"><img src="images/pic03.jpg" alt="" /></span>
					<p>Empresa dedicada a desarrollar, fabricar e instalar productos de madera de alta calidad.</p>
				</article>

				<!-- Contact -->
				<article id="contact">
					<h2 class="major">Contacto</h2>
					<form method="post" action="#"> 

						<div class="fields">
							<div class="field half">
								<label for="name">Whatssap</label>
								<label>- 55 4919 0995</label>
								<label>- 55 3177 4925 </label>
							</div>
							<div class="field half">
								<label for="email">Email</label>
								<p>- atenciones-rs@hotmail.com</p>
								<p>- atenciones.rs@gmail.com</p>
							</div>
                        
                                    <ul class="icons">
										<li><a href="https://x.com/AtencionesRS" class="icon brands fa-twitter" target="_blank"><span class="label">Twitter</span></a></li>
										<li><a href="https://www.facebook.com/profile.php?id=61574826191263" class="icon brands fa-facebook-f" target="_blank"><span class="label">Facebook</span></a></li>
										<li><a href="https://www.instagram.com/atencionesramirezsolano/" class="icon brands fa-instagram" target="_blank"><span class="label">Instagram</span></a></li>
									</ul>
					</form>
				</article>

			</div>

			<!-- Footer -->
			<footer>
			</footer>

		</div>

		<!-- BG -->
		<div id="bg"></div>

		<!-- Scripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/browser.min.js"></script>
		<script src="assets/js/breakpoints.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>

	</body>
</html>
