<style>
	
	.fondoContrasena {

		background-image: url('../assets/imagenes/fondos/fondo_centro.png');
		min-height: 100vh;
		background-size: cover;

	}

</style>

<template>

	<div class="fondoContrasena">

		<app-menu></app-menu>
		
		<app-stepper></app-stepper>

	</div>

</template>

<script>

	import StepperContrasena from '../components/StepperContrasena.vue';

	import MenuIndex from '../components/MenuIndex.vue';

	export default {

		name: 'Contrasena',
		components: {

			'app-stepper': StepperContrasena,
			'app-menu': MenuIndex,

		},
		data: () => ({

			menuLateral: false,

		})

	}

</script>