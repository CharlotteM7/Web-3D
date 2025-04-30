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

const cameraPresets = {
  front: { pos: new THREE.Vector3(  0,  0, 20), look: new THREE.Vector3(0,0,0), type: 'persp' },
  side:  { pos: new THREE.Vector3( 20,  0,  0), look: new THREE.Vector3(0,0,0), type: 'persp' },
  top:   { pos: new THREE.Vector3(  0, 20,  0), look: new THREE.Vector3(0,0,0), type: 'persp' },
  ortho: { pos: new THREE.Vector3( 50, 50, 50), look: new THREE.Vector3(0,0,0), type: 'ortho' },
};

// Handle brand switching
function swapContent(id) {
  currentBrandId = id;

  document.querySelectorAll(".content").forEach((sec) => {
    sec.classList.toggle("active", sec.id === id);
    sec.style.display = sec.id === id ? "block" : "none";
  });

  if (["coke", "sprite", "pepper"].includes(id)) {
    fetchDrinkData(id).then((data) => {
      if (!data.modelPath) return console.warn("No data for", id);

      models = [data.modelPath, data.secondModelPath].filter(Boolean);
      currentModelIndex = 0;

      const container = document.querySelector(`#${id} canvas`);
      const guiCt = document.querySelector(`#${id} #gui-container`);

      setupViewer(container, guiCt);
      loadModel(models[currentModelIndex]);
      setupSounds(data);
      loadGallery(id);

      // Hook buttons specific to this drink
      const animateBtn = document.getElementById(`btn-${id}`);
      const rotateBtn = document.getElementById(`Rotate-${id}`);
      const wireframeBtn = document.getElementById(`toggleWireframe-${id}`);

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

      rotateBtn?.addEventListener("click", () => {
        if (loadedModel) {
          loadedModel.rotateOnAxis(new THREE.Vector3(0, 1, 0), Math.PI / 8);
        }
      });

      wireframeBtn?.addEventListener("click", () => {
        isWireframe = !isWireframe;
        scene.traverse((obj) => {
          if (obj.isMesh) obj.material.wireframe = isWireframe;
        });
      });
    });
  }
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
      scene.add(original);

      // cache the original scene and its animations
      loadedModels[modelPath] = {
        scene: original,
        animations: gltf.animations,
      };

      // track it for later removal
      loadedModel = original;

      // set up the mixer & actions
      mixer = new THREE.AnimationMixer(loadedModel);
      actions = gltf.animations.map((clip) => mixer.clipAction(clip));
    },

    // onProgress
    xhr => {
      const pct = ((xhr.loaded/xhr.total)*100).toFixed(0);
      console.log(`Loading ${modelPath}: ${pct}%`);
    },
    err => console.error(`Error loading ${modelPath}`, err)
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

// switch camera
function switchCamera(view) {
  const p = cameraPresets[view];
  if (!p) return;

  // 1) Recreate the camera on top of the existing one
  if (p.type === 'ortho') {
    camera = new THREE.OrthographicCamera(
      currentCanvas.clientWidth  / -10, 
      currentCanvas.clientWidth  /  10,
      currentCanvas.clientHeight /  10,
      currentCanvas.clientHeight / -10,
      1, 1000
    );
  } else {
    camera = new THREE.PerspectiveCamera(
      60,
      currentCanvas.clientWidth / currentCanvas.clientHeight,
      0.1,
      1000
    );
  }

  // 2) Position & aim it
  camera.position.copy(p.pos);
  camera.lookAt(p.look);

  // 3) Tell the renderer in case the aspect or frustum changed
  renderer.setSize(
    currentCanvas.clientWidth, 
    currentCanvas.clientHeight
  );

  // 4) Tear down the old controls and build new ones for this camera
  controls.dispose?.();                             // if your version supports dispose()
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
  currentModelIndex =
    (currentModelIndex - 1 + models.length) % models.length;
  loadModel(models[currentModelIndex]);
});

document.getElementById("next-model")?.addEventListener("click", () => {
  if (models.length < 2) return;
  currentModelIndex =
    (currentModelIndex + 1) % models.length;
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

// Camera buttons
document.getElementById('cam-front').addEventListener('click', () => switchCamera('front'));
document.getElementById('cam-side' ).addEventListener('click', () => switchCamera('side'));
document.getElementById('cam-top'  ).addEventListener('click', () => switchCamera('top'));
document.getElementById('cam-ortho').addEventListener('click', () => switchCamera('ortho'));

// Light buttons
document.getElementById('light-toggle').addEventListener('click', () => {
  lights.spot.visible = !lights.spot.visible;
});

document.getElementById('light-color').addEventListener('input', e => {
  lights.spot.color.set(e.target.value);
});

document.getElementById('light-int').addEventListener('input', e => {
  lights.spot.intensity = parseFloat(e.target.value);
});

//Texture buttons
document.getElementById('mat-gloss').addEventListener('click', () => {
  loadedModel.traverse(obj => {
    if (obj.isMesh) obj.material.roughness = 0.1;
  });
});
document.getElementById('mat-matte').addEventListener('click', () => {
  loadedModel.traverse(obj => {
    if (obj.isMesh) obj.material.roughness = 1.0;
  });
});



