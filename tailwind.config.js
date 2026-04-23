/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./*.php',
		'./template-parts/**/*.php',
		'./inc/**/*.php',
		'./assets/js/**/*.js',
	],
	theme: {
		extend: {},
	},
	corePlugins: {
		// Disable Tailwind's default container so our style.css .container takes full control
		container: false,
	},
	plugins: [],
};
