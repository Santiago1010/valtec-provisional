<template>
	<div class="fondoContrasena">
		<app-stepper></app-stepper>
	</div>
</template>

<script>
	import StepperContrasena from '../components/StepperContrasena.vue';

	export default {
		name: 'Contrasena',
		components: {
			'app-stepper': StepperContrasena,
		},
		data: () => ({
			menuLateral: false,
		})
	}
</script>

<style>
	.fondoContrasena {
		background-image: url('../assets/imagenes/fondos/fondo_centro.png');
		min-height: calc(100vh - 6.9%);
		background-size: cover;
	}
</style>