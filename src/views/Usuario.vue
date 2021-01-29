<template>

	<div>
		
		<app-menu></app-menu>

		<v-container dark class="fondoNegro">

			<vue-particles style="position: fixed; z-index: 0; width: 100%; height: 100%; top: 0; left: 0; max-height: 100%;" color="#D3D3D3"></vue-particles>

			<div class="contenedor">

				<app-usuario></app-usuario>

			</div>

		</v-container>

	</div>

</template>

<script>

	import MenuSesion from '../components/MenuSesion.vue';

	import FormularioUsuario from '../components/FormularioUsuario.vue'

	export default {

		name: 'Inicio',
		components: {

			'app-menu': MenuSesion,
			'app-usuario': FormularioUsuario,

		},
		data: () => ({

			menuLateral: false,

		})

	}

</script>