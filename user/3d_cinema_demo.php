<!DOCTYPE html>
<html lang="en">
<head>
   <link rel="icon" type="image/x-icon" href="image/favicon-logo.ico">
  <title>Final Boss Cinema 3D</title>
  <style>
    body { margin: 0; overflow: hidden; background: #000; }
    #info {
      position: absolute; top: 20px; left: 20px;
      background: rgba(0,0,0,0.75); color: #fff;
      padding: 12px; border-radius: 6px;
      font-family: 'Segoe UI', sans-serif;
      display: none; box-shadow: 0 0 10px #000;
    }
  </style>
</head>
<body>

<div id="info"></div>
<canvas id="cinema3d"></canvas>





<script src="https://cdn.jsdelivr.net/npm/three/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/OrbitControls.js"></script>

<script>
const canvas = document.getElementById('cinema3d');
const info = document.getElementById('info');
const scene = new THREE.Scene();
scene.background = new THREE.Color(0x000000);

const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
camera.position.set(0, 8, 20);

const renderer = new THREE.WebGLRenderer({ canvas, antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);

const controls = new THREE.OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.target.set(0, 2, 0);

scene.add(new THREE.AmbientLight(0xffffff, 0.4));
const spotLight = new THREE.SpotLight(0xffffff, 1);
spotLight.position.set(0, 20, 10);
scene.add(spotLight);

const floor = new THREE.Mesh(
  new THREE.PlaneGeometry(30, 40),
  new THREE.MeshStandardMaterial({ color: 0x222222 })
);
floor.rotation.x = -Math.PI / 2;
scene.add(floor);

const screenGeometry = new THREE.PlaneGeometry(20, 10);
const screenMaterial = new THREE.MeshBasicMaterial({ color: 0xffffff }); // white color
const screen = new THREE.Mesh(screenGeometry, screenMaterial);
screen.position.set(0, 5, -18);
scene.add(screen);

const wallMaterial = new THREE.MeshStandardMaterial({ color: 0x2a2a2a });

const backWall = new THREE.Mesh(new THREE.BoxGeometry(30, 12, 0.5), wallMaterial);
backWall.position.set(0, 6, -20);
scene.add(backWall);

const leftWall = new THREE.Mesh(new THREE.BoxGeometry(0.5, 12, 40), wallMaterial);
leftWall.position.set(-15, 6, 0);
scene.add(leftWall);

const rightWall = new THREE.Mesh(new THREE.BoxGeometry(0.5, 12, 40), wallMaterial);
rightWall.position.set(15, 6, 0);
scene.add(rightWall);

const ceiling = new THREE.Mesh(
  new THREE.PlaneGeometry(30, 40),
  new THREE.MeshStandardMaterial({ color: 0x080808 })
);
ceiling.rotation.x = Math.PI / 2;
ceiling.position.y = 12;
scene.add(ceiling);

const doorMaterial = new THREE.MeshStandardMaterial({ color: 0x8B4513 });
const door1 = new THREE.Mesh(new THREE.BoxGeometry(2, 4, 0.2), doorMaterial);
door1.position.set(-5, 2, 19.8);
scene.add(door1);

const door2 = door1.clone();
door2.position.set(5, 2, 19.8);
scene.add(door2);

const seats = [];
for (let row = 0; row < 10; row++) {
  for (let col = 0; col < 20; col++) {
    const seatGroup = new THREE.Group();

    const base = new THREE.Mesh(
      new THREE.BoxGeometry(0.6, 0.3, 0.6),
      new THREE.MeshStandardMaterial({ color: 0x1e90ff })
    );
    base.position.set(0, 0.15, 0);
    seatGroup.add(base);

    const back = new THREE.Mesh(
      new THREE.BoxGeometry(0.6, 0.6, 0.1),
      new THREE.MeshStandardMaterial({ color: 0x1e90ff })
    );
    back.position.set(0, 0.6, -0.25);
    seatGroup.add(back);

    seatGroup.position.set((col - 10) * 1.1 + 0.5, 0, row * -1.2 + 2);
    seatGroup.userData.seatId = `R${row + 1}S${col + 1}`;
    scene.add(seatGroup);
    seats.push(seatGroup);
  }
}

const raycaster = new THREE.Raycaster();
const mouse = new THREE.Vector2();

window.addEventListener('click', (event) => {
  mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
  mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
  raycaster.setFromCamera(mouse, camera);
  const intersects = raycaster.intersectObjects(seats, true);

  if (intersects.length > 0) {
    const seatGroup = intersects[0].object.parent;
    seatGroup.children.forEach(mesh => mesh.material.color.set(0xffff00));
    controls.target.copy(seatGroup.position);
    info.style.display = 'block';
    info.innerHTML = `
      🎟️ <strong>Seat:</strong> ${seatGroup.userData.seatId}<br>
      📏 Distance to screen: ${seatGroup.position.distanceTo(new THREE.Vector3(0, 5, -18)).toFixed(2)}m
    `;
  }
});

function animate() {
  requestAnimationFrame(animate);
  controls.update();
  renderer.render(scene, camera);
}
animate();

window.addEventListener('resize', () => {
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(window.innerWidth, window.innerHeight);
});
</script>
</body>
</html>
