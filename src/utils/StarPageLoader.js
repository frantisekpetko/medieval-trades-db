var renderer, scene, camera, container;
var WIDTH, HEIGHT, HALFW, HALFH;
var mouseX, mouseY, mouseZ;
var particleCount, particleRange, particles, particleSystem, material;
var colors;

import * as THREELib from 'three-js';

const THREE = THREELib(['EffectComposer']); // return THREE JS

export default class StarPageLoader {
    static animationWasCalled = false;

    static doAnimation() {
        setup();
        draw();

        return function() {
            if (!StarPageLoader.animationWasCalled) {
                console.log('Animation of stars was called.');
                StarPageLoader.animationWasCalled = true;
            }
        };
    }
}


function setup() {
    WIDTH = window.innerWidth;  /** */
    HALFW = WIDTH / 2; /** */
    HEIGHT = window.innerHeight; /** */
    HALFH = HEIGHT / 2;
    particleCount = 210000;
    particleRange = 600;
    colors = [];

    mouseX = mouseY = mouseZ = 0;

    container = document.getElementById("canvas"); /*** ###### ***/

    renderer = new THREE.WebGLRenderer({ antialias: true }); /*****/
    renderer.setSize( window.innerWidth, window.innerHeight ); /*****/

    renderer.setPixelRatio(window.devicePixelRatio); /*****/

    scene = new THREE.Scene(); /*****/
    scene.fog = new THREE.FogExp2(0x000000, 0.001);  /*****/

    camera = new THREE.PerspectiveCamera(75, WIDTH / HEIGHT, 0.1, 1000); /*****/

   // var div = document.createElement("div");
    //div.appendChild(renderer.domElement);
    //container.appendChild(div);

    //var d1 = document.getElementById('one');
    container.insertAdjacentHTML('beforeend', renderer.domElement);


    renderer.setSize(WIDTH, HEIGHT);

    container.appendChild(renderer.domElement);

    THREE.ImageUtils.crossOrigin = '';
    material = new THREE.PointCloudMaterial({
        vertexColors: THREE.VertexColors,
        size: 1,
        blending: THREE.AdditiveBlending,
        map: THREE.ImageUtils.loadTexture(
            'https://lh4.googleusercontent.com/-Lk3VPdR68ds/VPGFYP12r5I/AAAAAAAAIXw/Bx5OrcaVSG0/s128/nova_0.png'
        ),
        transparent: true
    });

    scene.add(camera);
    camera.position.z = 5;

    particles = new THREE.Geometry();

    for (var p = 0; p < particleCount; p++) {
        var pX = gaussianRandom(particleRange / 2, 0),
            pY = gaussianRandom(particleRange / 2, 0),
            pZ = gaussianRandom(particleRange / 2, 0),
            particle = new THREE.Vector3(pX, pY, pZ);

        colors[p] = new THREE.Color();
        colors[p].setHSL(Math.random(), 1.0, 0.5);

        particle.velocity = new THREE.Vector3(0, -Math.random() * 0.02, 0);
        // add it to the geometry
        particles.vertices.push(particle);
        particles.colors = colors;
    }
    particleSystem = new THREE.PointCloud(particles, material);
    particleSystem.sortParticles = true;
    scene.add(particleSystem);

    setEventListeners();
}

function draw() {
    updateCamera();
    animatePointCloud();
    renderer.render(scene, camera);
    requestAnimationFrame(draw);
}

function updateCamera() {
    camera.position.x += (mouseX - camera.position.x) * 0.05;
    camera.position.y += (-mouseY - camera.position.y) * 0.05;

    camera.lookAt(particleSystem.position);
    camera.updateProjectionMatrix();
}

function animatePointCloud() {
    particleSystem.rotation.y += 0.01;

    var pCount = particleCount;
    while (pCount--) {
        var particle = particles.vertices[pCount];

        if (particle.y < -(particleRange / 2)) {
            particle.y = particleRange / 2;
            particle.velocity.y = 0;
        }
        particle.velocity.y -= Math.random() * 0.1;

        particle.x += particle.velocity.x;
        particle.y += particle.velocity.y;
        particle.z += particle.velocity.z;
    }
    particleSystem.geometry.verticesNeedUpdate = true;
}

function setEventListeners() {
    document.addEventListener('mousewheel', onMouseScroll, false);
    document.addEventListener('mousemove', onMouseMove, false);

    window.addEventListener('resize', onWindowResize, false);
}

function onMouseMove(event) {
    mouseX = event.clientX - HALFW;
    mouseY = event.clientY - HALFH;
}

function onMouseScroll(event) {
    mouseZ = event.wheelDelta;

    camera.position.z -= mouseZ * 0.01;
    camera.updateProjectionMatrix();
}

function onWindowResize(event) {
    let WIDTH = window.innerWidth;
    let HALFW = this.WIDTH / 2;
    let HEIGHT = window.innerHeight;
    let HALFH = this.HEIGHT / 2;

    camera.aspect = WIDTH / HEIGHT;
    camera.updateProjectionMatrix();

    renderer.setSize(WIDTH, HEIGHT);
}

function gaussianRandom(stddev, mean) {
    return Math.random() * 2 - 1 + (Math.random() * 2 - 1) + (Math.random() * 2 - 1) * stddev + mean;
}


