<template>
	<div>
		<v-container dark class="fondoNegro">
			<vue-particles style="position: absolute; z-index: 0; width: 100%; height: 100%; top: 0; left: 0; max-height: 100%;" color="#000000"></vue-particles>
			<div class="contenedor">
				<h1 class="tituloFranjaNaranja">VALTEC 3.4</h1>
				<p>Últimas mejoras desarrolladas:</p>
				<v-container class="mb-5">
					<ul>
						<li>Se han cambiado el nombre de ciertos roles para adaptarse a los lineamientos SENNOVA 2021.</li>
						<li>Se mejoró la lógica algorítima y técnica interna de ValTec.</li>
						<li>Se aumentó la seguridad en las consultas.</li>
						<li>Al recargar la página, la sesión no se cerrará.</li>
						<li>Ahora todos los formulario (a excepción del filtro de los resultados de investigación) se pueden enviar presionando enter, o dando click en el botón.</li>
						<li>El filtro de los resultados de investigación, se aplica ahora al darle click al botón.</li>
						<li>Se implementó la "<span>Calculadora de TRL</span>".</li>
					</ul>
				</v-container>
			</div>
		</v-container>
	</div>
</template>

<script>
	import MenuSesion from '../components/MenuSesion.vue';
	import { mapActions, mapGetters } from 'vuex'

	export default {
		name: 'Inicio',
		components: {
			'app-menu': MenuSesion,
		},
		data: () => ({
			menuLateral: false,
		}),
	    computed: {
	    	...mapGetters(['documento', 'rol']),
	    },
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
		min-width: 100%;
		max-width: 100%;
		padding: 1em;
		overflow-x: hidden;
		text-align: justify;
	}

	.fondoNegro .contenedor .tituloFranjaNaranja {
		font-size: 4em;
		text-align: center;
		border-bottom: 4px solid #FF6B00;
		border-radius: 5px;
		margin-bottom: 20px;
		color: #FFFFFF;
	}

	.fondoNegro .contenedor p,
	.fondoNegro .contenedor ul li {
		color: #FFFFFF;
	}

	.fondoNegro .contenedor ul li span {
		color: #FF6B00;
	}
</style>