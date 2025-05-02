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
      <div class="card-body">
        <div class="row">
          <!-- 3D Viewer Column -->
          <div class="col-lg-8 col-12 order-lg-1">
            <div id="canvasWrapper-coke" class="three-canvas-wrapper mb-4">
              <canvas id="threeContainer" class="w-100 rounded" title="3D Viewer - Coca Cola"></canvas>
            </div>

            <div class="controls-row d-flex flex-wrap justify-content-center gap-2 mt-4">
              <div id="button-panel">
                <button id="btn-coke" class="btn btn-primary m-2">Animate</button>
                <button id="toggleWireframe-coke" class="btn btn-secondary m-2">Toggle Wireframe</button>
                <button id="Rotate-coke" class="btn btn-secondary m-2">Rotate</button>
              </div>
            </div>

            <div id="model-nav" class="mt-3">
              <button id="prev-model-coke">⬅️</button>
              <button id="next-model-coke">➡️</button>
            </div>

            <div class="control-panel mt-3">
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

            <div id="gui-container" class="ms-4 mt-3"></div>
          </div>

          <!-- Model Notes Column -->
          <div class="col-lg-4 col-12 order-lg-2 mt-4 mt-lg-0">
            <div class="model-notes-wrapper">
              <!-- Toggle button only shown on small screens -->
              <button class="toggle-notes-btn" aria-controls="notes-coke" aria-expanded="false">
                Show Model Notes
              </button>

              <div class="model-notes" id="notes-coke">
                <h5 class="fw-bold">Model Production Notes</h5>
                <p>
                  The Coca-Cola can and bottle were modelled in Blender with clean geometry and a low-poly approach for performance. UV unwrapping was carefully adjusted to match label alignment, and branding textures were optimised for web delivery.
                </p>
                <p>
                  Both models were exported as GLB files and can be swapped dynamically in the viewer. Users can control lighting, camera angles, animation, and material styles using the UI or buttons.
                </p>
              </div>
            </div>
          </div>
        
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Sprite Section -->
<div id="sprite" class="content">
  <div class="container py-5">
    <div class="card shadow">
      <div class="card-header text-center">
        <h1 class="mb-0">Sprite</h1>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- 3D Viewer Column -->
          <div class="col-lg-8 col-12 order-lg-1">
            <div id="canvasWrapper-sprite" class="three-canvas-wrapper mb-4">
              <canvas id="threeContainer" class="w-100 rounded" title="3D Viewer - Sprite"></canvas>
            </div>

            <div class="controls-row d-flex flex-wrap justify-content-center gap-2 mt-4">
              <div id="button-panel">
                <button id="btn-sprite" class="btn btn-primary m-2">Animate</button>
                <button id="toggleWireframe-sprite" class="btn btn-secondary m-2">Toggle Wireframe</button>
                <button id="Rotate-sprite" class="btn btn-secondary m-2">Rotate</button>
              </div>
            </div>

            <div class="control-panel mt-3">
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

            <div id="gui-container" class="ms-4 mt-3"></div>
          </div>

          <!-- Model Notes Column -->
          <div class="col-lg-4 col-12 order-lg-2 mt-4 mt-lg-0">
            <div class="model-notes-wrapper">
              <button class="toggle-notes-btn" aria-controls="notes-sprite" aria-expanded="false">
                Show Model Notes
              </button>

              <div class="model-notes" id="notes-sprite">
                <h5 class="fw-bold">Model Production Notes</h5>
                <p>
                  The Sprite bottle model was created in Blender using a higher-poly base with curved surface detail. Transparency and reflective material properties were adjusted using Three.js to simulate a glass effect.
                </p>
                <p>
                  Label textures were aligned using cylindrical UV mapping and tested in multiple lighting setups. The viewer allows switching between bottle and can versions, light control, and predefined camera views.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Dr Pepper Section -->
<div id="pepper" class="content">
  <div class="container py-5">
    <div class="card shadow">
      <div class="card-header text-center">
        <h1 class="mb-0">Dr Pepper</h1>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- 3D Viewer Column -->
          <div class="col-lg-8 col-12 order-lg-1">
            <div id="canvasWrapper-pepper" class="three-canvas-wrapper mb-4">
              <canvas id="threeContainer" class="w-100 rounded" title="3D Viewer - Dr Pepper"></canvas>
            </div>

            <div class="controls-row d-flex flex-wrap justify-content-center gap-2 mt-4">
              <div id="button-panel">
                <button id="btn-pepper" class="btn btn-primary m-2">Animate</button>
                <button id="toggleWireframe-pepper" class="btn btn-secondary m-2">Toggle Wireframe</button>
                <button id="Rotate-pepper" class="btn btn-secondary m-2">Rotate</button>
              </div>
            </div>

            <div class="control-panel mt-3">
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

            <div id="model-nav" class="mt-3">
              <button id="prev-model-pepper">⬅️</button>
              <button id="next-model-pepper">➡️</button>
            </div>

            <div id="gui-container" class="ms-4 mt-3"></div>
          </div>

          <!-- Model Notes Column -->
          <div class="col-lg-4 col-12 order-lg-2 mt-4 mt-lg-0">
            <div class="model-notes-wrapper">
              <button class="toggle-notes-btn" aria-controls="notes-pepper" aria-expanded="false">
                Show Model Notes
              </button>

              <div class="model-notes" id="notes-pepper">
                <h5 class="fw-bold">Model Production Notes</h5>
                <p>
                  This 3D Dr Pepper can was created in Blender using a low-poly cylinder base mesh. The UV unwrapping was done manually to ensure proper texture alignment with the branding and barcode.
                </p>
                <p>
                  Two variants (standard and stylised) were exported to GLB and loaded dynamically. The model supports material changes (gloss/matte), spotlight interaction, and animation triggered by JavaScript.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


  <!-- Gallery Section -->
  <section id="gallerySection" class="content">
    <div class="container py-5">
      <!-- Hero Section -->
      <section class="galleryhero-section position-relative vh-100 overflow-hidden">
        <!-- Dark overlay -->
        <div class="galleryhero-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

        <!-- Background video -->
        <video id="galleryheroVideo"
          class="galleryhero-video position-absolute top-0 start-0 w-100 h-100 object-fit-cover" autoplay loop muted
          playsinline>
          <source src="/assets/video/spritepour.mp4" type="video/mp4" />
          Your browser does not support the video tag.
        </video>

        <!-- Hero content -->
        <div id="galleryheroContent" class="galleryhero-content position-relative text-center text-white px-3"
          style="z-index:1;">
          <h1 class="display-4 fw-bold">Image Gallery</h1>
          <p class="lead">All of them</p>
        </div>
      </section>

      <div id="gallery-coke" class="mb-5">
        <h2 class="text-center">Coke</h2>
        <div class="row justify-content-center"></div>
      </div>

      <div id="gallery-sprite" class="mb-5">
        <h2 class="text-center">Sprite</h2>
        <div class="row justify-content-center"></div>
      </div>

      <div id="gallery-pepper" class="mb-5">
        <h2 class="text-center">Dr Pepper</h2>
        <div class="row justify-content-center"></div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <div id="about" class="content">
  <section class="container mt-5">
  <h1>About This 3D Web Application</h1>

  <h2>Project Overview</h2>
  <p>This interactive 3D Web App showcases three Coca-Cola brand products: Coca-Cola, Sprite, and Dr Pepper. Each brand includes detailed 3D models that users can manipulate in real-time using Three.js. The application is built using a modular MVC framework with PHP, SQLite, AJAX, and JSON, allowing dynamic interaction and media retrieval.</p>

  <h2>Technologies Used</h2>
  <ul>
    <li>HTML5 / CSS3 / JavaScript</li>
    <li>Three.js for 3D rendering and interaction</li>
    <li>GLTFLoader for model integration</li>
    <li>Bootstrap 5 for layout and responsiveness</li>
    <li>PHP MVC Framework with SQLite database</li>
    <li>AJAX + JSON for asynchronous data fetching</li>
  </ul>

  <h2>3D Models and Interactivity</h2>
  <p>The application includes five models: two versions of Coca-Cola, two for Dr Pepper, and one for Sprite. Users can rotate, animate, switch materials (gloss/matte), change cameras, and toggle lighting via a responsive control panel. All models are dynamically loaded and efficiently managed using a single rendering context with swapping logic to optimise performance.</p>

  <h2>Design Rationale</h2>
  <p>The layout follows a fluid, responsive grid using Bootstrap. A modern sans-serif font and brand-inspired colour scheme were selected to align with Coca-Cola's identity. Cards and sections are clearly delineated for ease of navigation. Dark mode was implemented to improve usability and accessibility in low-light environments.</p>

  <h2>Accessibility Considerations</h2>
  <ul>
    <li>Dark mode toggle improves contrast for low-vision users</li>
    <li>Semantic HTML5 structure used for better screen reader compatibility</li>
    <li>All buttons and inputs are keyboard-accessible and properly labelled</li>
    <li>Text and background colours tested for sufficient contrast</li>
  </ul>

  <h2>Testing and User Feedback</h2>
  <p>Several forms of testing were used during development:</p>
  <ul>
    <li><strong>Functional Testing:</strong> All buttons and features were tested on desktop and mobile to ensure model switching, animation triggers, and sound playback worked correctly.</li>
    <li><strong>Responsiveness:</strong> The app was tested using Chrome DevTools and physical devices (iPhone 16, Apple tablet). Adjustments were made for canvas scaling, card overflow, and dropdown behaviour.</li>
    <li><strong>User Feedback:</strong>  </li>
    <li><strong>Browser Testing:</strong> Tested on Chrome, Firefox, and Edge to ensure cross-browser compatibility.</li>
    <li><strong>Accessibility Checks:</strong> Keyboard navigation tested with Tab key; contrast verified with [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)</li>
  </ul>

  <h2>Deeper Understanding and Technical Extensions</h2>
  <p>The application goes significantly beyond the lab tutorials by implementing:</p>
  <ul>
    <li>A fully structured MVC pattern with PHP and SQLite backend</li>
    <li>Dynamic data and gallery loading using AJAX and JSON</li>
    <li>Scene and camera management with support for orthographic and perspective views</li>
    <li>Material and lighting manipulation via GUI and button inputs</li>
    <li>Dark mode, animated gallery image load-in, and dynamic 3D model swapping</li>
  </ul>

  <h2>Links and Resources</h2>
  <ul>
    <li><strong>GitHub Codebase:</strong> <a href="https://github.com/charlottem7/Web-3D">https://github.com/yourusername/3dapp-code</a></li>
    <li><strong>Credits:</strong> All third-party libraries and images are cited in the References section of this site.</li>
  </ul>
  <h2>References and Credits</h2>

  <h4>Libraries and Frameworks</h4>
  <ul>
    <li>Three.js – <a href="https://threejs.org/" target="_blank">https://threejs.org/</a></li>
    <li>Bootstrap 5 – <a href="https://getbootstrap.com/" target="_blank">https://getbootstrap.com/</a></li>
    <li>jQuery – <a href="https://jquery.com/" target="_blank">https://jquery.com/</a></li>
    <li>GLTFLoader from Three.js</li>
  </ul>

  <h4>Textures and Media</h4>
  <ul>
    <li>Coca-Cola branding textures – self-created using licensed source images for educational use</li>
    <li>Gallery images – rendered in Blender using self-created 3D models</li>
    <li>Home and gallery videos – created by author using Blender and royalty-free background</li>
    <li>Audio – <a href="https://freesound.org/" target="_blank">Freesound.org</a>, attribution where required</li>
  </ul>

  <h4>Tutorials / Code References</h4>
  <ul>
    <li>Three.js documentation – <a href="https://threejs.org/docs/" target="_blank">https://threejs.org/docs/</a></li>
    <li>Dan Creed & Imran Khan, Mobile 3D Labs (University of Sussex)</li>
    <li>GLTF animation and model switching – adapted from examples on <a href="https://threejs.org/examples/" target="_blank">Three.js examples</a></li>
  </ul>




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