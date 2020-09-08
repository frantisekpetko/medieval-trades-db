import React, { Component } from 'react';
import * as THREE from 'three'

class SplashScreen extends Component {
    componentDidMount() {
        this.WIDTH = this.mount.clientWidth;
        this.HEIGHT = this.mount.clientHeight;
        this.HALFW = this.mount.clientWidth / 2;
        this.HALFH = this.mount.clientHeight / 2;
        this.particleCount = 210000;
        this.particleRange = 500;
        this.colors = [];

        this.mouseX = 0;
        this.mouseY = 0;
        this.mouseZ= 0;

        this.scene = new THREE.Scene();
        this.camera = new THREE.PerspectiveCamera(75,  this.WIDTH / this.HEIGHT, 0.1, 1000);
        this.scene.fog =new THREE.FogExp2(0x000000, 0.001);
        this.renderer = new THREE.WebGLRenderer({ antialias: true });
        this.geometry = new THREE.BoxGeometry(1, 1, 1);
        this.material = new THREE.MeshBasicMaterial({ color: 0xff00ff });
        this.particles = new THREE.Geometry();

        //camera.position.z = 4;
        //scene.add(cube);
        //renderer.setClearColor('#000000');

        this.renderer.setSize(this.WIDTH, this.HEIGHT);
        this.renderer.setPixelRatio(window.devicePixelRatio);




        this.mount.appendChild(this.renderer.domElement);

        this.loader = new THREE.TextureLoader();

        window.addEventListener('resize', this.handleResize);
        this.material = new THREE.PointCloudMaterial({
            vertexColors: THREE.VertexColors,
            size: 1,
            blending: THREE.AdditiveBlending,
            map: this.loader.load(
                'https://lh4.googleusercontent.com/-Lk3VPdR68ds/VPGFYP12r5I/AAAAAAAAIXw/Bx5OrcaVSG0/s128/nova_0.png'
            ),
            transparent: true
        });
        this.scene.add(this.camera);
        this.camera.position.z = 5;
        this.start();
    }


    handleResize = () => {
        this.WIDTH = window.innerWidth;
        this.HALFW  = this.WIDTH / 2 ;
        this.HEIGHT = window.innerHeight;
        this.HALFH = this.HEIGHT / 2;


        this.camera.aspect = this.WIDTH / this.HEIGHT;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(this.WIDTJ, this.HEIGHT);
    };

    start = () => {
        if (!this.frameId) {
            this.frameId = requestAnimationFrame(this.animate)
        }
    };

    stop = () => {
        cancelAnimationFrame(this.frameId)
    };

    animate = () => {
        for (var p = 0; p < this.particleCount; p++) {
            var pX = this.gaussianRandom(this.particleRange / 2, 0),
                pY = this.gaussianRandom(this.particleRange / 2, 0),
                pZ = this.gaussianRandom(this.particleRange / 2, 0),
                particle = new THREE.Vector3(pX, pY, pZ);

            this.colors[p] = new THREE.Color();
            this.colors[p].setHSL(Math.random(), 1.0, 0.5);

            this.particles.velocity = new THREE.Vector3(0, -Math.random() * 0.02, 0);
            // add it to the geometry
            this.particles.vertices.push(this.particle);
            this.particles.colors = this.colors;
        }
        this.particleSystem = new THREE.PointCloud(this.particles, this.material);
        this.particleSystem.sortParticles = true;
        this.scene.add(this.particleSystem);

        this.renderScene();
        this.frameId = window.requestAnimationFrame(this.animate)
    };



    /* done */
    renderScene = () => {
        this.renderer.render(this.scene, this.camera)
    };



    componentWillUnmount() {
        window.removeEventListener('resize', null);
        this.stop();
        this.mount.removeChild(this.renderer.domElement);
    }

    gaussianRandom = (stddev, mean) => {
        return Math.random() * 2 - 1 + (Math.random() * 2 - 1) + (Math.random() * 2 - 1) * stddev + mean;
    };



    render() {
        return (
            <div
                id="canvas"
                ref={mount => {
                    this.mount = mount
                }}
            />
        )
    }
}

export default SplashScreen;