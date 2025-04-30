<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap 5.3.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- External Libraries -->
  <script src="https://kit.fontawesome.com/6ac3910c4e.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.7.9/dat.gui.min.js"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Oswald:wght@400;600;700&display=swap"
    rel="stylesheet">
  <script src="https://kit.fontawesome.com/6ac3910c4e.js" crossorigin="anonymous"></script>

  <!-- Custom CSS -->

  <link rel="stylesheet" href="/css/style.css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <!-- Three.js and Extensions -->
  <script src="https://unpkg.com/three@0.106.2/build/three.min.js"></script>
  <script src="https://unpkg.com/three@0.106.2/examples/js/controls/OrbitControls.js"></script>
  <script src="https://unpkg.com/three@0.106.2/examples/js/loaders/GLTFLoader.js"></script>

  <title>3D Web Page</title>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">My 3D Drinks</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#" onclick="swapContent('home')">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#" onclick="swapContent('about')">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#" onclick="swapContent('gallerySection')">Gallery</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="drinksDropdown" role="button"
              data-bs-toggle="dropdown">Drinks</a>
            <ul class="dropdown-menu" aria-labelledby="drinksDropdown" id="drinkDropdown">
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- Hero Section -->
  <div id="home" class="content active">
    <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
    <header
      class="hero-section position-relative vh-100 d-flex align-items-center justify-content-center text-center overflow-hidden">

      <video id="heroVideo" class="hero-video position-absolute top-0 start-0 w-100 h-100 object-fit-cover" autoplay
        loop muted playsinline>
        <source src="/assets/video/dpsplash.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>

      <div id="heroContent" class="hero-content position-relative text-white">
        <h1 class="display-4 fw-bold">Experience Refreshment in 3D</h1>
        <p class="lead">Interact with Coca-Cola, Sprite, and Dr Pepper models</p>
      </div>

    </header>
    <!-- Features Section -->
    <section id="features">
      <div class="container">
        <div class="row text-center">
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
              <img src="/assets/images/coca_cola.jpg" class="card-img-top" alt="Coca Cola">
              <div class="card-body">
                <h5 class="card-title">Coca Cola</h5>
                <p class="card-text">Classic taste, classic style. Now in 3D!</p>
                <a href="#" class="btn btn-outline-primary" onclick="swapContent('coke')">View 3D</a>

              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
              <img src="/assets/images/sprite.jpg" class="card-img-top" alt="Sprite">
              <div class="card-body">
                <h5 class="card-title">Sprite</h5>
                <p class="card-text">Lemon-lime refreshment, reimagined.</p>
                <a href="#" class="btn btn-outline-primary" onclick="swapContent('sprite')">View 3D</a>

              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
              <img src="/assets/images/dr_pepper.jpg" class="card-img-top" alt="Dr Pepper">
              <div class="card-body">
                <h5 class="card-title">Dr Pepper</h5>
                <p class="card-text">23 flavours, infinite imagination.</p>
                <a href="#" class="btn btn-outline-primary" onclick="swapContent('pepper')">View 3D</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


  <div class="text-center my-4">
    <button id="themeToggle" class="btn btn-outline-success">Dark Mode</button>

  </div>
  <!-- Coke Section -->
  <div id="coke" class="content">
    <div class="container py-5">
      <div class="card shadow">
        <div class="card-header text-center">
          <h1 class="mb-0">Coca-Cola</h1>
        </div>
        <div class="card-body text-center">
          <div id="canvasWrapper-coke" style="position: relative;">
            <canvas id="threeContainer" class="w-100 rounded" title="3D Viewer - Coca Cola"></canvas>
          </div>
          <div class="controls-row d-flex flex-wrap justify-content-center gap-2 mt-4">
            <div id="button-panel">
              <button id="btn-coke" class="btn btn-primary m-2">Animate</button>
              <button id="toggleWireframe-coke" class="btn btn-secondary m-2">Toggle Wireframe</button>
              <button id="Rotate-coke" class="btn btn-secondary m-2">Rotate</button>
            </div>
          </div>
          <div id="model-nav">
            <button id="prev-model">⬅️</button>
            <button id="next-model">➡️</button>
          </div>
          <div class="control-panel">
  <div class="btn-group">
    <button id="cam-front-coke">Front</button>
    <button id="cam-side-coke">Side</button>
    <button id="cam-top-coke">Top</button>
    <button id="cam-ortho-coke">Ortho</button>
  </div>
  <div class="btn-group">
    <button id="light-toggle-coke">Toggle Spot</button>
    <input type="color" id="light-color-coke" title="Light Color">
    <input type="range" id="light-coke" min="0" max="5" step="0.1">
  </div>
  <div class="btn-group">
    <button id="mat-gloss-coke">Glossy</button>
    <button id="mat-matte-coke">Matte</button>
  </div>
</div>
          <div id="gui-container" class="ms-4"></div>
        </div>
      </div>
    </div>
    <div id="gallery-coke" class="d-flex flex-wrap justify-content-center mt-4"></div>
  </div>

  <!-- Sprite Section -->
  <div id="sprite" class="content">
    <div class="container py-5">
      <div class="card shadow">
        <div class="card-header text-center">
          <h1 class="mb-0">Sprite</h1>
        </div>
        <div class="card-body text-center">
          <div id="canvasWrapper-sprite" style="position: relative;">
            <canvas id="threeContainer" class="w-100 rounded" title="3D Viewer - Sprite"></canvas>
          </div>
          <div class="controls-row d-flex flex-wrap justify-content-center gap-2 mt-4">
            <div id="button-panel">
              <button id="btn-sprite" class="btn btn-primary m-2">Add Ice</button>
              <button id="toggleWireframe-sprite" class="btn btn-secondary m-2">Toggle Wireframe</button>
              <button id="Rotate-sprite" class="btn btn-secondary m-2">Rotate</button>
            </div>
          </div>
          <div class="control-panel">
  <div class="btn-group">
    <button id="cam-front-sprite">Front</button>
    <button id="cam-side-sprite">Side</button>
    <button id="cam-top-sprite">Top</button>
    <button id="cam-ortho-sprite">Ortho</button>
  </div>
  <div class="btn-group">
    <button id="light-toggle-sprite">Toggle Spot</button>
    <input type="color" id="light-color-sprite" title="Light Color">
    <input type="range" id="light-int-sprite" min="0" max="5" step="0.1">
  </div>
  <div class="btn-group">
    <button id="mat-gloss-sprite">Glossy</button>
    <button id="mat-matte-sprite">Matte</button>
  </div>
</div>



          <div id="gui-container" class="ms-4"></div>
        </div>
      </div>
    </div>
    <div id="gallery-sprite" class="d-flex flex-wrap justify-content-center mt-4"></div>
  </div>


  <!-- Dr Pepper Section -->
  <div id="pepper" class="content">
    <div class="container py-5">
      <div class="card shadow">
        <div class="card-header text-center">
          <h1 class="mb-0">Dr Pepper</h1>
        </div>
        <div class="card-body text-center">
          <div id="canvasWrapper-pepper" style="position: relative;">
            <canvas id="threeContainer" class="w-100 rounded" title="3D Viewer - Dr Pepper"></canvas>
          </div>
          <div class="controls-row d-flex flex-wrap justify-content-center gap-2 mt-4">
            <div id="button-panel">
              <button id="btn-pepper" class="btn btn-primary m-2">Add Ice</button>
              <button id="toggleWireframe-pepper" class="btn btn-secondary m-2">Toggle Wireframe</button>
              <button id="Rotate-pepper" class="btn btn-secondary m-2">Rotate</button>
            </div>
          </div>
          <div class="control-panel">
  <div class="btn-group">
    <button id="cam-front-pepper">Front</button>
    <button id="cam-side-pepper">Side</button>
    <button id="cam-top-pepper">Top</button>
    <button id="cam-ortho-pepper">Ortho</button>
  </div>
  <div class="btn-group">
    <button id="light-toggle-pepper">Toggle Spot</button>
    <input type="color" id="light-color-pepper" title="Light Color">
    <input type="range" id="light-int-pepper" min="0" max="5" step="0.1">
  </div>
  <div class="btn-group">
    <button id="mat-gloss-pepper">Glossy</button>
    <button id="mat-matte-pepper">Matte</button>
  </div>
</div>
          <div id="gui-container" class="ms-4"></div>
        </div>
      </div>
    </div>
    <div id="gallery-pepper" class="d-flex flex-wrap justify-content-center mt-4"></div>
  </div>



  <!-- Gallery Section -->
<section id="gallerySection" class="content container my-5">
  <div id="gallery" class="d-flex flex-wrap justify-content-center">
    <!-- JS will inject gallery items here -->
  </div>
</section>

<!-- Hero Section -->
<section class="galleryhero-section position-relative vh-100 overflow-hidden">
  <!-- Dark overlay -->
  <div class="galleryhero-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

  <!-- Background video -->
  <video
    id="galleryheroVideo"
    class="galleryhero-video position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
    autoplay
    loop
    muted
    playsinline
  >
    <source src="/assets/video/spritepour.mp4" type="video/mp4" />
    Your browser does not support the video tag.
  </video>

  <!-- Hero content -->
  <div
    id="galleryheroContent"
    class="galleryhero-content position-relative text-center text-white px-3"
    style="z-index:1;"
  >
    <h1 class="display-4 fw-bold">Image Gallery</h1>
    <p class="lead">All of them</p>
  </div>
</section>


  

  <!-- About Section -->
  <div id="about" class="content">
    <section class="py-5">
      <div class="container text-center">


        <div class="container mt-4">
          <h1 class="mb-4">About This Web 3D Application</h1>

          <h2>Technologies Used</h2>
          <ul>
            <li>HTML5, CSS3, JavaScript (ES6+)</li>
            <li>Bootstrap 5 for responsive layout</li>
            <li>Three.js for 3D model rendering and interactivity</li>
            <li>dat.GUI for real-time lighting controls</li>
            <li>jQuery</li>
          </ul>

          <h2>Design and Implementation</h2>
          <p>This application uses a mobile-first responsive layout and includes navigation, media content,
            and interactive 3D elements. It is built as a Single Page Application (SPA) using JavaScript content
            swapping and Three.js rendering pipelines.</p>

          <h2>Interactivity Features</h2>
          <ul>
            <li>Load and switch between GLTF models</li>
            <li>Play animations with audio cues</li>
            <li>Lighting and camera manipulation</li>
            <li>Wireframe toggling and object rotation</li>
          </ul>

          <h2>Testing Strategy</h2>
          <p>Tested using Chrome DevTools for:</p>
          <ul>
            <li>Cross-browser compatibility (Chrome, Firefox, Edge)</li>
            <li>Responsive behaviour on desktop, tablet, and mobile views</li>
            <li>Keyboard accessibility</li>
            <li>Functional testing of all interactive features</li>
          </ul>

          <h2>Accessibility Considerations</h2>
          <p>Included keyboard navigation, contrast-checked colour schemes, labelled buttons, and alt-text where
            possible.</p>


        </div>
      </div>
    </section>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-light py-4">
    <div class="container text-center">
      <p>&copy; 2025 Mobile Web 3D Application. All Rights Reserved.</p>
      <div>
        <a href="#" class="text-light"><i class="fab fa-github fa-lg"></i></a>
      </div>
    </div>
  </footer>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Scripts -->
  <script src="/js/script.js"></script>
  <script src="/gallery/gallery.js"></script>

</body>

</html>