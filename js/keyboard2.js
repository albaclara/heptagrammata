$.keyboard.keyaction.undo = function (base) {
	base.execCommand('undo');
	return false;
};
$.keyboard.keyaction.redo = function (base) {
	base.execCommand('redo');
	return false;
};

$('#contenteditable').keyboard({
	usePreview: true, // disabled for contenteditable
	useCombos: false,
	autoAccept: true,
	layout: 'custom',
	customLayout: {
		'normal': [
			'` 1 2 3 4 5 6 7 8 9 0 - = {del} {b}',
			'{tab} q w e r t y u i o p [ ] \\',
			'a s d f g h j k l ; \' {enter}',
			'{shift} z x c v b n m , . / {shift}',
			'{accept} {space} {left} {right} {undo:Undo} {redo:Redo}'
		],
		'shift': [
			'~ ! @ # $ % ^ & * ( ) _ + {del} {b}',
			'{tab} Q W E R T Y U I O P { } |',
			'A S D F G H J K L : " {enter}',
			'{shift} Z X C V B N M < > ? {shift}',
			'{accept} {space} {left} {right} {undo:Undo} {redo:Redo}'
		]
	},
	display: {
		del: '\u2326:Delete',
		redo: '↻',
		undo: '↺'
	}
})
.addTyping();