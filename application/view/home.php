<!--
  Project: Mobile Web 3D App
  Page: Home View (loaded via MVC controller)
  Description: Sets up the initial layout including header, libraries, styles, and main navigation
  Author: Charlotte Mackay

-->

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
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top" role="navigation" aria-label="Main navigation">
    <div class="container">
      <div class="navbar-brand text-white d-flex flex-column align-items-start">
        <span class="brand-title">My Coca-Cola Brand</span>
        <small class="brand-tagline">Interactive 3D Product Showcase</small>
      </div>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#" onclick="swapContent('home')">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#" onclick="swapContent('about')">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#" onclick="swapContent('gallerySection')">Gallery</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="drinksDropdown" role="button" data-bs-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false" aria-controls="drinksDropdownMenu">Drinks</a>
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
              <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title">Coca Cola</h5>
                <p class="card-text">Classic taste, classic style. Now in 3D!</p>
                <a href="#" class="btn btn-outline-primary" onclick="swapContent('coke')">View 3D</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
              <img src="/assets/images/sprite.jpg" class="card-img-top" alt="Sprite">
              <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title">Sprite</h5>
                <p class="card-text">Lemon-lime refreshment, reimagined.</p>
                <a href="#" class="btn btn-outline-primary" onclick="swapContent('sprite')">View 3D</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
              <img src="/assets/images/dr_pepper.jpg" class="card-img-top" alt="Dr Pepper">
              <div class="card-body d-flex flex-column justify-content-between">
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
  <!-- End of Hero Section -->
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
                  <button id="btn-coke" class="btn btn-secondary m-2">Animate</button>
                  <button id="toggleWireframe-coke" class="btn btn-secondary m-2">Toggle Wireframe</button>
                  <button id="Rotate-coke" class="btn btn-secondary m-2">Rotate</button>
                </div>
              </div>
              <div id="model-nav" class="arrow-controls mt-3">
                <button id="prev-model-coke">⬅️</button>
                <button id="next-model-coke">➡️</button>
              </div>
              <div class="control-panel mt-4">
                <!-- Camera Controls -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Camera Views</label>
                  <div class="btn-group flex-wrap">
                    <button id="cam-front-coke" class="btn btn-outline-primary">Front</button>
                    <button id="cam-side-coke" class="btn btn-outline-primary">Side</button>
                    <button id="cam-top-coke" class="btn btn-outline-primary">Top</button>
                    <button id="cam-ortho-coke" class="btn btn-outline-primary">Ortho</button>
                  </div>
                </div>
                <!-- Light Controls -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Lighting</label>
                  <div class="d-flex flex-wrap align-items-center gap-2">
                    <button id="light-toggle-coke" class="btn btn-outline-primary">Toggle Spot</button>
                    <input type="color" id="light-color-coke" title="Light Color">
                    <input type="range" id="light-coke" min="0" max="5" step="0.1" style="max-width: 150px;">
                  </div>
                </div>
                <!-- Material Controls -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Material Style</label>
                  <div class="btn-group">
                    <button id="mat-gloss-coke" class="btn btn-outline-primary">Glossy</button>
                    <button id="mat-matte-coke" class="btn btn-outline-primary">Matte</button>
                  </div>
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
                    The Coke can models were created in Blender using a cylinder base mesh, refined through extrusion
                    and scaling to form the top lip and base rim
                    Loop cuts were applied to create additional edge detail and to support smooth curvature around the
                    can's top and bottom.
                    An image texture was used for the can "label", with a UV map applied to ensure correct alignment.
                    The UV map was created by unwrapping the cylinder and adjusting the seams to match the label design.
                  </p>
                  <p>
                    Different animations were created for the two models, one to show the can being opened,
                    and another to show the can being crushed. This crush effect was achieved in Blender using the
                    sculpting tool to introduce bends,
                    folds, and creases that reflect a crumpled aluminium surface.
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
                  <button id="btn-sprite" class="btn btn-secondary m-2">Animate</button>
                  <button id="toggleWireframe-sprite" class="btn btn-secondary m-2">Toggle Wireframe</button>
                  <button id="Rotate-sprite" class="btn btn-secondary m-2">Rotate</button>
                </div>
              </div>
              <div class="control-panel mt-4">
                <!-- Camera Controls -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Camera Views</label>
                  <div class="btn-group flex-wrap">
                    <button id="cam-front-sprite" class="btn btn-outline-primary">Front</button>
                    <button id="cam-side-sprite" class="btn btn-outline-primary">Side</button>
                    <button id="cam-top-sprite" class="btn btn-outline-primary">Top</button>
                    <button id="cam-ortho-sprite" class="btn btn-outline-primary">Ortho</button>
                  </div>
                </div>
                <!-- Light Controls -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Lighting</label>
                  <div class="d-flex flex-wrap align-items-center gap-2">
                    <button id="light-toggle-sprite" class="btn btn-outline-primary">Toggle Spot</button>
                    <input type="color" id="light-color-sprite" title="Light Color">
                    <input type="range" id="light-int-sprite" min="0" max="5" step="0.1" style="max-width: 150px;">
                  </div>
                </div>
                <!-- Material Controls -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Material Style</label>
                  <div class="btn-group">
                    <button id="mat-gloss-sprite" class="btn btn-outline-primary">Glossy</button>
                    <button id="mat-matte-sprite" class="btn btn-outline-primary">Matte</button>
                  </div>
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
                    The Sprite can model was created in a similar manner to the Coke can, using a cylinder base mesh.
                    The ice cubes were modelled using a a simple cube
                    primitive. To create a more realistic, irregular ice-like shape, the ice cube material was created
                    using Blender’s Principled BSDF shader with a
                    physically based approach to simulate the translucent and rough surface of real ice. A combination
                    of <strong>Noise Textures</strong> and <strong>Color Ramps</strong>
                    was used to modulate both the alpha transparency and bump mapping. The <strong>Transmission</strong>
                    value was set to 1.0 to enable full light passage,
                    and the <strong>Transmission Roughness</strong> was adjusted to diffuse the transmitted light,
                    mimicking the cloudy look of ice.
                  </p>
                  <p>
                    The ice cubes were then animated to fall around the can using Blender's transform keyframes and
                    animation tools. To manage multiple actions cleanly
                    and ensure the correct timing and structure were preserved during export, the animation data was
                    pushed to Blender’s <strong>Nonlinear Animation (NLA)
                      editor</strong>. This provided a modular and non-destructive way to control each animated element
                    within the scene, and helped ensure compatibility
                    with the web-based playback environment.
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
                  <button id="btn-pepper" class="btn btn-secondary m-2">Animate</button>
                  <button id="toggleWireframe-pepper" class="btn btn-secondary m-2">Toggle Wireframe</button>
                  <button id="Rotate-pepper" class="btn btn-secondary m-2">Rotate</button>
                </div>
              </div>
              <div id="model-nav" class="arrow-controls mt-3">
                <button id="prev-model-pepper">⬅️</button>
                <button id="next-model-pepper">➡️</button>
              </div>
              <div class="control-panel mt-4">
                <!-- Camera Controls -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Camera Views</label>
                  <div class="btn-group flex-wrap">
                    <button id="cam-front-pepper" class="btn btn-outline-primary">Front</button>
                    <button id="cam-side-pepper" class="btn btn-outline-primary">Side</button>
                    <button id="cam-top-pepper" class="btn btn-outline-primary">Top</button>
                    <button id="cam-ortho-pepper" class="btn btn-outline-primary">Ortho</button>
                  </div>
                </div>
                <!-- Light Controls -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Lighting</label>
                  <div class="d-flex flex-wrap align-items-center gap-2">
                    <button id="light-toggle-pepper" class="btn btn-outline-primary">Toggle Spot</button>
                    <input type="color" id="light-color-pepper" title="Light Color">
                    <input type="range" id="light-int-pepper" min="0" max="5" step="0.1" style="max-width: 150px;">
                  </div>
                </div>
                <!-- Material Controls -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Material Style</label>
                  <div class="btn-group">
                    <button id="mat-gloss-pepper" class="btn btn-outline-primary">Glossy</button>
                    <button id="mat-matte-pepper" class="btn btn-outline-primary">Matte</button>
                  </div>
                </div>
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
                    This Dr Pepper can model was created using a cylinder base mesh, similar to the Coke and Sprite
                    models, but with the addition of condensation droplets generated using Blender’s <strong>Geometry
                      Nodes</strong> system. A high-density set of randomised points was distributed across the can’s
                    surface using the <strong>Distribute Points on Faces</strong> node. Each point served as an instance
                    location for a base droplet mesh, originally created as a UV Sphere and stretched vertically via the
                    <strong>Transform Geometry</strong> node to achieve a natural droplet shape. A <strong>Random
                      Value</strong> node was used to introduce slight variations in droplet scale, helping to avoid
                    uniformity and enhance realism.
                  </p>
                  <p>
                    The bottle model also began as a cylinder and was extruded and scaled to form the neck, top, and
                    “feet” of the bottle. <strong>Subdivision Surface</strong> modifiers were applied to smooth edges
                    and create a more organic shape appropriate for a plastic bottle.
                  </p>
                  <p>
                    Each model features a separate animation. In the first, the can shrinks and disappears while the
                    bottle grows into view. In the second, the can is positioned horizontally and animated to roll
                    towards the camera. Both animations were implemented using transform keyframes within Blender.
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
    <!-- Hero Section -->
    <section class="galleryhero-section position-relative overflow-hidden">
      <div class="galleryhero-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
      <div id="galleryheroContent" class="galleryhero-content position-relative text-center text-white px-3"
        style="z-index:1;">
        <h1 class="display-4 fw-bold">Image Gallery</h1>
        <p class="lead">View all of our models</p>
      </div>
      <video id="galleryheroVideo"
        class="galleryhero-video position-absolute top-0 start-0 w-100 h-100 object-fit-cover" autoplay loop muted
        playsinline>
        <source src="/assets/video/spritepour.mp4" type="video/mp4" />
        Your browser does not support the video tag.
      </video>
    </section>
    <!-- Coke Gallery -->
    <div id="gallery-coke" class="mb-5">
      <h2 class="text-center">Coke</h2>
      <div class="row justify-content-center" id="cokeGallery"></div>
    </div>
    <!-- Sprite Gallery -->
    <div id="gallery-sprite" class="mb-5">
      <h2 class="text-center">Sprite</h2>
      <div class="row justify-content-center" id="spriteGallery"></div>
    </div>
    <!-- Dr Pepper Gallery -->
    <div id="gallery-pepper" class="mb-5">
      <h2 class="text-center">Dr Pepper</h2>
      <div class="row justify-content-center" id="pepperGallery"></div>
    </div>
  </section>
  <!-- Modal Carousel -->
  <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true" aria-labelledby="galleryModalLabel"
    role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content bg-dark border-0">
        <div class="modal-body p-0">
          <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" id="carousel-inner"></div>
            <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev"
              aria-label="Previous image">
              <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next"
              aria-label="Next image">
              <span class="carousel-control-next-icon"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- About Section -->
  <div id="about" class="content">
    <section class="container mt-5">
      <h1>About This 3D Web Application</h1>

      <h2>Project Overview</h2>
      <p>This interactive 3D Web App showcases three Coca-Cola brand products: Coca-Cola, Sprite, and Dr Pepper. Each
        brand includes detailed 3D models that users can manipulate in real-time using Three.js. The application is
        built using a modular MVC framework with PHP, SQLite, AJAX, and JSON, allowing dynamic interaction and media
        retrieval.</p>

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
      <p>The application includes five models: two versions of Coca-Cola, two for Dr Pepper, and one for Sprite. Users
        can rotate, animate, switch materials (gloss/matte), change cameras, and toggle lighting via a responsive
        control panel. All models are dynamically loaded and efficiently managed using a single rendering context with
        swapping logic to optimise performance.</p>

      <h2>Design Rationale</h2>
      <p>The layout follows a fluid, responsive grid using Bootstrap. A modern sans-serif font and brand-inspired colour
        scheme were selected to align with Coca-Cola's identity. Cards and sections are clearly delineated for ease of
        navigation. Dark mode was implemented to improve usability and accessibility in low-light environments.</p>

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
        <li><strong>Functional Testing:</strong> All buttons and features were tested on desktop and mobile to ensure
          model switching, animation triggers, and sound playback worked correctly.</li>
        <li><strong>Responsiveness:</strong> The app was tested using Chrome DevTools and physical devices (iPhone 16,
          Apple tablet). Adjustments were made for canvas scaling, card overflow, and dropdown behaviour.</li>
        <li><strong>User Feedback:</strong> </li>
        <li><strong>Browser Testing:</strong> Tested on Chrome, Firefox, and Edge to ensure cross-browser compatibility.
        </li>
        <li><strong>Accessibility Checks:</strong> Dark mode option, ARIA labels and contrast verified with
          <a href="https://webaim.org/resources/contrastchecker" target="_blank">WebAIM Contrast Checker</a>
        </li>
      </ul>

      <h2>Deeper Understanding and Technical Extensions</h2>
      <p>The application goes significantly beyond the lab tutorials by implementing:</p>
      <ul>
        <li>A fully structured MVC pattern with PHP and SQLite backend</li>
        <li>Dynamic data and gallery loading using AJAX and JSON</li>
        <li>Scene and camera management with support for orthographic and perspective views</li>
        <li>Material and lighting manipulation via GUI and button inputs</li>
      </ul>

      <h2>Links and Resources</h2>
      <ul>
        <li><strong>GitHub Codebase:</strong> <a href="https://github.com/charlottem7/Web-3D"
            target="_blank">https://github.com/charlottem7/Web-3D</a></li>
        <li><strong>Onedrive:</strong> Link to onedrive</li>
      </ul>
      <h2>References and Credits</h2>

      <h4>Libraries and Frameworks</h4>
      <ul>
        <li>Three.js – <a href="https://threejs.org/" target="_blank">https://threejs.org/</a></li>
        <li>Bootstrap 5 – <a href="https://getbootstrap.com/" target="_blank">https://getbootstrap.com/</a></li>
        <li>jQuery – <a href="https://jquery.com/" target="_blank">https://jquery.com/</a></li>
        <li>GLTFLoader from Three.js <a href="https://threejs.org/docs/" target="_blank"></a></li>
      </ul>

      <h4>Textures and Media</h4>
      <ul>
        <li>Coca-Cola, Sprite, and Dr Pepper branding textures – created using publicly available imagery sourced via
          Google Image Search.
          All assets were used solely for educational purposes under fair use guidelines, and no assets were used for
          commercial gain.</li>
        <li>Gallery images – rendered in Blender using self-created 3D models adapted from referenced below YouTube
          tutorials</li>
        <li>Home and gallery videos – created by using Blender and adapted from referenced below YouTube tutorials</li>
        <li>Audio – <a href="https://opengameart.org/" target="_blank">opengameart.org</a></li>
      </ul>

      <h4>Tutorials / Code References</h4>
      <ul>
        <li>Three.js documentation – <a href="https://threejs.org/docs/" target="_blank">https://threejs.org/docs/</a>
        </li>
        <li>Dan Creed & Imran Khan, Mobile 3D Labs (University of Sussex) module material</li>
        <li>Modal carousel - <a href= "https://www.w3schools.com/howto/howto_css_modals.asp" target="_blank">W3 Schools</a></li>
        <li>Condensation effect on can model – <a href="https://www.youtube.com/watch?v=9ybdZDSOEsI&t=1238s"
            target="_blank">YouTube-
            Cas Raven 3D</a>
        <li>Water splash on home page video – <a href="https://www.youtube.com/watch?v=IJTIzna5TBs"
            target="_blank">YouTube-Sost cgTeCH</a>
        <li>Water pour animation on gallary page video – <a href="https://www.youtube.com/watch?v=hqz2WRTNQ5U"
            target="_blank">YouTube-Malin.mp4</a>
        <li>Ice cubes in Sprite model – <a href="https://www.youtube.com/watch?v=uCHm70ElHbM"
            target="_blank">YouTube-Malin.mp4</a>

      </ul>

      <h4>Statement of Originally</h4>
      <p>This project is my own original work, created for the Mobile 3D Applications module at the University of
        Sussex. All code, models, and media are either self-created or properly attributed to their respective sources.
        The project was developed independently, with no external assistance beyond the provided course materials and
        resources cited above.</p>
    </section>
  </div>

    <!-- Dark Mode Button -->
  <div class="text-center my-4">
    <button id="themeToggle" class="btn btn-outline-success">Dark Mode</button>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-light py-4">
    <div class="container text-center">
      <div id="contact">
        <p>Created by Charlotte Mackay for the Mobile 3D Applications module at the University of Sussex.</p>
        <div>
          <a href="https://github.com/charlottem7/Web-3D" target="_blank">
            <i class="fab fa-github fa-lg"></i>
          </a>
          <a href="mailto:cm2013@sussex.ac.uk" class="ms-3">
            <i class="fas fa-envelope fa-lg"></i>
          </a>
        </div>   <br>
        <p>&copy; 2025 Mobile Web 3D Application. All Rights Reserved.</p>

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