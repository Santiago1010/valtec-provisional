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

<template>

	<div>
		
		<app-menu></app-menu>

		<v-container dark class="fondoNegro">
			
			<vue-particles style="position: absolute; z-index: 0; width: 100%; height: 100%; top: 0; left: 0; max-height: 100%;" color="#000000"></vue-particles>

			<div class="contenedor">
				
				<h1 class="tituloFranjaNaranja">VALTEC 3.1</h1>

				<p>Últimas mejoras desarrolladas:</p>

				<v-container class="mb-5">

					<ul>

						<li>Se ha creado una regla de validación en el registro de usuario que no permite ingresar una cuenta de correo electrónico distina a <span>sena.edu.co</span>, o <span>misena.edu.co</span>.</li>
						<li>Se ha agregado el logo de SENA en todas las páginas.</li>
						<li>Sistema de enrutamiento más fluido y estable.</li>
						<li>Se ha actualizado el reporte específico. La información del Resultado de Investigación se muestra en la primera página, el avance de la TRL del Resultado de la Investigación se muestra en la segunda página y la información presupuestal se puede encontrar en la tercera y última página.</li>
						<li>Se ha corregido el problema de cotejamiento de los registros, lo que hacía que se vieran caracteres extraños en los datos de los Resultados de Investigación.</li>
						<li>Debido a un error en el cambio de servidor, las TRL pasaron a estar registradas como <span>0</span>, con pocas excepciones. En estos casos, se han vuelto a modificar a <span>TRL 1</span>.</li>
						<li>La regional "<span>Bogotá</span>", cambió su nombre a "<span>Distrito Capital</span>".</li>
						<li>Se han actualizados los textos a un color blanco para hacer contraste con el nuevo fondo.</li>
						
					</ul>

					<h2 style="margin: 50px 0; padding: 10px 0; color: #FFFFFF; border-top: 2px solid #FF6B00; border-bottom: 2px solid #FF6B00; text-align: center;">¡MENSAJE IMPORTANTE!</h2>

					<p>Ha ocurrido un incoveniente con la base de datos y los apellidos de los usuarios registrados antes del 06 de Diciembre del año 2020, fueron cambiados por el nombre. Se solicita a los usuarios, que por favor accedan a la página <span style="color: #FF6B00; cursor: pointer;" @click="abrirInformacionUsuario">Información usuario (o haciendo click en esta sección resaltada)</span> para poder actualizar el apellido y verificar si los otros datos son correctos.</p>

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

			this.verificarInicio();

		},
		methods: {

			...mapActions(['verificarInicio']),

			abrirInformacionUsuario: function() {

				this.$router.push('/inicio/usuario');

			}

		}

	}

</script>