<template>
	<div>
		<div class="contenedor">
			<br>
			<v-divider dark></v-divider>
			<h2 style="color: #FFFFFF;">DATOS DEL USUARIO</h2>
			<v-divider dark></v-divider>
			<v-form v-model="formDataUser" ref="formDataUser" lazy-validation>
				<v-row>
					<v-col cols="12" md="6">
						<v-select dark v-model="user.documentTypeUser" :items="documentTypes" :rules="[rules.validVoid]" label="Tipo de documento" autocomplete="off" required></v-select>
					</v-col>
					<v-col cols="12" md="6">
						<v-text-field dark v-model="user.documentUser" :rules="[rules.validVoid, rules.validNumber, rules.validLengthDocument]" label="Documento del usuario" autocomplete="off" required readonly disabled></v-text-field>
					</v-col>
				</v-row>

				<v-row>
					<v-col cols="12" md="6">
						<v-text-field dark v-model="user.nameUser" :rules="[rules.validVoid, rules.validText]" label="Nombre(s) del usuario" autocomplete="off" required></v-text-field>
					</v-col>
					<v-col cols="12" md="6">
						<v-text-field dark v-model="user.lastNameUser" :rules="[rules.validVoid, rules.validText]" label="Apellido(s) del usuario" autocomplete="off" required></v-text-field>
					</v-col>
				</v-row>

				<v-row>
					<v-col cols="12" md="6">
						<v-text-field dark v-model="user.phoneUser" :rules="[rules.validVoid, rules.validLengthDocument, rules.validNumber]" label="Número de contacto" autocomplete="off" required></v-text-field>
					</v-col>
					<v-col cols="12" md="6">
						<v-text-field dark v-model="user.emailUser" :rules="[rules.validVoid, rules.validEmail]" label="Correo del usuario" autocomplete="off" required></v-text-field>
					</v-col>

				</v-row>

				<v-row v-if="changePassword == true">
					<v-col cols="12" md="3">
						<v-text-field dark v-model="newPasswordUser" :rules="[rules.validVoid, rules.validPassword]" type="password" label="Contraseña nueva" counter autocomplete="off" required></v-text-field>
					</v-col>
					<v-col cols="12" md="3">
						<v-text-field dark v-model="confirmPasswordUser" :rules="[rules.validVoid, rules.validPassword]" type="password" label="Confirmar contraseña" counter autocomplete="off" required></v-text-field>
					</v-col>
					<v-col cols="12" md="3">
						<v-btn type="submit" :disabled="!formDataUser" color="info" style="width: 80%; left: 10%; top: 15%;" @click="validate">Actualizar contraseña</v-btn>
					</v-col>
					<v-col cols="12" md="3">
						<v-btn color="error" style="width: 80%; left: 10%; top: 15%;" @click="changePassword = false">Cancelar</v-btn>
					</v-col>
				</v-row>

				<v-row v-else>
					<v-col cols="12" md="6">
						<v-btn color="info" style="width: 80%; left: 10%; top: 15%;" @click="changePassword = true">Cambiar contraseña</v-btn>
					</v-col>
					<v-col cols="12" md="6">
						<v-btn :disabled="!formDataUser" type="submit" color="primary" style="width: 80%; left: 10%; top: 15%;" @click="validate">Actualizar datos</v-btn>
					</v-col>
				</v-row>
			</v-form>
			<v-snackbar v-model="snackbar">
				{{ textSnackbar }}
				<template v-slot:action="{ attrs }">
					<v-btn color="error" text v-bind="attrs" @click="snackbar = false">Cerrar</v-btn>
				</template>
			</v-snackbar>
		</div>
	</div>
</template>

<script>
	import { mapGetters } from 'vuex'

	export default {
		name: 'FormularioUsuario',
		data: () => ({
			formDataUser: true,
			snackbar: false,
			textSnackbar: '',
			user: {
				documentTypeUser: '',
				documentUser: '',
				nameUser: '',
				lastNameUser: '',
				phoneUser: '',
				emailUser: '',
			},
			newPasswordUser: '',
			confirmPasswordUser: '',
			rules: {
				validText: v => /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g.test(v) || 'Este campo debe contener solamente caracteres alfabéticos',
				validVoid: v => !!v || 'Este campo es obligatorio.',
				validPassword: v => (v && v.length >= 8) || 'La contraseña debe tener más de 8 caracteres.',
				confirmPassword: v => (this.newPasswordUser == this.confirmPasswordUser) || 'Las contraseñas no coinciden.', 
				validNumber: v => /^([0-9])*$/.test(v) || 'Este campo no puede contener caracteres alfabéticos.',
				validLengthDocument: v => v.length <= 10 || 'Este número no es válido.',
				validEmail: v => /^([a-zA-Z0-9_.+-])+\@((misena|sena)+\.+(edu.co))$/.test(v) || 'El correo electrónico es inválido. Debe ser correo sena, o misena.',
			},
			documentTypes: ['T.I.', 'C.C.', 'C.E.'],
			changePassword: false,
		}),
		mounted() {
			this.readUserData();
		},
		computed: {
			...mapGetters(['route']),
		},
		methods: {
			readUserData() {
				this.user.documentTypeUser = localStorage.documentType;
				this.user.documentUser = localStorage.document;
				this.user.nameUser = localStorage.name;
				this.user.lastNameUser = localStorage.lastName;
				this.user.phoneUser = localStorage.phone;
				this.user.emailUser = localStorage.email;
			},
			updatePassword() {
				axios.post(this.route + 'receivers/receptionUsers.php', { typeFunction:'updateUserPassword', confirmNewPassword:this.confirmPasswordUser, documentUser:this.user.documentUser, newPassword:this.newPasswordUser }).then(response => {
					this.snackbar = true;
					if (response.data == 1) {
						this.textSnackbar = 'La contraseña ha sido cambiada.';
						this.changePassword = false;

						this.reset()

						this.readUserData()
					}else {
						this.textSnackbar = 'Error al cambiar la contraseña.';
					}
				});
			},
			updateDataUser() {
				axios.post(this.route + 'receivers/receptionUsers.php', { typeFunction:'updateUser', userData:this.user }).then(response => {
					this.snackbar = true;
					response.data == 1 ? this.textSnackbar = 'Los datos han sido actualizados.' : this.textSnackbar = 'Error al actualizar los datos.';
					localStorage.documentType = this.user.documentTypeUser;
					localStorage.document = this.user.documentUser;
					localStorage.name = this.user.nameUser;
					localStorage.lastName = this.user.lastNameUser;
					localStorage.phone = this.user.phoneUser;
					localStorage.email = this.user.emailUser;
					this.readUserData()
				});
			},
			validate () {
				event.preventDefault();
				if (this.$refs.formDataUser.validate()) {
					this.changePassword == true ? this.updatePassword() : this.updateDataUser();
				}
			},
			reset () {
				this.$refs.formDataUser.reset()
			},
			resetValidation () {
				this.$refs.formDataUser.resetValidation()
			},
		}
	}
</script>