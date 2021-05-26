<style>

.contenedorNaranja {

	background: rgb(255,255,255);
	background: radial-gradient(circle, rgba(255,255,255,1) 92%, rgba(255,107,0,1) 100%);
	color: #FFFFFF;

}

</style>

<template>
	
	<div class="contenedorNaranja">
		
		<v-container flex>

			<v-layout justify-center wrap>

				<v-flex class="mr-4" xs12 md5>

					<v-banner>

						<h4>Correo de soporte:</h4>

						<a href="mailto:soporte@valtec.systems">soporte@valtec.systems</a>

					</v-banner>

					<v-banner>

						<h4>Líder SENNOVA:</h4>

						Lady Johanna Malagón Sánchez: <a href="mailto:lmalagon@valtec.systems">lmalagon@valtec.systems</a> - <a href="tel:+57 313 823 5913">313 823 5913</a>

					</v-banner>

					<v-banner>

						<h4>Líder Grupo de Investigación:</h4>

						Carlos Alberto Malagón Sánchez: <a href="mailto:cmalagon@valtec.systems">cmalagon@valtec.systems</a> - <a href="tel:+57 313 866 5485">313 866 5485</a>

					</v-banner>

					<v-banner>

						<h4>Desarrollador ValTec:</h4>

						Santiago Correa Aguirre: <a href="mailto:scorrea@valtec.systems">scorrea@valtec.systems</a> - <a href="tel:+57 310 857 6258">310 857 6258</a>

					</v-banner>

				</v-flex>

				<v-flex class="ml-4" xs12 md5>

					<v-form ref="form" v-model="valid" lazy-validation>

						<v-text-field v-model="nombre" :rules="nombreValidacion" label="Nombre completo" hint="El nombre es para conocer mejor a quién envía el mensaje." required autocomplete="off"></v-text-field>

						<v-text-field v-model="celular" :counter="10" :rules="celularValidacion" label="Número de contacto" hint="El número de contacto será usado en caso de urgencia en la respuesta." required autocomplete="off"></v-text-field>

						<v-text-field v-model="correo" :rules="correoValidacion" label="Correo electrónico" hint="Este correo electrónico es en el que se dará respuesta directa al mensaje." required></v-text-field>

						<v-textarea v-model="mensaje" :rules="mensajeValidacion" label="Escriba su mensaje" hint="Este es el mensaje del correo o el cuerpo que será enviado a los encargados de la plataforma."></v-textarea>

						<!--<v-checkbox v-model="checkbox" label="¿Está de acuerdo de que compartamos su número y su correo electrónico con fines de respuesta a su mensaje?"></v-checkbox>-->

						<v-btn :disabled="!valid" color="success" class="mr-4" @click="validate">Enviar</v-btn>

						<v-btn color="error" class="mr-4" @click="reset">Rehacer formulario</v-btn>

					</v-form>

				</v-flex>

			</v-layout>

		</v-container>

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

	import { mapGetters } from 'vuex'

	export default {

		data: () => ({

			snackbar: false,
			textoSnackbar: '',
			valid: true,
			nombre: '',
			nombreValidacion: [

				v => !!v || 'El nombre es requerido.',
				v => /^[A-z ]+$/.test(v) || 'El nombre deber tener solamente caracteres alfabéticos.',

			],
			celular: '',
			celularValidacion: [

			v => !!v || 'El número de contacto es requerido.',
			v => (v && v.length <= 10) || 'La cantidad de números no es válida.',
			v => /^([0-9])*$/.test(v) || 'El número de contacto no puede contener caracteres alfabéticos.',

			],
			correo: '',
			correoValidacion: [

			v => !!v || 'El correo electrónico es requerido.',
			v => /.+@.+\..+/.test(v) || 'El correo electrónico es inválido.',

			],
			mensaje: '',
			mensajeValidacion: [

			v => !!v || 'El mensaje es requerido.',

			],
			checkbox: false,

		}),
		computed: {

			...mapGetters(['route']),

		},
		methods: {

			validate () {

				this.$refs.form.validate()

				axios.post(this.route + 'recepcionCorreoContacto.php', {nombre:this.nombre, correo:this.correo, celular:this.celular, mensaje:this.mensaje}).then(response => {

					this.snackbar = true;
					this.textoSnackbar = response.data;

					if (this.textoSnackbar == "Se ha enviado el correo electrónico.") {

						this.$refs.form.reset()

						this.$refs.form.resetValidation()

					}

				});

			},

			reset () {

				this.$refs.form.reset()

				this.$refs.form.resetValidation()

			},

			resetValidation () {

				this.$refs.form.resetValidation()

			},

		},

	}

</script>