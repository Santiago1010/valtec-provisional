<template>
	<div class="fondoRegistro">
		<app-stepper></app-stepper>
	</div>
</template>

<script>
	import StepperRegistro from '../components/StepperRegistro.vue';
	import MenuIndex from '../components/MenuIndex.vue';

	export default {
		name: 'Registro',
		components: {
			'app-stepper': StepperRegistro
		},
		data: () => ({
			menuLateral: false,
		})
	}
</script>

<style>
	.fondoRegistro {
		background-image: url('../assets/imagenes/fondos/fondo_centro.png');
		min-height: 100vh;
		background-size: cover;
	}
</style>