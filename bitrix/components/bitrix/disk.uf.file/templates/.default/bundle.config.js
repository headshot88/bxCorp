module.exports = {
	input: './src/index.js',
	output: './script.js',
	namespace: 'BX.Disk.UF',
	adjustConfigPhp: false,
	namespaceFunction: null,
	protected: true,
	concat: {
		js: [
			'./script.js',
			'./script-old.js',
		],
	}
};