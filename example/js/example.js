'use strict';

// array /*
var            array = [
	'a',
	'b',
	'c'
];

// */ object
var object = {
	string: 'hello',
	number: 3.14,
	object: {},
	array: []
};

/* function */
var hello = function (name) {
	console.log('hello ' + name); /* function */
}

function cast (func, param) {
	func(param); // function
}

/**
// * function
// */
cast(hello, 'tony');

cast(function (name) {
	console.log('My name is ' + name);
}, 'mary');

if (object != undefined) {
	console.log('undefined');
}

var i = 0;
while (i < 3) {
	console.log(i);
	i++;
}

var i = 0;
do {
	console.log(i);
	i++;
} while (i < 2);

for (var i = 0;i < 3;i++) {
	console.log(i);
}

var i = 0;
switch (i) {
	case 0:
		console.log('a');
		break;
	default:
		console.log('b');
}