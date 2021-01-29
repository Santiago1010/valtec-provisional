<style>
	
	.fondoRegistro {

		background-image: url('../assets/imagenes/fondos/fondo_centro.png');
		min-height: 100vh;
		background-size: cover;

	}

</style>

<template>

	<div class="fondoRegistro">

		<app-menu></app-menu>
		
		<app-stepper></app-stepper>

	</div>

</template>

<script>

	import StepperRegistro from '../components/StepperRegistro.vue';

	import MenuIndex from '../components/MenuIndex.vue';

	export default {

		name: 'Registro',
		components: {

			'app-stepper': StepperRegistro,
			'app-menu': MenuIndex,

		},
		data: () => ({

			menuLateral: false,

		})

	}

</script>