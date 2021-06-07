<template>
	<div>
		<v-container dark class="fondoNegro">
			<vue-particles style="position: fixed; z-index: 0; width: 100%; height: 100%; top: 0; left: 0; max-height: 100%;" color="#D3D3D3"></vue-particles>
			<div class="contenedor">
				<app-stepper></app-stepper>
			</div>
		</v-container>
	</div>
</template>

<script>
	import StepperValidacion from '../components/StepperValidacion.vue';
	import { mapActions } from 'vuex'

	export default {
		name: 'Validacion',
		components: {
			'app-stepper': StepperValidacion,
		},
		data: () => ({
			menuLateral: false,
		}),
		mounted() {
			this.verificarInicio();
		},
		methods: {
			...mapActions(['verificarInicio']),
		}
	}
</script>

<style>
	.fondoNegro {
		background-color: #5A5A5A;
		min-height: calc(100vh - 60px);
		min-width: 100%;
		max-width: 100%;
		text-align: justify;
		position: sticky;
	}
	.fondoNegro .contenedor {
		position: relative;
		color: #FFFFFF;
		min-height: calc(100vh - 60px);
		max-height: 100vh;
		min-width: 100%;
		max-width: 100%;
		padding: 1em;
		overflow-x: hidden;
		text-align: justify;
		overflow-y: auto;
	}
	.fondoNegro .contenedor .tituloFranjaNaranja {
		font-size: 4em;
		text-align: center;
		border-bottom: 4px solid #FF6B00;
		border-radius: 5px;
		margin-bottom: 20px;
	}
	.centrado {
		text-align: center;
	}
	h3.centrado {
		padding: 1em;
	}
</style>