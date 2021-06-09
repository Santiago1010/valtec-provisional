<template>
	<div>
		<v-container dark class="fondoNegro">
			<vue-particles style="position: fixed; z-index: 0; width: 100%; height: 100%; top: 0; left: 0; max-height: 100%;" color="#D3D3D3"></vue-particles>
			<div class="contenedor">
				<app-usuario></app-usuario>
			</div>
		</v-container>
	</div>
</template>

<script>
	import FormularioUsuario from '../components/FormularioUsuario.vue'

	export default {
		name: 'Usuario',
		components: {
			'app-usuario': FormularioUsuario,
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