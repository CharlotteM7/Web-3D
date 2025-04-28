let scene,
  camera,
  renderer,
  clock,
  mixer,
  actions = [],
  mode,
  isWireframe = false,
  params,
  lights;
  let loadedModel;
  let secondModelMixer,
    secondModelActions = [];
  let sound, secondSound;
  let loader;
  let firstModelPath, secondModelPath;

init();

async function fetchDrinkData() {
  try {
    const response = await fetch('models.json');
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error fetching models.json:', error);
  }
}


function init() {
  const assetPath = "./";

  clock = new THREE.Clock();

  // Creat the scene
  scene = new THREE.Scene();
  scene.background = new THREE.Color(0xFAF0E6);

  // Set up camera
  camera = new THREE.PerspectiveCamera(
    60,
    window.innerWidth / window.innerHeight,
    0.1,
    1000
  );
  camera.position.set(-5, 25, 20);

  // Set up audio
  const listener = new THREE.AudioListener();
  camera.add(listener);

  // Add lighting
  const ambient = new THREE.HemisphereLight(0xffffbb, 0x080820, 4);
  scene.add(ambient);

  lights = {};
  lights.spot = new THREE.SpotLight();
  lights.spot.visible = true;
  lights.spot.position.set(0, 20, 0);
  lights.spotHelper = new THREE.SpotLightHelper(lights.spot);
  lights.spotHelper.visible = false;
  scene.add(lights.spotHelper);
  scene.add(lights.spot);

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
  const guiContainer = document.getElementById("gui-container");
  guiContainer.appendChild(gui.domElement);
  guiContainer.setAttribute("id", "gui-container");

  
  const spot = gui.addFolder("Spot");
  spot.open();
  spot.add(params.spot, "enable").onChange((value) => { lights.spot.visible = value; });
  spot.addColor(params.spot, "color").onChange((value) => (lights.spot.color = new THREE.Color(value)));
  spot.add(params.spot, "distance").min(0).max(20).onChange((value) => (lights.spot.distance = value));
  spot.add(params.spot, "angle").min(0.1).max(6.28).onChange((value) => (lights.spot.angle = value));
  spot.add(params.spot, "penumbra").min(0).max(1).onChange((value) => (lights.spot.penumbra = value));
  spot.add(params.spot, "helper").onChange((value) => (lights.spotHelper.visible = value));
  spot.add(params.spot, "moving");

  //Set up renderer
  const canvas = document.getElementById("threeContainer");
  renderer = new THREE.WebGLRenderer({ canvas: canvas });
  renderer.setPixelRatio(window.devicePixelRatio);
  resize();

  // Add OrbitControls
  const controls = new THREE.OrbitControls(camera, renderer.domElement);
  controls.target.set(1, 2, 0);
  controls.update();

  loader = new THREE.GLTFLoader();

  // Load initial model dynamically
  fetchDrinkData().then((data) => {
    const page = window.location.pathname;
    let drink;
    if (page.includes("sprite.html")) {
      drink = "sprite";
    } else if (page.includes("drpepper.html")) {
      drink = "drpepper";
    } else {
      drink = "coke";
    }

    if (data && data[drink]) {
      firstModelPath = data[drink].modelPath;
      secondModelPath = data[drink].secondModelPath;
      loadModel(firstModelPath);
      setupSounds(data[drink]);

      if (drink === "coke") {
        createArrowButtons();
      }
    }
  });

  const btn = document.getElementById("btn");
  if (btn) {
    btn.addEventListener("click", function () {
      if (actions.length > 0) {
        actions.forEach((action) => {
          action.timeScale = 1;
          action.reset();
          action.setLoop(THREE.LoopOnce, 1);
          action.clampWhenFinished = true;
          action.play();
        });
        if (currentModelIndex === 0) {
          if (sound && sound.isPlaying) sound.stop();
          if (sound) sound.play();
        } else {
          if (secondSound && secondSound.isPlaying) secondSound.stop();
          if (secondSound) secondSound.play();
        }
        
      }
    });
  }

  const wireframeBtn = document.getElementById("toggleWireframe");
  if (wireframeBtn) {
    wireframeBtn.addEventListener("click", function () {
      isWireframe = !isWireframe;
      toggleWireframe(isWireframe);
    });
  }

  const rotateBtn = document.getElementById("Rotate");
  if (rotateBtn) {
    rotateBtn.addEventListener("click", function () {
      if (loadedModel) {
        const axis = new THREE.Vector3(0, 1, 0);
        const angle = Math.PI / 8;
        loadedModel.rotateOnAxis(axis, angle);
      } else {
        console.warn("Model not loaded yet");
      }
    });
  }

  window.addEventListener("resize", resize, false);
  animate();
}

function createArrowButtons() {
  const canvasWrapper = document.getElementById("canvasWrapper");

  const leftArrow = document.createElement("button");
  leftArrow.id = "leftArrow";
  leftArrow.innerHTML = "⬅️";
  leftArrow.style.position = "absolute";
  leftArrow.style.top = "50%";
  leftArrow.style.left = "10px";
  leftArrow.style.transform = "translateY(-50%)";
  leftArrow.style.zIndex = "100";
  canvasWrapper.appendChild(leftArrow);

  const rightArrow = document.createElement("button");
  rightArrow.id = "rightArrow";
  rightArrow.innerHTML = "➡️";
  rightArrow.style.position = "absolute";
  rightArrow.style.top = "50%";
  rightArrow.style.right = "10px";
  rightArrow.style.transform = "translateY(-50%)";
  rightArrow.style.zIndex = "100";
  canvasWrapper.appendChild(rightArrow);

  leftArrow.addEventListener("click", function () {
    loadModel(firstModelPath);
    currentModelIndex = 0;
  });

  rightArrow.addEventListener("click", function () {
    if (secondModelPath) {
      loadModel(secondModelPath);
      currentModelIndex = 1;
    } else {
      console.warn("No second model available.");
    }
  });
}

function loadModel(modelPath) {
  if (loadedModel) {
    scene.remove(loadedModel);
  }

  loader.load(modelPath, function (gltf) {
    const model = gltf.scene;
    model.position.set(0, 0, 0);
    scene.add(model);
    loadedModel = model;

    mixer = new THREE.AnimationMixer(model);
    const animations = gltf.animations;
    actions = [];
    animations.forEach((clip) => {
      const action = mixer.clipAction(clip);
      actions.push(action);
    });
  });
}

function setupSounds(drinkData) {
  const audioLoader = new THREE.AudioLoader();
  const listener = new THREE.AudioListener();
  camera.add(listener);

  sound = new THREE.Audio(listener);

  if (drinkData.soundPath) {
    audioLoader.load(drinkData.soundPath, function (buffer) {
      sound.setBuffer(buffer);
      sound.setLoop(false);
      sound.setVolume(1.0);
    });
  }

  if (drinkData.secondSoundPath) {
    secondSound = new THREE.Audio(listener);
    audioLoader.load(drinkData.secondSoundPath, function (buffer) {
      secondSound.setBuffer(buffer);
      secondSound.setLoop(false);
      secondSound.setVolume(1.0);
    });
  }
}

function toggleWireframe(enable) {
  scene.traverse(function (object) {
    if (object.isMesh) {
      object.material.wireframe = enable;
    }
  });
}

function animate() {
  requestAnimationFrame(animate);

  if (mixer) {
    mixer.update(clock.getDelta());
    if (secondModelMixer) secondModelMixer.update(clock.getDelta());
  }

  renderer.render(scene, camera);

  const time = clock.getElapsedTime();
  const delta = Math.sin(time) * 5;
  if (params.spot.moving) {
    lights.spot.position.x = delta;
    lights.spotHelper.update();
  }
}

function resize() {
  const width = window.innerWidth;
  const height = window.innerHeight;

  camera.aspect = width / height;
  camera.updateProjectionMatrix();
  renderer.setSize(width, height);
}