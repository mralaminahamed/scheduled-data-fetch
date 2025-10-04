module.exports = {
	extends: [
		'plugin:@wordpress/eslint-plugin/recommended',
		'plugin:@wordpress/eslint-plugin/esnext',
		'plugin:@wordpress/eslint-plugin/i18n',
		'plugin:@wordpress/eslint-plugin/react',
	],
	env: {
		browser: true,
		es6: true,
		node: true,
		jquery: true,
	},
	globals: {
		wp: 'readonly',
		scheduledDataFetch: 'readonly',
		ajaxurl: 'readonly',
		console: 'readonly',
	},
	parserOptions: {
		ecmaVersion: 2020,
		sourceType: 'module',
	},
	rules: {
		// Custom rules for this project
		'no-console': 'warn',
		'no-debugger': 'error',
		'prefer-const': 'error',
		'no-var': 'error',
		'object-shorthand': 'error',
		'prefer-arrow-callback': 'error',
		'arrow-spacing': 'error',
		'prefer-template': 'error',

		'prettier/prettier': 'off',

		// WordPress specific
		'@wordpress/no-unused-vars-before-return': 'error',
		'@wordpress/valid-sprintf': 'error',
		'@wordpress/i18n-text-domain': [ 'error', {
			allowedTextDomain: 'scheduled-data-fetch',
		} ],
		'@wordpress/i18n-translator-comments': 'error',
		'@wordpress/i18n-no-variables': 'error',
		'@wordpress/i18n-no-placeholders-only': 'error',
		'@wordpress/i18n-ellipsis': 'error',
	},
	overrides: [
		{
			files: [ '**/*.test.js', '**/*.spec.js' ],
			env: {
				jest: true,
			},
		},
	],
};
