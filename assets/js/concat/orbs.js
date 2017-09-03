// Variables.
var r;
var g;
var b;
var a;

var canvas;
var heightOfCanvas; // changes depending on page.
var orbs = [];
var orbAmount = 42;

// Speeds.
var speedMin = -6;
var speedMax = 6;

var timer;

// Conditional for page type.
function isFront() {
	var front = document.body;

	if( front.classList.contains( 'home' ) ) {
		return heightOfCanvas = 400;
	} else {
		return heightOfCanvas = 150;
	}
}

// Setup.
function setup() {
	isFront();

	canvas = createCanvas(windowWidth, heightOfCanvas);
	canvas.parent('heroine');
	canvas.position(0, 0);
	canvas.style('z-index', '-1');

	for (var i = 0; i < orbAmount; i++) {
		orbs[i] = new Orb();
	}
}

// Draw.
function draw(){
	background(42, 27, 61);

	for (var i = 0; i < orbs.length; i++) {
		orbs[i].display();
		orbs[i].update();
		orbs[i].edges();
	}
}

function startTimer() {
	timer = setInterval(fadeOut, 800);
}

function fadeOut() {
	// Nix oldest orb in array as long as there's more than original amount.
	if (orbs.length > orbAmount ) {
		orbs.splice(0, 1);
	} else {
		clearInterval(timer);
	}
}

// Add orbs on mouse drag.
function mouseDragged() {
	orbs.push(new Orb(mouseX, mouseY));
}

// Start timer on mouse press.
function mousePressed() {
	startTimer();
}

// *THE ORB * //
function Orb(mouseX=null,mouseY=null) {
	// Radius.
	var radius = random(8, 24);

	// Colour Variables.
	this.r = random(145, 255);
	this.g = random(0, 150);
	this.b = random(200, 255);
	this.a = random(0, 100);

	// Set position of bubble creation for mouse position but starting bubbles will be randomly positioned.
	if (mouseX && mouseY) {
		this.position = createVector(
			mouseX, mouseY
	)} else {
		this.position = createVector(
			random(0 + 20, width - 20),
			random(0 + 20, height - 20)
	)};

	// Start w/ random initial velocities.
	this.velocity = createVector(random(speedMin, speedMax) / (radius / 1.2), random(speedMin, speedMax) / (radius / 1.2));

	// Coordinates to move towards.
	var coordinate = createVector(random(0, width), random(0, height));

	this.update = function() {
		this.acceleration = p5.Vector.sub(coordinate, this.position);
		this.acceleration.setMag((this.radius));
		this.velocity.add(this.acceleration);
		this.position.add(this.velocity);
	};

	this.display = function() {
		noStroke();
		fill(this.r, this.g, this.b, this.a);
		ellipse(this.position.x, this.position.y, radius/2, radius/2);
		ellipse(this.position.x + 1, this.position.y - 1, radius, radius);
	};

	// Keep inside borders.
	this.edges = function() {
		// Top.
		if(((radius / 2 * -1) + this.position.y) < 0) {
			this.velocity.y *= -1;
		}
		// Bottom.
		if(((radius / 2) + this.position.y) > height) {
			this.velocity.y *= -1;
		}
		// Left.
		if(((radius / 2 * -1) + this.position.x) < 0) {
			this.velocity.x *= -1;
		}
		// Right.
		if(((radius / 2) + this.position.x) > width) {
			this.velocity.x *= -1;
		}
	};
}

// Window resizer.
function windowResized() {
	resizeCanvas(windowWidth, heightOfCanvas);
}
