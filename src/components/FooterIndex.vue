<template>
	<div class="contenedorNaranja">
		<v-container flex>
			<v-layout justify-center wrap>
				<v-flex class="mr-4" xs12 md5>
					<v-banner>
						<h4>Correo de soporte:</h4>
						<a style="color: #FF6B00;" href="mailto:soporte@valtec.systems">soporte@valtec.systems</a>
					</v-banner>

					<v-banner>
						<h4>Líder SENNOVA:</h4>
						Lady Johanna Malagón Sánchez: <a style="color: #FF6B00;" href="mailto:lmalagon@valtec.systems">lmalagon@valtec.systems</a> - <a style="color: #FF6B00;" href="tel:+57 313 823 5913">313 823 5913</a>
					</v-banner>

					<v-banner>
						<h4>Líder Grupo de Investigación:</h4>
						Carlos Alberto Malagón Sánchez: <a style="color: #FF6B00;" href="mailto:cmalagon@valtec.systems">cmalagon@valtec.systems</a> - <a style="color: #FF6B00;" href="tel:+57 313 866 5485">313 866 5485</a>
					</v-banner>

					<v-banner>
						<h4>Desarrollador ValTec:</h4>
						Santiago Correa Aguirre: <a style="color: #FF6B00;" href="mailto:scorrea@valtec.systems">scorrea@valtec.systems</a> - <a style="color: #FF6B00;" href="tel:+57 310 857 6258">310 857 6258</a>
					</v-banner>
				</v-flex>

				<v-flex class="ml-4" xs12 md5>
					<v-form ref="form" v-model="validContactEmail" lazy-validation>
						<v-text-field v-model="nameContact" :rules="[rules.required, rules.validationNames]" label="Nombre completo" hint="El nombre es para conocer mejor a quién envía el mensaje." required autocomplete="off"></v-text-field>
						<v-text-field v-model="emailContact" :rules="[rules.required, rules.validationEmail]" label="Correo electrónico" hint="Este correo electrónico es en el que se dará respuesta directa al mensaje." required></v-text-field>
						<v-textarea v-model="messageContact" :rules="[rules.required]" label="Escriba su mensaje" hint="Este es el mensaje del correo o el cuerpo que será enviado a los encargados de la plataforma."></v-textarea>
						<v-btn type="submit" @submit="validate" :disabled="!validContactEmail" color="success" class="mr-4" @click="validate">Enviar</v-btn>
						<v-btn color="error" class="mr-4" @click="reset">Rehacer formulario</v-btn>
					</v-form>
				</v-flex>
			</v-layout>
		</v-container>
		<Snackbar></Snackbar>
	</div>
</template>

<script>
	import Snackbar from './Snackbar.vue'

	import { mapGetters, mapActions } from 'vuex'

	export default {
		components: {
			Snackbar,
		},
		data: () => ({
			validContactEmail: true,
			nameContact: '',
			emailContact: '',
			messageContact: '',
			rules: {
				required: v => !!v || 'Este campo es requerido.',
				validationNames: v => /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g.test(v) || 'Este campo sólo permite caracteres alfabéticos.',
				validationEmail: v => /.+@.+\..+/.test(v) || 'El correo electrónico es inválido.'
			}
		}),
		computed: {
			...mapGetters(['route']),
		},
		methods: {
			...mapActions(['modifyStateSnackbar', 'modifyTextSnackbar']),
			validate (event) {
				event.preventDefault();
				this.$refs.form.validate() ? this.sendEmailContact() : false;
			},
			reset () {
				this.$refs.form.reset()
			},
			resetValidation () {
				this.$refs.form.resetValidation()
			},
			sendEmailContact() {
				axios.post(this.route + 'receivers/receptionEmails.php', { typeFunction:'sendEmailContact', nameContact:this.nameContact, emailContact:this.emailContact, messageContact:this.messageContact }).then(response => {
					if (response.data) {
						this.modifyStateSnackbar(false);
						this.modifyStateSnackbar(true);
						this.modifyTextSnackbar('Se ha enviado el correo. Recibirá respuesta a través de la cuenta de correo electrónico que registro.');
						this.reset();
					}else { console.log(response.data); }
				});
			}
		},
	}
</script>

<style>
	.contenedorNaranja {
		background: rgb(255,255,255);
		background: radial-gradient(circle, rgba(255,255,255,1) 92%, rgba(255,107,0,1) 100%);
		color: #FFFFFF;
	}
	a {
		color: #FF6B00;
	}
</style>