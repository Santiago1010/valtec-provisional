<template>

	<div>
		
		<div class="contenedor">

			<br>

			<v-divider dark></v-divider>

			<h2 style="color: #FFFFFF;">DATOS DEL USUARIO</h2>

			<v-divider dark></v-divider>

			<v-form>

				<v-row>

					<v-col cols="12" md="6">

						<v-select dark v-model="tipoDocumentoUsuario" :items="topsDocumentos" :rules="validacionVacios" label="Tipo de documento" autocomplete="off" required></v-select>

					</v-col>

					<v-col cols="12" md="6">

						<v-text-field dark v-model="documentoUsuario" :rules="validacionVacios" label="Documento del usuario" autocomplete="off" required readonly disabled></v-text-field>

					</v-col>

				</v-row>

				<v-row>

					<v-col cols="12" md="6">

						<v-text-field dark v-model="nombreUsuario" :rules="validacionVacios" label="Nombre(s) del usuario" autocomplete="off" required></v-text-field>

					</v-col>

					<v-col cols="12" md="6">

						<v-text-field dark v-model="apellidoUsuario" :rules="validacionVacios" label="Apellido(s) del usuario" autocomplete="off" required></v-text-field>

					</v-col>

				</v-row>

				<v-row>

					<v-col cols="12" md="6">

						<v-text-field dark v-model="celularUsuario" :rules="validacionVacios" label="Número de contacto" autocomplete="off" required></v-text-field>

					</v-col>

					<v-col cols="12" md="6">

						<v-text-field dark v-model="correoUsuario" :rules="validacionVacios" label="Correo del usuario" autocomplete="off" required></v-text-field>

					</v-col>

				</v-row>

				<v-row v-if="cambiarContrasena == true">

					<v-col cols="12" md="3">

						<v-text-field dark v-model="contrasenaNueva" :rules="validacionContrasenas" type="password" label="Contraseña nueva" counter autocomplete="off" required></v-text-field>

					</v-col>

					<v-col cols="12" md="3">

						<v-text-field dark v-model="confirmarContrasena" :rules="validacionContrasenas" type="password" label="Confirmar contraseña" counter autocomplete="off" required></v-text-field>

					</v-col>

					<v-col cols="12" md="3">

						<v-btn color="info" style="width: 80%; left: 10%; top: 15%;" @click="actualizarContrasena">Actualizar contraseña</v-btn>

					</v-col>

					<v-col cols="12" md="3">

						<v-btn color="error" style="width: 80%; left: 10%; top: 15%;" @click="cambiarContrasena = false">Cancelar</v-btn>

					</v-col>

				</v-row>

				<v-row v-else>

					<v-col cols="12" md="6">

						<v-btn color="info" style="width: 80%; left: 10%; top: 15%;" @click="cambiarContrasena = true">Cambiar contraseña</v-btn>

					</v-col>

					<v-col cols="12" md="6">

						<v-btn color="primary" style="width: 80%; left: 10%; top: 15%;" @click="actualizarDatos">Actualizar datos</v-btn>

					</v-col>

				</v-row>

			</v-form>

			<v-snackbar v-model="snackbar">

				{{ textoSnackbar }}

				<template v-slot:action="{ attrs }">

					<v-btn color="institucional" text v-bind="attrs" @click="snackbar = false">

						Cerrar

					</v-btn>

				</template>

			</v-snackbar>

		</div>

	</div>

</template>

<script>

	import { mapGetters } from 'vuex'

	import MenuSesion from '../components/MenuSesion.vue';

	export default {

		name: 'FormularioUsuario',
		data: () => ({

			menuLateral: false,
			textoSnackbar: '',
			snackbar: false,
			nombreUsuario: '',
			apellidoUsuario: '',
			celularUsuario: '',
			correoUsuario: '',
			tipoDocumentoUsuario: '',
			documentoUsuario: '',
			contrasenaNueva: '',
			confirmarContrasena: '',
			validacionTextos: [

			v => /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g.test(v) || 'Este campo debe contener solamente caracteres alfabéticos',

			],
			validacionVacios: [

			v => !!v || 'Este campo es obligatorio.',

			],
			validacionContrasenas: [

			v => !!v || 'La contraseña es obligatoria.',
			v => (v && v.length >= 8) || 'La contraseña debe tener más de 8 caracteres.'

			],
			topsDocumentos: ['T.I.', 'C.C.', 'C.E.'],
			cambiarContrasena: false,

		}),
		mounted() {

			this.consultarUsuario();

		},
		computed: {

			...mapGetters(['ruta']),

		},
		methods: {

			consultarUsuario: function() {
				
				axios.post(this.ruta + 'recepcionUsuarios.php', {documentoUsuario:this.$store.state.documento}).then(response => {

					this.tipoDocumentoUsuario = response.data[0].tipo_documento;
					this.documentoUsuario = this.$store.state.documento;
					this.nombreUsuario = response.data[0].nombres_usuarios;
					this.apellidoUsuario = response.data[0].apellidos_usuarios;
					this.celularUsuario = response.data[0].celular_usuarios;

					if (response.data[0].correo_usuario == null || response.data[0].correo_usuario == "") {

						this.correoUsuario = response.data[0].correo_institucional;

					}else {

						this.correoUsuario = response.data[0].correo_usuario;

					}

				});

			},

			actualizarContrasena: function() {

				if (this.contrasenaNueva == this.confirmarContrasena) {

					axios.post(this.ruta + 'recepcionUsuarios.php', {nueva:this.contrasenaNueva, confirmar:this.confirmarContrasena, documentoContrasena:this.documentoUsuario}).then(response => {

						this.snackbar = true;
						this.textoSnackbar = response.data;

						this.contrasenaNueva = '';
						this.confirmarContrasena = '';

						this.cambiarContrasena = false;

					});

				}else {

					this.snackbar = true;
					this.textoSnackbar = 'Las contraseñas no coinciden';

				}

			},

			actualizarDatos: function() {

				if (this.tipoDocumentoUsuario != null && this.documentoUsuario != null && this.nombreUsuario != null && this.apellidoUsuario != null && this.celularUsuario != null && this.correoUsuario != null && this.tipoDocumentoUsuario != "" && this.documentoUsuario != "" && this.nombreUsuario != "" && this.apellidoUsuario != "" && this.celularUsuario != "" && this.correoUsuario != "") {

					axios.post(this.ruta + 'recepcionUsuarios.php', {tipoDocumento:this.tipoDocumentoUsuario, documento:this.documentoUsuario, nombre:this.nombreUsuario, apellido:this.apellidoUsuario, celular: this.celularUsuario, correo:this.correoUsuario}).then(response => {

						this.snackbar = true;
						this.textoSnackbar = response.data;

						this.contrasenaNueva = '';
						this.confirmarContrasena = '';

						this.cambiarContrasena = false;

					});

				}else {

					this.snackbar = true;
					this.textoSnackbar = 'Todos los campos son obligatorios';

				}

			}

		}

	}

</script>