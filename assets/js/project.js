'use strict';

/**
 * File js-enabled.js
 *
 * If Javascript is enabled, replace the <body> class "no-js".
 */
document.body.className = document.body.className.replace('no-js', 'js');
'use strict';

// Variables.
var r;
var g;
var b;
var a;

var canvas;
var orbs = [];
var orbAmount = 42;

// Speeds.
var speedMin = -6;
var speedMax = 6;

var timer;

// Setup.
function setup() {
	canvas = createCanvas(windowWidth, 400);
	canvas.parent('heroine');
	canvas.position(0, 0);
	canvas.style('z-index', '-1');

	for (var i = 0; i < orbAmount; i++) {
		orbs[i] = new Orb();
	}
}

// Draw.
function draw() {
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
	if (orbs.length > orbAmount) {
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
function Orb() {
	var mouseX = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
	var mouseY = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

	// Radius.
	var radius = random(8, 24);

	// Colour Variables.
	this.r = random(145, 255);
	this.g = random(0, 150);
	this.b = random(200, 255);
	this.a = random(0, 100);

	// Set position of bubble creation for mouse position but starting bubbles will be randomly positioned.
	if (mouseX && mouseY) {
		this.position = createVector(mouseX, mouseY);
	} else {
		this.position = createVector(random(0 + 20, width - 20), random(0 + 20, height - 20));
	};

	// Start w/ random initial velocities.
	this.velocity = createVector(random(speedMin, speedMax) / (radius / 1.2), random(speedMin, speedMax) / (radius / 1.2));

	// Coordinates to move towards.
	var coordinate = createVector(random(0, width), random(0, height));

	this.update = function () {
		this.acceleration = p5.Vector.sub(coordinate, this.position);
		this.acceleration.setMag(this.radius);
		this.velocity.add(this.acceleration);
		this.position.add(this.velocity);
	};

	this.display = function () {
		noStroke();
		fill(this.r, this.g, this.b, this.a);
		ellipse(this.position.x, this.position.y, radius / 2, radius / 2);
		ellipse(this.position.x + 1, this.position.y - 1, radius, radius);
	};

	// Keep inside borders.
	this.edges = function () {
		// Top.
		if (radius / 2 * -1 + this.position.y < 0) {
			this.velocity.y *= -1;
		}
		// Bottom.
		if (radius / 2 + this.position.y > height) {
			this.velocity.y *= -1;
		}
		// Left.
		if (radius / 2 * -1 + this.position.x < 0) {
			this.velocity.x *= -1;
		}
		// Right.
		if (radius / 2 + this.position.x > width) {
			this.velocity.x *= -1;
		}
	};
}

// Window resizer.
function windowResized() {
	resizeCanvas(windowWidth, 400);
}
'use strict';

/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
(function () {
	var isWebkit = navigator.userAgent.toLowerCase().indexOf('webkit') > -1,
	    isOpera = navigator.userAgent.toLowerCase().indexOf('opera') > -1,
	    isIe = navigator.userAgent.toLowerCase().indexOf('msie') > -1;

	if ((isWebkit || isOpera || isIe) && document.getElementById && window.addEventListener) {
		window.addEventListener('hashchange', function () {
			var id = location.hash.substring(1),
			    element;

			if (!/^[A-z0-9_-]+$/.test(id)) {
				return;
			}

			element = document.getElementById(id);

			if (element) {
				if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false);
	}
})();
'use strict';

/**
 * File super-heroine.js
 *
 */
var listOne = ['INFJ', 'WordPress', 'Creative', 'Coding', 'Inclusive'];
var listTwo = ['Hula Hooper', 'Poet', 'Writer', 'Curator', 'Detective', 'Technologist', 'Feminist', 'of the Internet', 'Aesthetician', 'Daydreamer'];

var interval = 3000;
var wordHistory = '';

// **Grab elements.
var containerNumber = document.getElementsByClassName('text-shifting');

identityCycle(containerNumber[0], listOne);

// Stagger switching timing.
setTimeout(function () {
	identityCycle(containerNumber[1], listTwo);
}, interval / 2);

// **Start it off.
function identityCycle(container, whichList) {

	setInterval(function () {
		replaceContent(container, whichList);
	}, interval);
};

// **Choose random word from chosen array.
function getRandomWords(listChoice) {
	var word = listChoice[Math.floor(Math.random() * listChoice.length)];
	return word;
}

// **Markup Replacement.
function replaceContent(container, whichList) {

	var identity = getRandomWords(whichList);
	var noRepeat = compareWords(identity);

	// **Replace.
	if (noRepeat) {
		container.textContent = identity;
	} else {
		replaceContent(container);
	}

	wordHistory = identity;
}

function compareWords(currentWord) {
	if (currentWord === wordHistory) {
		return false;
	} else {
		return true;
	}
}
'use strict';

/**
 * File window-ready.js
 *
 * Add a "ready" class to <body> when window is ready.
 */
window.Window_Ready = {};
(function (window, $, that) {

	// Constructor.
	that.init = function () {
		that.cache();
		that.bindEvents();
	};

	// Cache document elements.
	that.cache = function () {
		that.$c = {
			window: $(window),
			body: $(document.body)
		};
	};

	// Combine all events.
	that.bindEvents = function () {
		that.$c.window.load(that.addBodyClass);
	};

	// Add a class to <body>.
	that.addBodyClass = function () {
		that.$c.body.addClass('ready');
	};

	// Engage!
	$(that.init);
})(window, jQuery, window.Window_Ready);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImpzLWVuYWJsZWQuanMiLCJvcmJzLmpzIiwic2tpcC1saW5rLWZvY3VzLWZpeC5qcyIsInN1cGVyLWhlcm9pbmUuanMiLCJ3aW5kb3ctcmVhZHkuanMiXSwibmFtZXMiOlsiZG9jdW1lbnQiLCJib2R5IiwiY2xhc3NOYW1lIiwicmVwbGFjZSIsInIiLCJnIiwiYiIsImEiLCJjYW52YXMiLCJvcmJzIiwib3JiQW1vdW50Iiwic3BlZWRNaW4iLCJzcGVlZE1heCIsInRpbWVyIiwic2V0dXAiLCJjcmVhdGVDYW52YXMiLCJ3aW5kb3dXaWR0aCIsInBhcmVudCIsInBvc2l0aW9uIiwic3R5bGUiLCJpIiwiT3JiIiwiZHJhdyIsImJhY2tncm91bmQiLCJsZW5ndGgiLCJkaXNwbGF5IiwidXBkYXRlIiwiZWRnZXMiLCJzdGFydFRpbWVyIiwic2V0SW50ZXJ2YWwiLCJmYWRlT3V0Iiwic3BsaWNlIiwiY2xlYXJJbnRlcnZhbCIsIm1vdXNlRHJhZ2dlZCIsInB1c2giLCJtb3VzZVgiLCJtb3VzZVkiLCJtb3VzZVByZXNzZWQiLCJyYWRpdXMiLCJyYW5kb20iLCJjcmVhdGVWZWN0b3IiLCJ3aWR0aCIsImhlaWdodCIsInZlbG9jaXR5IiwiY29vcmRpbmF0ZSIsImFjY2VsZXJhdGlvbiIsInA1IiwiVmVjdG9yIiwic3ViIiwic2V0TWFnIiwiYWRkIiwibm9TdHJva2UiLCJmaWxsIiwiZWxsaXBzZSIsIngiLCJ5Iiwid2luZG93UmVzaXplZCIsInJlc2l6ZUNhbnZhcyIsImlzV2Via2l0IiwibmF2aWdhdG9yIiwidXNlckFnZW50IiwidG9Mb3dlckNhc2UiLCJpbmRleE9mIiwiaXNPcGVyYSIsImlzSWUiLCJnZXRFbGVtZW50QnlJZCIsIndpbmRvdyIsImFkZEV2ZW50TGlzdGVuZXIiLCJpZCIsImxvY2F0aW9uIiwiaGFzaCIsInN1YnN0cmluZyIsImVsZW1lbnQiLCJ0ZXN0IiwidGFnTmFtZSIsInRhYkluZGV4IiwiZm9jdXMiLCJsaXN0T25lIiwibGlzdFR3byIsImludGVydmFsIiwid29yZEhpc3RvcnkiLCJjb250YWluZXJOdW1iZXIiLCJnZXRFbGVtZW50c0J5Q2xhc3NOYW1lIiwiaWRlbnRpdHlDeWNsZSIsInNldFRpbWVvdXQiLCJjb250YWluZXIiLCJ3aGljaExpc3QiLCJyZXBsYWNlQ29udGVudCIsImdldFJhbmRvbVdvcmRzIiwibGlzdENob2ljZSIsIndvcmQiLCJNYXRoIiwiZmxvb3IiLCJpZGVudGl0eSIsIm5vUmVwZWF0IiwiY29tcGFyZVdvcmRzIiwidGV4dENvbnRlbnQiLCJjdXJyZW50V29yZCIsIldpbmRvd19SZWFkeSIsIiQiLCJ0aGF0IiwiaW5pdCIsImNhY2hlIiwiYmluZEV2ZW50cyIsIiRjIiwibG9hZCIsImFkZEJvZHlDbGFzcyIsImFkZENsYXNzIiwialF1ZXJ5Il0sIm1hcHBpbmdzIjoiOztBQUFBOzs7OztBQUtBQSxTQUFTQyxJQUFULENBQWNDLFNBQWQsR0FBMEJGLFNBQVNDLElBQVQsQ0FBY0MsU0FBZCxDQUF3QkMsT0FBeEIsQ0FBaUMsT0FBakMsRUFBMEMsSUFBMUMsQ0FBMUI7OztBQ0xBO0FBQ0EsSUFBSUMsQ0FBSjtBQUNBLElBQUlDLENBQUo7QUFDQSxJQUFJQyxDQUFKO0FBQ0EsSUFBSUMsQ0FBSjs7QUFFQSxJQUFJQyxNQUFKO0FBQ0EsSUFBSUMsT0FBTyxFQUFYO0FBQ0EsSUFBSUMsWUFBWSxFQUFoQjs7QUFFQTtBQUNBLElBQUlDLFdBQVcsQ0FBQyxDQUFoQjtBQUNBLElBQUlDLFdBQVcsQ0FBZjs7QUFFQSxJQUFJQyxLQUFKOztBQUdBO0FBQ0EsU0FBU0MsS0FBVCxHQUFpQjtBQUNoQk4sVUFBU08sYUFBYUMsV0FBYixFQUEwQixHQUExQixDQUFUO0FBQ0FSLFFBQU9TLE1BQVAsQ0FBYyxTQUFkO0FBQ0FULFFBQU9VLFFBQVAsQ0FBZ0IsQ0FBaEIsRUFBbUIsQ0FBbkI7QUFDQVYsUUFBT1csS0FBUCxDQUFhLFNBQWIsRUFBd0IsSUFBeEI7O0FBRUEsTUFBSyxJQUFJQyxJQUFJLENBQWIsRUFBZ0JBLElBQUlWLFNBQXBC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QUFULENBQXVCRSxXQUF2QixFQUFxQztBQUNwQyxLQUFJQSxnQkFBZ0JqQixXQUFwQixFQUFrQztBQUNqQyxTQUFPLEtBQVA7QUFDQSxFQUZELE1BRU87QUFDTixTQUFPLElBQVA7QUFDQTtBQUNEOzs7QUN6REQ7Ozs7O0FBS0FkLE9BQU9nQyxZQUFQLEdBQXNCLEVBQXRCO0FBQ0EsQ0FBRSxVQUFVaEMsTUFBVixFQUFrQmlDLENBQWxCLEVBQXFCQyxJQUFyQixFQUE0Qjs7QUFFN0I7QUFDQUEsTUFBS0MsSUFBTCxHQUFZLFlBQVc7QUFDdEJELE9BQUtFLEtBQUw7QUFDQUYsT0FBS0csVUFBTDtBQUNBLEVBSEQ7O0FBS0E7QUFDQUgsTUFBS0UsS0FBTCxHQUFhLFlBQVc7QUFDdkJGLE9BQUtJLEVBQUwsR0FBVTtBQUNUdEMsV0FBUWlDLEVBQUVqQyxNQUFGLENBREM7QUFFVGpFLFNBQU1rRyxFQUFFbkcsU0FBU0MsSUFBWDtBQUZHLEdBQVY7QUFJQSxFQUxEOztBQU9BO0FBQ0FtRyxNQUFLRyxVQUFMLEdBQWtCLFlBQVc7QUFDNUJILE9BQUtJLEVBQUwsQ0FBUXRDLE1BQVIsQ0FBZXVDLElBQWYsQ0FBcUJMLEtBQUtNLFlBQTFCO0FBQ0EsRUFGRDs7QUFJQTtBQUNBTixNQUFLTSxZQUFMLEdBQW9CLFlBQVc7QUFDOUJOLE9BQUtJLEVBQUwsQ0FBUXZHLElBQVIsQ0FBYTBHLFFBQWIsQ0FBdUIsT0FBdkI7QUFDQSxFQUZEOztBQUlBO0FBQ0FSLEdBQUdDLEtBQUtDLElBQVI7QUFFQSxDQTdCRCxFQTZCSW5DLE1BN0JKLEVBNkJZMEMsTUE3QlosRUE2Qm9CMUMsT0FBT2dDLFlBN0IzQiIsImZpbGUiOiJwcm9qZWN0LmpzIiwic291cmNlc0NvbnRlbnQiOlsiLyoqXG4gKiBGaWxlIGpzLWVuYWJsZWQuanNcbiAqXG4gKiBJZiBKYXZhc2NyaXB0IGlzIGVuYWJsZWQsIHJlcGxhY2UgdGhlIDxib2R5PiBjbGFzcyBcIm5vLWpzXCIuXG4gKi9cbmRvY3VtZW50LmJvZHkuY2xhc3NOYW1lID0gZG9jdW1lbnQuYm9keS5jbGFzc05hbWUucmVwbGFjZSggJ25vLWpzJywgJ2pzJyApOyIsIi8vIFZhcmlhYmxlcy5cbnZhciByO1xudmFyIGc7XG52YXIgYjtcbnZhciBhO1xuXG52YXIgY2FudmFzO1xudmFyIG9yYnMgPSBbXTtcbnZhciBvcmJBbW91bnQgPSA0MjtcblxuLy8gU3BlZWRzLlxudmFyIHNwZWVkTWluID0gLTY7XG52YXIgc3BlZWRNYXggPSA2O1xuXG52YXIgdGltZXI7XG5cblxuLy8gU2V0dXAuXG5mdW5jdGlvbiBzZXR1cCgpIHtcblx0Y2FudmFzID0gY3JlYXRlQ2FudmFzKHdpbmRvd1dpZHRoLCA0MDApO1xuXHRjYW52YXMucGFyZW50KCdoZXJvaW5lJyk7XG5cdGNhbnZhcy5wb3NpdGlvbigwLCAwKTtcblx0Y2FudmFzLnN0eWxlKCd6LWluZGV4JywgJy0xJyk7XG5cblx0Zm9yICh2YXIgaSA9IDA7IGkgPCBvcmJBbW91bnQ7IGkrKykge1xuXHRcdG9yYnNbaV0gPSBuZXcgT3JiKCk7XG5cdH1cbn1cblxuLy8gRHJhdy5cbmZ1bmN0aW9uIGRyYXcoKXtcblx0YmFja2dyb3VuZCg0MiwgMjcsIDYxKTtcblxuXHRmb3IgKHZhciBpID0gMDsgaSA8IG9yYnMubGVuZ3RoOyBpKyspIHtcblx0XHRvcmJzW2ldLmRpc3BsYXkoKTtcblx0XHRvcmJzW2ldLnVwZGF0ZSgpO1xuXHRcdG9yYnNbaV0uZWRnZXMoKTtcblx0fVxufVxuXG5mdW5jdGlvbiBzdGFydFRpbWVyKCkge1xuXHR0aW1lciA9IHNldEludGVydmFsKGZhZGVPdXQsIDgwMCk7XG59XG5cbmZ1bmN0aW9uIGZhZGVPdXQoKSB7XG5cdC8vIE5peCBvbGRlc3Qgb3JiIGluIGFycmF5IGFzIGxvbmcgYXMgdGhlcmUncyBtb3JlIHRoYW4gb3JpZ2luYWwgYW1vdW50LlxuXHRpZiAob3Jicy5sZW5ndGggPiBvcmJBbW91bnQgKSB7XG5cdFx0b3Jicy5zcGxpY2UoMCwgMSk7XG5cdH0gZWxzZSB7XG5cdFx0Y2xlYXJJbnRlcnZhbCh0aW1lcik7XG5cdH1cbn1cblxuLy8gQWRkIG9yYnMgb24gbW91c2UgZHJhZy5cbmZ1bmN0aW9uIG1vdXNlRHJhZ2dlZCgpIHtcblx0b3Jicy5wdXNoKG5ldyBPcmIobW91c2VYLCBtb3VzZVkpKTtcbn1cblxuLy8gU3RhcnQgdGltZXIgb24gbW91c2UgcHJlc3MuXG5mdW5jdGlvbiBtb3VzZVByZXNzZWQoKSB7XG5cdHN0YXJ0VGltZXIoKTtcbn1cblxuLy8gKlRIRSBPUkIgKiAvL1xuZnVuY3Rpb24gT3JiKG1vdXNlWD1udWxsLG1vdXNlWT1udWxsKSB7XG5cdC8vIFJhZGl1cy5cblx0dmFyIHJhZGl1cyA9IHJhbmRvbSg4LCAyNCk7XG5cblx0Ly8gQ29sb3VyIFZhcmlhYmxlcy5cblx0dGhpcy5yID0gcmFuZG9tKDE0NSwgMjU1KTtcblx0dGhpcy5nID0gcmFuZG9tKDAsIDE1MCk7XG5cdHRoaXMuYiA9IHJhbmRvbSgyMDAsIDI1NSk7XG5cdHRoaXMuYSA9IHJhbmRvbSgwLCAxMDApO1xuXG5cdC8vIFNldCBwb3NpdGlvbiBvZiBidWJibGUgY3JlYXRpb24gZm9yIG1vdXNlIHBvc2l0aW9uIGJ1dCBzdGFydGluZyBidWJibGVzIHdpbGwgYmUgcmFuZG9tbHkgcG9zaXRpb25lZC5cblx0aWYgKG1vdXNlWCAmJiBtb3VzZVkpIHtcblx0XHR0aGlzLnBvc2l0aW9uID0gY3JlYXRlVmVjdG9yKFxuXHRcdFx0bW91c2VYLCBtb3VzZVlcblx0KX0gZWxzZSB7XG5cdFx0dGhpcy5wb3NpdGlvbiA9IGNyZWF0ZVZlY3Rvcihcblx0XHRcdHJhbmRvbSgwICsgMjAsIHdpZHRoIC0gMjApLFxuXHRcdFx0cmFuZG9tKDAgKyAyMCwgaGVpZ2h0IC0gMjApXG5cdCl9O1xuXG5cdC8vIFN0YXJ0IHcvIHJhbmRvbSBpbml0aWFsIHZlbG9jaXRpZXMuXG5cdHRoaXMudmVsb2NpdHkgPSBjcmVhdGVWZWN0b3IocmFuZG9tKHNwZWVkTWluLCBzcGVlZE1heCkgLyAocmFkaXVzIC8gMS4yKSwgcmFuZG9tKHNwZWVkTWluLCBzcGVlZE1heCkgLyAocmFkaXVzIC8gMS4yKSk7XG5cblx0Ly8gQ29vcmRpbmF0ZXMgdG8gbW92ZSB0b3dhcmRzLlxuXHR2YXIgY29vcmRpbmF0ZSA9IGNyZWF0ZVZlY3RvcihyYW5kb20oMCwgd2lkdGgpLCByYW5kb20oMCwgaGVpZ2h0KSk7XG5cblx0dGhpcy51cGRhdGUgPSBmdW5jdGlvbigpIHtcblx0XHR0aGlzLmFjY2VsZXJhdGlvbiA9IHA1LlZlY3Rvci5zdWIoY29vcmRpbmF0ZSwgdGhpcy5wb3NpdGlvbik7XG5cdFx0dGhpcy5hY2NlbGVyYXRpb24uc2V0TWFnKCh0aGlzLnJhZGl1cykpO1xuXHRcdHRoaXMudmVsb2NpdHkuYWRkKHRoaXMuYWNjZWxlcmF0aW9uKTtcblx0XHR0aGlzLnBvc2l0aW9uLmFkZCh0aGlzLnZlbG9jaXR5KTtcblx0fTtcblxuXHR0aGlzLmRpc3BsYXkgPSBmdW5jdGlvbigpIHtcblx0XHRub1N0cm9rZSgpO1xuXHRcdGZpbGwodGhpcy5yLCB0aGlzLmcsIHRoaXMuYiwgdGhpcy5hKTtcblx0XHRlbGxpcHNlKHRoaXMucG9zaXRpb24ueCwgdGhpcy5wb3NpdGlvbi55LCByYWRpdXMvMiwgcmFkaXVzLzIpO1xuXHRcdGVsbGlwc2UodGhpcy5wb3NpdGlvbi54ICsgMSwgdGhpcy5wb3NpdGlvbi55IC0gMSwgcmFkaXVzLCByYWRpdXMpO1xuXHR9O1xuXG5cdC8vIEtlZXAgaW5zaWRlIGJvcmRlcnMuXG5cdHRoaXMuZWRnZXMgPSBmdW5jdGlvbigpIHtcblx0XHQvLyBUb3AuXG5cdFx0aWYoKChyYWRpdXMgLyAyICogLTEpICsgdGhpcy5wb3NpdGlvbi55KSA8IDApIHtcblx0XHRcdHRoaXMudmVsb2NpdHkueSAqPSAtMTtcblx0XHR9XG5cdFx0Ly8gQm90dG9tLlxuXHRcdGlmKCgocmFkaXVzIC8gMikgKyB0aGlzLnBvc2l0aW9uLnkpID4gaGVpZ2h0KSB7XG5cdFx0XHR0aGlzLnZlbG9jaXR5LnkgKj0gLTE7XG5cdFx0fVxuXHRcdC8vIExlZnQuXG5cdFx0aWYoKChyYWRpdXMgLyAyICogLTEpICsgdGhpcy5wb3NpdGlvbi54KSA8IDApIHtcblx0XHRcdHRoaXMudmVsb2NpdHkueCAqPSAtMTtcblx0XHR9XG5cdFx0Ly8gUmlnaHQuXG5cdFx0aWYoKChyYWRpdXMgLyAyKSArIHRoaXMucG9zaXRpb24ueCkgPiB3aWR0aCkge1xuXHRcdFx0dGhpcy52ZWxvY2l0eS54ICo9IC0xO1xuXHRcdH1cblx0fTtcbn1cblxuLy8gV2luZG93IHJlc2l6ZXIuXG5mdW5jdGlvbiB3aW5kb3dSZXNpemVkKCkge1xuXHRyZXNpemVDYW52YXMod2luZG93V2lkdGgsIDQwMCk7XG59XG4iLCIvKipcbiAqIEZpbGUgc2tpcC1saW5rLWZvY3VzLWZpeC5qcy5cbiAqXG4gKiBIZWxwcyB3aXRoIGFjY2Vzc2liaWxpdHkgZm9yIGtleWJvYXJkIG9ubHkgdXNlcnMuXG4gKlxuICogTGVhcm4gbW9yZTogaHR0cHM6Ly9naXQuaW8vdldkcjJcbiAqL1xuKCBmdW5jdGlvbigpIHtcblx0dmFyIGlzV2Via2l0ID0gbmF2aWdhdG9yLnVzZXJBZ2VudC50b0xvd2VyQ2FzZSgpLmluZGV4T2YoICd3ZWJraXQnICkgPiAtMSxcblx0ICAgIGlzT3BlcmEgID0gbmF2aWdhdG9yLnVzZXJBZ2VudC50b0xvd2VyQ2FzZSgpLmluZGV4T2YoICdvcGVyYScgKSAgPiAtMSxcblx0ICAgIGlzSWUgICAgID0gbmF2aWdhdG9yLnVzZXJBZ2VudC50b0xvd2VyQ2FzZSgpLmluZGV4T2YoICdtc2llJyApICAgPiAtMTtcblxuXHRpZiAoICggaXNXZWJraXQgfHwgaXNPcGVyYSB8fCBpc0llICkgJiYgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQgJiYgd2luZG93LmFkZEV2ZW50TGlzdGVuZXIgKSB7XG5cdFx0d2luZG93LmFkZEV2ZW50TGlzdGVuZXIoICdoYXNoY2hhbmdlJywgZnVuY3Rpb24oKSB7XG5cdFx0XHR2YXIgaWQgPSBsb2NhdGlvbi5oYXNoLnN1YnN0cmluZyggMSApLFxuXHRcdFx0XHRlbGVtZW50O1xuXG5cdFx0XHRpZiAoICEgKCAvXltBLXowLTlfLV0rJC8udGVzdCggaWQgKSApICkge1xuXHRcdFx0XHRyZXR1cm47XG5cdFx0XHR9XG5cblx0XHRcdGVsZW1lbnQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCggaWQgKTtcblxuXHRcdFx0aWYgKCBlbGVtZW50ICkge1xuXHRcdFx0XHRpZiAoICEgKCAvXig/OmF8c2VsZWN0fGlucHV0fGJ1dHRvbnx0ZXh0YXJlYSkkL2kudGVzdCggZWxlbWVudC50YWdOYW1lICkgKSApIHtcblx0XHRcdFx0XHRlbGVtZW50LnRhYkluZGV4ID0gLTE7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRlbGVtZW50LmZvY3VzKCk7XG5cdFx0XHR9XG5cdFx0fSwgZmFsc2UgKTtcblx0fVxufSkoKTsiLCIvKipcbiAqIEZpbGUgc3VwZXItaGVyb2luZS5qc1xuICpcbiAqL1xuY29uc3QgbGlzdE9uZSA9IFsgJ0lORkonLCAnV29yZFByZXNzJywgJ0NyZWF0aXZlJywgJ0NvZGluZycsICdJbmNsdXNpdmUnXTtcbmNvbnN0IGxpc3RUd28gPSBbJ0h1bGEgSG9vcGVyJywgJ1BvZXQnLCAnV3JpdGVyJywgJ0N1cmF0b3InLCAnRGV0ZWN0aXZlJywgJ1RlY2hub2xvZ2lzdCcsICdGZW1pbmlzdCcsICdvZiB0aGUgSW50ZXJuZXQnLCAnQWVzdGhldGljaWFuJywgJ0RheWRyZWFtZXInXTtcblxuY29uc3QgaW50ZXJ2YWwgPSAzMDAwO1xubGV0IHdvcmRIaXN0b3J5ID0gJyc7XG5cbi8vICoqR3JhYiBlbGVtZW50cy5cbmNvbnN0IGNvbnRhaW5lck51bWJlciA9IGRvY3VtZW50LmdldEVsZW1lbnRzQnlDbGFzc05hbWUoICd0ZXh0LXNoaWZ0aW5nJyApO1xuXG5pZGVudGl0eUN5Y2xlKCBjb250YWluZXJOdW1iZXJbMF0sIGxpc3RPbmUgKTtcblxuLy8gU3RhZ2dlciBzd2l0Y2hpbmcgdGltaW5nLlxuc2V0VGltZW91dCggZnVuY3Rpb24oKSB7XG5cdGlkZW50aXR5Q3ljbGUoIGNvbnRhaW5lck51bWJlclsxXSwgbGlzdFR3byApO1xuXG59LCBpbnRlcnZhbC8yICk7XG5cbi8vICoqU3RhcnQgaXQgb2ZmLlxuZnVuY3Rpb24gaWRlbnRpdHlDeWNsZSggY29udGFpbmVyLCB3aGljaExpc3QgKSB7XG5cblx0c2V0SW50ZXJ2YWwoIGZ1bmN0aW9uKCkge1xuXHRcdHJlcGxhY2VDb250ZW50KCBjb250YWluZXIsIHdoaWNoTGlzdCApO1xuXHR9LCBpbnRlcnZhbCApO1xufTtcblxuLy8gKipDaG9vc2UgcmFuZG9tIHdvcmQgZnJvbSBjaG9zZW4gYXJyYXkuXG5mdW5jdGlvbiBnZXRSYW5kb21Xb3JkcyggbGlzdENob2ljZSApIHtcblx0Y29uc3Qgd29yZCA9IGxpc3RDaG9pY2VbTWF0aC5mbG9vciggTWF0aC5yYW5kb20oKSpsaXN0Q2hvaWNlLmxlbmd0aCApXTtcblx0cmV0dXJuIHdvcmQ7XG59XG5cbi8vICoqTWFya3VwIFJlcGxhY2VtZW50LlxuZnVuY3Rpb24gcmVwbGFjZUNvbnRlbnQoIGNvbnRhaW5lciwgd2hpY2hMaXN0ICkge1xuXG5cdGNvbnN0IGlkZW50aXR5ID0gZ2V0UmFuZG9tV29yZHMoIHdoaWNoTGlzdCApO1xuXHRjb25zdCBub1JlcGVhdCA9IGNvbXBhcmVXb3JkcyhpZGVudGl0eSk7XG5cblx0Ly8gKipSZXBsYWNlLlxuXHRpZiggbm9SZXBlYXQgKSB7XG5cdFx0Y29udGFpbmVyLnRleHRDb250ZW50ID0gaWRlbnRpdHk7XG5cdH0gZWxzZSB7XG5cdFx0cmVwbGFjZUNvbnRlbnQoIGNvbnRhaW5lciApO1xuXHR9XG5cblx0d29yZEhpc3RvcnkgPSBpZGVudGl0eTtcbn1cblxuZnVuY3Rpb24gY29tcGFyZVdvcmRzKCBjdXJyZW50V29yZCApIHtcblx0aWYoIGN1cnJlbnRXb3JkID09PSB3b3JkSGlzdG9yeSApIHtcblx0XHRyZXR1cm4gZmFsc2U7XG5cdH0gZWxzZSB7XG5cdFx0cmV0dXJuIHRydWU7XG5cdH1cbn1cbiIsIi8qKlxuICogRmlsZSB3aW5kb3ctcmVhZHkuanNcbiAqXG4gKiBBZGQgYSBcInJlYWR5XCIgY2xhc3MgdG8gPGJvZHk+IHdoZW4gd2luZG93IGlzIHJlYWR5LlxuICovXG53aW5kb3cuV2luZG93X1JlYWR5ID0ge307XG4oIGZ1bmN0aW9uKCB3aW5kb3csICQsIHRoYXQgKSB7XG5cblx0Ly8gQ29uc3RydWN0b3IuXG5cdHRoYXQuaW5pdCA9IGZ1bmN0aW9uKCkge1xuXHRcdHRoYXQuY2FjaGUoKTtcblx0XHR0aGF0LmJpbmRFdmVudHMoKTtcblx0fTtcblxuXHQvLyBDYWNoZSBkb2N1bWVudCBlbGVtZW50cy5cblx0dGhhdC5jYWNoZSA9IGZ1bmN0aW9uKCkge1xuXHRcdHRoYXQuJGMgPSB7XG5cdFx0XHR3aW5kb3c6ICQod2luZG93KSxcblx0XHRcdGJvZHk6ICQoZG9jdW1lbnQuYm9keSksXG5cdFx0fTtcblx0fTtcblxuXHQvLyBDb21iaW5lIGFsbCBldmVudHMuXG5cdHRoYXQuYmluZEV2ZW50cyA9IGZ1bmN0aW9uKCkge1xuXHRcdHRoYXQuJGMud2luZG93LmxvYWQoIHRoYXQuYWRkQm9keUNsYXNzICk7XG5cdH07XG5cblx0Ly8gQWRkIGEgY2xhc3MgdG8gPGJvZHk+LlxuXHR0aGF0LmFkZEJvZHlDbGFzcyA9IGZ1bmN0aW9uKCkge1xuXHRcdHRoYXQuJGMuYm9keS5hZGRDbGFzcyggJ3JlYWR5JyApO1xuXHR9O1xuXG5cdC8vIEVuZ2FnZSFcblx0JCggdGhhdC5pbml0ICk7XG5cbn0pKCB3aW5kb3csIGpRdWVyeSwgd2luZG93LldpbmRvd19SZWFkeSApOyJdfQ==
