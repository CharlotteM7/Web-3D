let scene,
  camera,
  renderer,
  clock,
  mixer,
  actions = [],
  mode,
  isWireframe = false,
  params,
  lights,
  loadedModel,
  secondModelMixer,
  secondModelActions = [],
  sound,
  secondSound,
  loader,
  controls,
  firstModelPath,
  secondModelPath,
  currentCanvas,
  currentModelIndex = 0;

let count = 0;
let models = [];

const loadedModels = {};
loader = new THREE.GLTFLoader();
loadedModel = null;

// Fetch drink data
async function fetchDrinkData(brand) {
  try {
    const resp = await fetch(`index.php?route=apiGetDrink&brand=${brand}`);
    return await resp.json();
  } catch (err) {
    console.error("Error fetching details for", brand, err);
    return {};
  }
}

// Handle brand switching
async function swapContent(id) {
  // Remember which brand is active
  currentBrandId = id;

  // Show/hide the correct content panel
  document.querySelectorAll(".content").forEach((sec) => {
    const active = sec.id === id;
    sec.classList.toggle("active", active);
    sec.style.display = active ? "block" : "none";
  });

  if (id === "gallerySection") {
    ["coke", "sprite", "pepper"].forEach(loadDrinkGallery);
  }

  // Only proceed for drink panels
  if (!["coke", "sprite", "pepper"].includes(id)) return;

  // Fetch the drink data
  const data = await fetchDrinkData(id);
  if (!data.modelPath) {
    console.warn("No data for", id);
    return;
  }

  // Build models array and reset index
  models = [data.modelPath, data.secondModelPath].filter(Boolean);
  currentModelIndex = 0;

  // Set up Three.js viewer for this panel
  const container = document.querySelector(`#${id} canvas`);
  const guiCt = document.querySelector(`#${id} #gui-container`);
  setupViewer(container, guiCt);

  // Load first model, sounds, and gallery
  loadModel(models[currentModelIndex]);
  setupSounds(data);

  // Grab all controls for this brand
  const animateBtn = document.getElementById(`btn-${id}`);
  const rotateBtn = document.getElementById(`Rotate-${id}`);
  const wireframeBtn = document.getElementById(`toggleWireframe-${id}`);
  const camFrontBtn = document.getElementById(`cam-front-${id}`);
  const camSideBtn = document.getElementById(`cam-side-${id}`);
  const camTopBtn = document.getElementById(`cam-top-${id}`);
  const camOrthoBtn = document.getElementById(`cam-ortho-${id}`);
  const lightToggleBtn = document.getElementById(`light-toggle-${id}`);
  const lightColorIn = document.getElementById(`light-color-${id}`);
  const lightIntRange = document.getElementById(`light-int-${id}`);
  const glossBtn = document.getElementById(`mat-gloss-${id}`);
  const matteBtn = document.getElementById(`mat-matte-${id}`);
  const prevBtn = document.getElementById(`prev-model-${id}`);
  const nextBtn = document.getElementById(`next-model-${id}`);

  // Animate
  animateBtn?.addEventListener("click", () => {
    if (actions.length) {
      actions.forEach((action) => {
        action.reset().setLoop(THREE.LoopOnce, 1).clampWhenFinished = true;
        action.play();
      });
      if (currentModelIndex === 0 && sound) sound.play();
      if (currentModelIndex === 1 && secondSound) secondSound.play();
    }
  });

  // Rotate
  rotateBtn?.addEventListener("click", () => {
    if (loadedModel) {
      loadedModel.rotateOnAxis(new THREE.Vector3(0, 1, 0), Math.PI / 8);
    }
  });

  // Wireframe toggle
  wireframeBtn?.addEventListener("click", () => {
    isWireframe = !isWireframe;
    scene.traverse((obj) => {
      if (obj.isMesh) obj.material.wireframe = isWireframe;
    });
  });

  // Model switch toggle
  prevBtn?.addEventListener("click", () => {
    if (models.length < 2) return;
    currentModelIndex = (currentModelIndex - 1 + models.length) % models.length;
    loadModel(models[currentModelIndex]);
  });

  nextBtn?.addEventListener("click", () => {
    if (models.length < 2) return;
    currentModelIndex = (currentModelIndex + 1) % models.length;
    loadModel(models[currentModelIndex]);
  });

  // Camera presets
  camFrontBtn?.addEventListener("click", () => switchCamera("front"));
  camSideBtn?.addEventListener("click", () => switchCamera("side"));
  camTopBtn?.addEventListener("click", () => switchCamera("top"));
  camOrthoBtn?.addEventListener("click", () => switchCamera("ortho"));

  // Light controls
  lightToggleBtn?.addEventListener("click", () => {
    lights.spot.visible = !lights.spot.visible;
  });
  lightColorIn?.addEventListener("input", (e) => {
    lights.spot.color.set(e.target.value);
  });
  lightIntRange?.addEventListener("input", (e) => {
    lights.spot.intensity = parseFloat(e.target.value);
  });

  // Material swaps
  glossBtn?.addEventListener("click", () => {
    loadedModel.traverse((obj) => {
      if (obj.isMesh) obj.material.roughness = 0.1;
    });
  });
  matteBtn?.addEventListener("click", () => {
    loadedModel.traverse((obj) => {
      if (obj.isMesh) obj.material.roughness = 1.0;
    });
  });
}

$(function () {
  $.getJSON("index.php?route=apiGetBrands")
    .done((brands) => {
      const $menu = $("#drinkDropdown").empty();
      brands.forEach((b) => {
        $("<a>")
          .addClass("dropdown-item")
          .attr("href", "#")
          .text(b.charAt(0).toUpperCase() + b.slice(1))
          .on("click", (e) => {
            e.preventDefault();
            swapContent(b);
          })
          .appendTo($("<li>").appendTo($menu));
      });
    })
    .fail(() => console.error("Failed to load brand list"));
});

// Viewer Setup
function setupViewer(canvas, guiContainer) {
  clock = new THREE.Clock();
  scene = new THREE.Scene();
  scene.background = new THREE.Color(0xfaf0e6);

  camera = new THREE.PerspectiveCamera(
    60,
    canvas.clientWidth / canvas.clientHeight,
    0.1,
    1000
  );
  camera.position.set(-5, 25, 20);
  camera.add(new THREE.AudioListener());

  //Lights
  lights = {};
  lights.spot = new THREE.SpotLight();
  lights.spot.position.set(0, 20, 0);
  lights.spotHelper = new THREE.SpotLightHelper(lights.spot);
  scene.add(
    new THREE.HemisphereLight(0xffffbb, 0x080820, 4),
    lights.spot,
    lights.spotHelper
  );

  params = {
    spot: {
      enable: false,
      color: 0xffffff,
      distance: 20,
      angle: Math.PI / 2,
      penumbra: 0,
      helper: false,
      moving: false,
    },
  };

  const gui = new dat.GUI({ autoPlace: false });
  guiContainer.innerHTML = "";
  guiContainer.appendChild(gui.domElement);
  const spot = gui.addFolder("Spot");
  spot.open();
  spot.add(params.spot, "enable").onChange((v) => (lights.spot.visible = v));
  spot
    .addColor(params.spot, "color")
    .onChange((v) => (lights.spot.color = new THREE.Color(v)));
  spot
    .add(params.spot, "distance", 0, 20)
    .onChange((v) => (lights.spot.distance = v));
  spot
    .add(params.spot, "angle", 0.1, 6.28)
    .onChange((v) => (lights.spot.angle = v));
  spot
    .add(params.spot, "penumbra", 0, 1)
    .onChange((v) => (lights.spot.penumbra = v));
  spot
    .add(params.spot, "helper")
    .onChange((v) => (lights.spotHelper.visible = v));
  spot.add(params.spot, "moving");

  renderer = new THREE.WebGLRenderer({ canvas });
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);

  controls = new THREE.OrbitControls(camera, renderer.domElement);
  controls.target.set(0, 0, 0);
  controls.update();

  loader = new THREE.GLTFLoader();
  currentCanvas = canvas;

  animate();
}

// Model Loading
function loadModel(modelPath) {
  // 1) Remove any existing model instance
  if (loadedModel) {
    scene.remove(loadedModel);
    loadedModel = null;
  }

  // 2) If we’ve already loaded this brand, clone & reuse
  if (loadedModels[modelPath]) {
    const { scene: originalScene, animations } = loadedModels[modelPath];
    loadedModel = originalScene.clone(true);
    scene.add(loadedModel);

    // re-attach animations to the clone
    mixer = new THREE.AnimationMixer(loadedModel);
    actions = animations.map((clip) => mixer.clipAction(clip));
    return;
  }

  // 3) First time load: fetch the GLB, add to scene, and cache it
  loader.load(
    modelPath,

    // onLoad
    (gltf) => {
      const original = gltf.scene;

      // 1) Normalise scale & position
      original.scale.set(1, 1, 1);
      original.position.set(0, 0, 0);

      // 2) Compute its bounding box & sphere
      const box = new THREE.Box3().setFromObject(original);
      const size = box.getSize(new THREE.Vector3());
      const center = box.getCenter(new THREE.Vector3());
      const sphere = box.getBoundingSphere(new THREE.Sphere());

      console.log(`Bounds:`, size, `Center:`, center, `Radius:`, sphere.radius);

      // 3) Recenter the model so its geometric centre sits at (0,0,0)
      original.position.sub(center);

      // 4) Figure out a camera Z distance to frame the sphere
      const fov = camera.fov * (Math.PI / 180);
      const camZ = Math.abs(sphere.radius / Math.sin(fov / 2)) * 1.2;

      // 5) Move the camera and point it at origin
      camera.position.set(0, 0, camZ);
      camera.lookAt(0, 0, 0);

      // 6) Update OrbitControls to target the origin
      controls.target.set(0, 0, 0);
      controls.update();

      // 7) Finally add to scene & cache as before
      scene.add(original);
      loadedModels[modelPath] = {
        scene: original,
        animations: gltf.animations,
      };
      loadedModel = original;

      mixer = new THREE.AnimationMixer(loadedModel);
      actions = gltf.animations.map((clip) => mixer.clipAction(clip));
    },

    // onProgress
    (xhr) => {
      const pct = ((xhr.loaded / xhr.total) * 100).toFixed(0);
      console.log(`Loading ${modelPath}: ${pct}%`);
    },
    (err) => console.error(`Error loading ${modelPath}`, err)
  );
}

// Animation loop
function animate() {
  requestAnimationFrame(animate);
  if (mixer) mixer.update(clock.getDelta());
  if (params.spot.moving) {
    const delta = Math.sin(clock.getElapsedTime()) * 5;
    lights.spot.position.x = delta;
    lights.spotHelper.update();
  }
  renderer.render(scene, camera);
}

// Camera presets (keep these at top-level too)
const cameraPresets = {
  front: {
    pos: new THREE.Vector3(0, 0, 20),
    look: new THREE.Vector3(0, 0, 0),
    type: "persp",
  },
  side: {
    pos: new THREE.Vector3(20, 0, 0),
    look: new THREE.Vector3(0, 0, 0),
    type: "persp",
  },
  top: {
    pos: new THREE.Vector3(0, 20, 0),
    look: new THREE.Vector3(0, 0, 0),
    type: "persp",
  },
  ortho: {
    pos: new THREE.Vector3(50, 50, 50),
    look: new THREE.Vector3(0, 0, 0),
    type: "ortho",
  },
};

function switchCamera(view) {
  const p = cameraPresets[view];
  if (!p) return;

  // 1) Rebuild the camera based on preset type
  if (p.type === "ortho") {
    camera = new THREE.OrthographicCamera(
      currentCanvas.clientWidth / -10,
      currentCanvas.clientWidth / 10,
      currentCanvas.clientHeight / 10,
      currentCanvas.clientHeight / -10,
      1,
      1000
    );
  } else {
    camera = new THREE.PerspectiveCamera(
      60,
      currentCanvas.clientWidth / currentCanvas.clientHeight,
      0.1,
      1000
    );
  }

  // 2) Position & aim at origin
  camera.position.copy(p.pos);
  camera.lookAt(p.look);

  // 3) Resize the renderer’s output to match the canvas
  renderer.setSize(currentCanvas.clientWidth, currentCanvas.clientHeight);

  // 4) Tear down the old controls and hook up new ones
  if (controls.dispose) controls.dispose(); // free old listeners
  controls = new THREE.OrbitControls(camera, renderer.domElement);
  controls.target.copy(p.look);
  controls.update();
}

// Sounds
function setupSounds(data) {
  const audioLoader = new THREE.AudioLoader();
  sound = new THREE.Audio(camera.children[0]);
  secondSound = new THREE.Audio(camera.children[0]);

  if (data.soundPath) {
    audioLoader.load(data.soundPath, (buffer) => {
      sound.setBuffer(buffer).setLoop(false).setVolume(1.0);
    });
  }
  if (data.secondSoundPath) {
    audioLoader.load(data.secondSoundPath, (buffer) => {
      secondSound.setBuffer(buffer).setLoop(false).setVolume(1.0);
    });
  }
}

// Wireframe toggle
function toggleWireframe(enable) {
  scene.traverse((obj) => {
    if (obj.isMesh) obj.material.wireframe = enable;
  });
}

// Button Listeners
document.getElementById("prev-model")?.addEventListener("click", () => {
  if (models.length < 2) return;
  currentModelIndex = (currentModelIndex - 1 + models.length) % models.length;
  loadModel(models[currentModelIndex]);
});

document.getElementById("next-model")?.addEventListener("click", () => {
  if (models.length < 2) return;
  currentModelIndex = (currentModelIndex + 1) % models.length;
  loadModel(models[currentModelIndex]);
});

document.getElementById("themeToggle")?.addEventListener("click", () => {
  const body = document.body;
  const nav = document.querySelector(".navbar");
  const toggle = document.getElementById("themeToggle");

  body.classList.toggle("dark-mode");

  if (nav) {
    nav.classList.toggle("bg-dark", !body.classList.contains("dark-mode"));
    nav.classList.toggle("bg-primary", body.classList.contains("dark-mode"));
  }

  if (toggle) {
    toggle.textContent = body.classList.contains("dark-mode")
      ? "Light Mode"
      : "Dark Mode";
  }
});

document.querySelectorAll(".toggle-notes-btn").forEach((btn) => {
  btn.addEventListener("click", () => {
    const expanded = btn.getAttribute("aria-expanded") === "true";
    btn.setAttribute("aria-expanded", !expanded);
  });
});

document.addEventListener("click", function (e) {
  const img = e.target.closest(".gallery-thumb");
  if (!img) return;

  const group = img.dataset.group;
  const index = parseInt(img.dataset.index, 10);
  const images = groupedImages[group];

  const inner = document.getElementById("carousel-inner");
  inner.innerHTML = "";

  images.forEach((src, i) => {
    const item = document.createElement("div");
    item.className = "carousel-item" + (i === index ? " active" : "");
    item.innerHTML = `<img src="${src}" class="d-block w-100" alt="${group} image ${i + 1}">`;
    inner.appendChild(item);
  });
});
