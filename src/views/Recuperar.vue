<template>
	<div class="fondoContrasena" style="padding-top: 4em;">
		<v-stepper style="max-width: 600px; margin: auto;" v-model="e1">
			<v-stepper-header>
				<v-divider></v-divider>
				<v-stepper-step @click="e1 = 2" :complete="e1 > 2" step="2">Escribir la nueva contraseña</v-stepper-step>
				<v-divider></v-divider>
			</v-stepper-header>

			<v-stepper-items>
				<v-stepper-content step="2">
					<v-text-field v-model="numeroDocumento" :rules="[rules.required, rules.validationDocument]" label="Documento" required readonly disabled></v-text-field>
					<v-text-field v-model="contrasenaNuevaRecuperar" type="password" :rules="[rules.required, rules.minPassword]" label="Contraseña que usará en la plataforma" counter required></v-text-field>
					<v-text-field v-model="confirmarContrasenaRecuperar" :rules="[rules.required, rules.minPassword, rules.confirmPassword]" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Confirme la contraseña" counter @click:append="show1 = !show1" required></v-text-field>
					<br/>
					<v-btn color="primary" @click="cambiarContrasena">Recuperar</v-btn>
					<v-btn class="ml-4" dark color="institucional" to="/">Cancelar</v-btn>
				</v-stepper-content>
			</v-stepper-items>
		</v-stepper>
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
				rules: {
					required: v => !!v || 'Este campo es requerido.',
					validationDocument: v => (v && v.length <= 10) || 'La cantidad de números no es válida.',
					minPassword: v => v.length >= 8 || 'La contraseña debe tener mínimo 8 caracteres.',
					confirmPassword: v => (this.passwordUser == this.confirmPassword) || 'Las contraseñas no coinciden.'
				}
			}
		},
		mounted() {
			this.consultarPersona();
		},
		computed: {
			...mapGetters(['route']),
		},
		methods: {
			consultarPersona: function() {
				axios.post(this.route + 'recepcionContrasena.php', { tokenValidar:this.$route.params.token }).then(response => {
					if (response.data != false) {
						this.numeroDocumento = response.data;
					}else {
						window.location.href = '/';
					}
				});
			},
			cambiarContrasena: function() {
				if (this.contrasenaNuevaRecuperar == this.confirmarContrasenaRecuperar && this.numeroDocumento != "" && this.numeroDocumento != null && this.numeroDocumento != 0) {
					axios.post(this.route + 'recepcionContrasena.php', {documento:this.numeroDocumento, nueva:this.contrasenaNuevaRecuperar, confirmar:this.confirmarContrasenaRecuperar}).then(response => {
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

<style>
	.fondoContrasena {
		background-image: url('../assets/imagenes/fondos/fondo_centro.png');
		min-height: 100vh;
		background-size: cover;
	}
</style>