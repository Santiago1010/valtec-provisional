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
					<v-form ref="formRecoverPassword" v-model="formRecoverPassword" lazy-validation>
						<v-text-field v-model="documentUserPassword" :rules="[rules.required, rules.validationDocument]" label="Documento" required readonly disabled></v-text-field>
						<v-text-field v-model="newPasswordUser" type="password" :rules="[rules.required, rules.minPassword]" label="Contraseña que usará en la plataforma" counter required></v-text-field>
						<v-text-field v-model="confirmNewPassword" :rules="[rules.required, rules.minPassword, rules.confirmPassword]" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Confirme la contraseña" counter @click:append="show1 = !show1" required></v-text-field>
						<br/>
						<v-btn type="submit" :disabled="!formRecoverPassword" color="primary" @click="validate" @submit="validate">Recuperar</v-btn>
						<v-btn class="ml-4" dark color="institucional" to="/">Cancelar</v-btn>
					</v-form>
				</v-stepper-content>
			</v-stepper-items>
		</v-stepper>
	</div>
</template>

<script>
	import MenuIndex from '../components/MenuIndex.vue';
	import { mapGetters, mapActions } from 'vuex';

	export default {
		components: {
			'app-menu': MenuIndex,
		},
		data () {
			return {
				e1: 2,
				show1: false,
				formRecoverPassword: true,
				documentUserPassword: '',
				newPasswordUser: '',
				confirmNewPassword: '',
				rules: {
					required: v => !!v || 'Este campo es requerido.',
					validationDocument: v => (v && v.length <= 10) || 'La cantidad de números no es válida.',
					minPassword: v => v.length >= 8 || 'La contraseña debe tener mínimo 8 caracteres.',
					confirmPassword: v => (this.newPasswordUser == this.confirmNewPassword) || 'Las contraseñas no coinciden.'
				}
			}
		},
		mounted() {
			this.readPerson();
		},
		computed: {
			...mapGetters(['route']),
		},
		methods: {
			...mapActions(['modifyTextSnackbar', 'modifyStateSnackbar']),
			readPerson() {
				axios.post(this.route + 'receivers/receptionUsers.php', { typeFunction:'readPersonPassword', tokenUser:this.$route.params.token }).then(response => {
					if (response.data != false) {
						this.documentUserPassword = response.data.documento_usuario;
					}else {
						window.location.href = '/';
					}
					console.log(response.data)
				});
			},
			updatePassword() {
				axios.post(this.route + 'receivers/receptionUsers.php', { typeFunction:'updateUserPassword', documentUser:this.documentUserPassword, newPassword:this.newPasswordUser, confirmNewPassword:this.confirmNewPassword }).then(response => {
					if (response.data == 1) {
						this.modifyStateSnackbar(false);
						this.modifyStateSnackbar(true);
						this.modifyTextSnackbar('Se ha cambiado la contraseña.');
						this.reset();
					}
				});
			},
			validate (event) {
				event.preventDefault();
				this.$refs.formRecoverPassword.validate() ? this.updatePassword() : false;
			},
			reset () {
				this.$refs.formRecoverPassword.reset()
			},
			resetValidation () {
				this.$refs.formRecoverPassword.resetValidation()
			},
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