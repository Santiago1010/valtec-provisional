<style>

.fondoContrasena {

	background-image: url('../assets/imagenes/fondos/fondo_centro.png');
	min-height: 100vh;
	background-size: cover;

}

</style>

<template>

	<div class="fondoContrasena">

		<app-menu></app-menu>

		<br><br>
		
		<v-stepper style="max-width: 600px; margin: auto;" v-model="e1">

			<v-stepper-header>

				<v-divider></v-divider>

				<v-stepper-step @click="e1 = 2" :complete="e1 > 2" step="2">Escribir la nueva contraseña</v-stepper-step>

				<v-divider></v-divider>

			</v-stepper-header>

			<v-stepper-items>

				<v-stepper-content step="2">

					<v-text-field v-model="numeroDocumento" :rules="documentoValidacion" label="Documento" required readonly disabled></v-text-field>

					<v-text-field v-model="contrasenaNuevaRecuperar" type="password" :rules="contrasenaNuevaValidacionRecuperar" label="Contraseña que usará en la plataforma" counter required></v-text-field>

					<v-text-field v-model="confirmarContrasenaRecuperar" :rules="confirmarContrasenaValidacionRecuperar" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Confirme la contraseña" counter @click:append="show1 = !show1" required></v-text-field>

					<br/>

					<v-btn color="primary" @click="cambiarContrasena">Recuperar</v-btn>

					<v-btn class="ml-4" dark color="institucional" to="/">Cancelar</v-btn>

				</v-stepper-content>

			</v-stepper-items>

		</v-stepper>

		<v-snackbar v-model="snackbar">

			{{ textoSnackbar }}

			<template v-slot:action="{ attrs }">

				<v-btn color="institucional" text v-bind="attrs" @click="snackbar = false">

					Cerrar

				</v-btn>

			</template>

		</v-snackbar>

	</div>

</template>

<script>

	import MenuIndex from '../components/MenuIndex.vue';
	import { mapGetters } from 'vuex';

	export default {

		components: {

			'app-menu': MenuIndex,

		},
		data () {

			return {

				e1: 2,
				show1: false,
				numeroDocumento: 0,
				documentoValidacion: [

				v => !!v || 'El número de documento es requerido.',
				v => /^([0-9])*$/.test(v) || 'El número de documento no puede contener caracteres alfabéticos.',

				],
				contrasenaNuevaRecuperar: '',
				contrasenaNuevaValidacionRecuperar: [

				v => !!v || 'La contraseña es obligatoria.',
				v => (v && v.length >= 8) || 'La contraseña debe tener más de 8 caracteres.',

				],
				confirmarContrasenaRecuperar: '',
				confirmarContrasenaValidacionRecuperar: [

				v => !!v || 'La confirmación es obligatoria.',
				v => (this.contrasenaNuevaRecuperar == this.confirmarContrasenaRecuperar) || 'Las contraseñas no coinciden.',

				],
				snackbar: false,
				textoSnackbar: '',

			}

		},
		mounted() {

			this.consultarPersona();

		},
		computed: {

			...mapGetters(['ruta']),

		},
		methods: {

			consultarPersona: function() {

				axios.post(this.ruta + 'recepcionContrasena.php', {tokenValidar:this.$route.params.token}).then(response => {

					if (response.data != false) {

						this.numeroDocumento = response.data;

					}else {

						window.location.href = '/';

					}

				});

			},

			cambiarContrasena: function() {

				if (this.contrasenaNuevaRecuperar == this.confirmarContrasenaRecuperar && this.numeroDocumento != "" && this.numeroDocumento != null && this.numeroDocumento != 0) {

					axios.post(this.ruta + 'recepcionContrasena.php', {documento:this.numeroDocumento, nueva:this.contrasenaNuevaRecuperar, confirmar:this.confirmarContrasenaRecuperar}).then(response => {

						this.snackbar = true;
						this.textoSnackbar = response.data;

						if (response.data == "La contraseña se ha cambiado.") {

							window.location.href = '/';

						}

					});

				}

			}

		}

	}

</script>