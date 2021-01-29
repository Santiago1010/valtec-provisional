<style>

* {

	text-align: justify;

}

.fondoRegistro {

	background-image: url('../assets/imagenes/fondos/fondo_registro.png');
	min-height: 100vh;
	background-size: cover;

}

</style>

<template>

	<div class="fondoRegistro">

		<app-menu></app-menu>

		<v-container>

			<v-stepper class="mt-10" style="max-width: 600px; margin: auto;" v-model="e1">

				<v-stepper-header>

					<v-divider></v-divider>

					<v-stepper-step @click="e1 = 2" :complete="e1 > 2" step="2">Confirmar datos</v-stepper-step>

					<v-divider></v-divider>

				</v-stepper-header>

				<v-stepper-items>

					<v-stepper-content step="2">

						{{ textoConfirmacion }}

					</v-stepper-content>

				</v-stepper-items>

			</v-stepper>

		</v-container>

	</div>

</template>

<script>

	import MenuIndex from '../components/MenuIndex.vue';

	import { mapGetters } from 'vuex';

	export default {

		name: 'Confirmar',
		components: {

			'app-menu': MenuIndex,

		},
		data: () => ({

			e1: 2,
			menuLateral: false,
			textoConfirmacion: '',

		}),
		mounted() {

			this.confirmarUsuario();

		},
		computed: {

			...mapGetters(['ruta']),

		},
		methods: {

			confirmarUsuario: function() {

				axios.post(this.ruta + 'recepcionRegistro.php', {tokenUsuario:this.$route.params.token}).then(response => {

					this.textoConfirmacion = response.data;

					if (response.data == false) {

						window.location.href = '/';

					}

				});

			}

		}

	}

</script>