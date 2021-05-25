<template>
	<div>
		<v-dialog v-model="dialogLogin" max-width="800">
			<v-card>
				<v-card-title class="headline orange lighten-2" dark>Iniciar Sesión</v-card-title>
				<v-card-text>
					<v-form ref="form" @submit="validate" class="formularioConvocatoria" v-model="validLogin" lazy-validation>
						<v-text-field v-model="documentLogin" :rules="documentRules" label="Número de documento" required></v-text-field>
						<v-text-field v-model="passwordLogin" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="passwordRules" :type="show1 ? 'text' : 'password'" label="Contraseña del usuario" hint="Mínimo 8 caractares" counter @click:append="show1 = !show1"></v-text-field>
						<br>
					</v-form>
				</v-card-text>
				<v-divider></v-divider>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn type="submit" :disabled="!validLogin" color="institucional" class="mr-4" @click="validate">Iniciar Sesión</v-btn>
					<v-btn color="error" @click="resetValidation">Cancelar</v-btn>
				</v-card-actions>
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
			...mapGetters(['route', 'dialogLogin']),
		},

		methods: {
			...mapActions(['openCloseDialog']),
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

				axios.post(this.route + 'receivers/receptionUsers.php', {typeFunction:'readUserLogin', documentLogin:this.passwordLogin, password:this.passwordLogin}).then(response => {
					localStorage.document = response.data.documento_usuario;
					localStorage.email = response.data.correo_usuario;
					localStorage.name = response.data.nombre_usuario;
					localStorage.lastName = response.data.apellido_usuario;
					localStorage.role = response.data.id_rol;	
					localStorage.session = true;

					this.$router.push('/inicio');
					this.resetValidation();
					this.modificarEstadoUsuario(true)
				});

			},
			clearSession: function() {
				localStorage.clear();
			}
		},
	}
</script>