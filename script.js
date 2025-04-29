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
  firstModelPath,
  secondModelPath,
  currentCanvas,
  currentModelIndex = 0;

let count = 0;

async function fetchDrinkData() {
  try {
    const response = await fetch('models.json');
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error fetching models.json:', error);
  }
}

function swapContent(id) {
  document.querySelectorAll('.content').forEach(section => {
    section.classList.remove('active');
    section.style.display = 'none';
  });

  const selected = document.getElementById(id);
  if (selected) {
    selected.classList.add('active');
    selected.style.display = 'block';
  }

  if (["coke", "sprite", "pepper"].includes(id)) {
    fetchDrinkData().then((data) => {
      if (data && data[id]) {
        firstModelPath = data[id].modelPath;
        secondModelPath = data[id].secondModelPath;
        const canvas = selected.querySelector("canvas");
        const guiContainer = selected.querySelector("#gui-container");
        const drinkData = data[id];
        setupViewer(canvas, guiContainer);
        loadModel(firstModelPath);
        setupSounds(drinkData);
        loadGallery(id);
      }
    });
  }
}

function setupViewer(canvas, guiContainer) {
  clock = new THREE.Clock();
  scene = new THREE.Scene();
  scene.background = new THREE.Color(0xFAF0E6);

  camera = new THREE.PerspectiveCamera(60, canvas.clientWidth / canvas.clientHeight, 0.1, 1000);
  camera.position.set(-5, 25, 20);

  const listener = new THREE.AudioListener();
  camera.add(listener);

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
  guiContainer.innerHTML = '';
  guiContainer.appendChild(gui.domElement);

  const spot = gui.addFolder("Spot");
  spot.open();
  spot.add(params.spot, "enable").onChange((value) => { lights.spot.visible = value; });
  spot.addColor(params.spot, "color").onChange((value) => (lights.spot.color = new THREE.Color(value)));
  spot.add(params.spot, "distance").min(0).max(20).onChange((value) => (lights.spot.distance = value));
  spot.add(params.spot, "angle").min(0.1).max(6.28).onChange((value) => (lights.spot.angle = value));
  spot.add(params.spot, "penumbra").min(0).max(1).onChange((value) => (lights.spot.penumbra = value));
  spot.add(params.spot, "helper").onChange((value) => (lights.spotHelper.visible = value));
  spot.add(params.spot, "moving");

  renderer = new THREE.WebGLRenderer({ canvas });
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);

  const controls = new THREE.OrbitControls(camera, renderer.domElement);
  controls.target.set(1, 2, 0);
  controls.update();

  loader = new THREE.GLTFLoader();
  currentCanvas = canvas;

  animate();
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

function animate() {
  requestAnimationFrame(animate);

  if (mixer) {
    mixer.update(clock.getDelta());
  }

  renderer.render(scene, camera);

  const time = clock.getElapsedTime();
  const delta = Math.sin(time) * 5;
  if (params.spot.moving) {
    lights.spot.position.x = delta;
    lights.spotHelper.update();
  }
}

function countUp() {
  count++;
  document.getElementById('counter').textContent = count;
}

function changeLook() {
  document.body.style.backgroundColor = "#222";
  document.body.style.color = "#eee";
  const navbar = document.querySelector('.navbar');
  if (navbar) navbar.classList.remove('bg-dark');
  if (navbar) navbar.classList.add('bg-primary');
}

function changeLook() {
  const body = document.body;
  const navbar = document.querySelector('.navbar');
  const button = document.querySelector('#themeToggle');

  body.classList.toggle('dark-mode');

  if (body.classList.contains('dark-mode')) {
    if (navbar) {
      navbar.classList.remove('bg-dark');
      navbar.classList.add('bg-primary');

    }
    if (button) button.textContent = 'Light Mode';
  } else {
    if (navbar) {
      navbar.classList.remove('bg-primary');
      navbar.classList.add('bg-dark');
    
    }
    if (button) button.textContent = 'Dark Mode';
  }
}


