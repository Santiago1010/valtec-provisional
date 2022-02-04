<template>
	<div>
		<v-dialog v-model="dialogLogin" max-width="800">
			<v-card>
				<v-form ref="form" @submit="validate" class="formularioConvocatoria" v-model="validLogin" lazy-validation>
					<v-card-title class="headline orange lighten-2" dark>Iniciar Sesión</v-card-title>
					<v-card-text>
						<v-text-field @submit="validate" v-model="documentLogin" :rules="documentRules" label="Número de documento" required></v-text-field>
						<v-text-field @submit="validate" v-model="passwordLogin" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="passwordRules" :type="show1 ? 'text' : 'password'" label="Contraseña del usuario" hint="Mínimo 8 caractares" counter @click:append="show1 = !show1"></v-text-field>
						<br>
					</v-card-text>
					<v-divider></v-divider>
					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn type="submit" :disabled="!validLogin" color="institucional" class="mr-4" @click="validate" @submit="validate">Iniciar Sesión</v-btn>
						<v-btn color="error" @click="resetValidation">Cancelar</v-btn>
					</v-card-actions>
				</v-form>
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex'

	export default {
		name: 'FormLogin',
		components: {},
		data: () => ({
			validLogin: true,
			documentLogin: '',
			documentRules: [
				v => !!v || 'El correo electrónico es necesario.',
			],
			passwordLogin: '',
			passwordRules: [
				v => !!v || 'La contraseña es requerida.',
				v => v.length >= 8 || 'La contraseña es inválida',
			],
			max: 8,
			show1: false,
		}),
		computed: {
			...mapGetters(['route', 'dialogLogin', 'sessionUser']),
		},

		methods: {
			...mapActions(['openCloseDialog', 'setSessionUser']),
			validate (event) {
				event.preventDefault();
				this.$refs.form.validate()
				if (this.$refs.form.validate()) {
					this.iniciarSesion();
				}
			},
			reset () {
				this.$refs.form.reset()
			},
			resetValidation () {
				this.$refs.form.resetValidation()
				this.reset()
				this.openCloseDialog(false)
			},
			iniciarSesion: function() {
				this.clearSession();

				axios.post(this.route + 'receivers/receptionUsers.php', { typeFunction:'readUserLogin', documentLogin:this.documentLogin, passwordLogin:this.passwordLogin }).then(response => {
					localStorage.document = response.data.documento_usuario;
					localStorage.email = response.data.correo_usuario;
					localStorage.name = response.data.nombres_usuarios;
					localStorage.lastName = response.data.apellidos_usuarios;
					localStorage.role = response.data.id_rol;
					localStorage.phone = response.data.celular_usuarios;
					localStorage.documentType = response.data.tipo_documento;
					localStorage.session = true;

					this.setSessionUser(true);

					this.$router.push('/inicio');
					this.resetValidation();
				});

			},
			clearSession: function() {
				localStorage.clear();
			}
		},
	}
</script>