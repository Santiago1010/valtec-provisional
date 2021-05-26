<template>

	<div>

		<v-app-bar dark color="oscuro" style="max-height: 60px; position: relative; z-index: 2;">

			<v-app-bar-nav-icon @click="menuLateral = true"></v-app-bar-nav-icon>

			<router-link to='/'><v-toolbar-title><img src="../assets/imagenes/logos/isologo.png" style="max-height: 50px; margin-top: 5px;"></v-toolbar-title></router-link>

			<v-spacer></v-spacer>

			<img src="../assets/imagenes/logos/sena.png" style="max-height: 50px; margin-top: 0px;">

		</v-app-bar>

		<v-navigation-drawer color="oscuro" dark app v-model="menuLateral" absolute temporary>

			<v-list nav dense>

				<v-list-item-group active-class="orange accent-4--text text--accent-4">

					<v-divider></v-divider>

					<v-list-item to='/inicio'>

						<v-list-item-icon>

							<v-icon>not_started</v-icon>

						</v-list-item-icon>

						<v-list-item-title>Inicio</v-list-item-title>

					</v-list-item>

					<v-list-item to='/inicio/resultados'>

						<v-list-item-icon>

							<v-icon>dns</v-icon>

						</v-list-item-icon>

						<v-list-item-title>Resultados de investigación</v-list-item-title>

					</v-list-item>

					<v-list-item to='/inicio/nuevoResultado'>

						<v-list-item-icon>

							<v-icon>group_work</v-icon>

						</v-list-item-icon>

						<v-list-item-title>Registrar resultado de investigación</v-list-item-title>

					</v-list-item>

					<v-list-item to='/inicio/usuario'>

						<v-list-item-icon>

							<v-icon>account_circle</v-icon>

						</v-list-item-icon>

						<v-list-item-title>Información de usuario</v-list-item-title>

					</v-list-item>

				</v-list-item-group>

				<v-divider></v-divider>

				<v-list-item @click="cerrarSesion">

					<v-list-item-icon>

						<v-icon>cancel</v-icon>

					</v-list-item-icon>

					<v-list-item-title>Cerrar Sesión</v-list-item-title>

				</v-list-item>

			</v-list>

		</v-navigation-drawer>

	</div>

</template>

<script>
	import { mapActions } from 'vuex'
	export default {
		name: 'MenuIndex',
		data: () => ({
			menuLateral: false,
		}),
		methods: {
			...mapActions(['eliminarSesion']),
			cerrarSesion: function() {
				
				this.menuLateral = false
				this.eliminarSesion();
				this.$router.push('/');
			}
		}
	};
</script>