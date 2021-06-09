<template>
	<div>
		<v-container dark class="fondoNegro">
			<vue-particles style="position: fixed; z-index: 0; width: 100%; height: 100%; top: 0; left: 0; max-height: 100%;" color="#D3D3D3"></vue-particles>
			<div class="contenedor">
				<app-lista></app-lista>
			</div>
		</v-container>
	</div>
</template>

<script>
	import FormularioFiltrosResultados from '../components/FormularioFiltrosResultados.vue';
	import ListaResultados from '../components/ListaResultados.vue';
	import MenuSesion from '../components/MenuSesion.vue';
	import { mapActions } from 'vuex'

	export default {
		name: 'Inicio',
		components: {
			'app-filtros': FormularioFiltrosResultados,
			'app-lista': ListaResultados,
			'app-menu': MenuSesion,
		},
		data: () => ({
			menuLateral: false,
		}),
		mounted() {
			this.validateSession();
		},
		methods: {
			validateSession: function() {
				if (localStorage.document == undefined || localStorage.email == undefined || localStorage.name == undefined || localStorage.lastName == undefined || localStorage.role == undefined || localStorage.session == false) {
					window.location.href = '/';
				}
			},
		}
	}
</script>

<style>
	.fondoNegro {
		background-color: #5A5A5A;
		min-height: calc(100vh - 60px);
		max-height: 100%;
		min-width: 100%;
		max-width: 100%;
		text-align: justify;
	}
	.fondoNegro .contenedor {
		position: relative;
		color: #000000;
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