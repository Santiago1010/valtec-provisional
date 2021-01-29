<template>
	
	<div>
		
		<v-form>

			<v-container>

				<v-row>

					<v-col cols="12" md="4">

						<v-text-field dark v-model="nombreResultado" label="Filtrar por nombre del resultado de investigación" required></v-text-field>

					</v-col>

					<v-col cols="12" md="4">

						<v-text-field dark v-model="nombreInvestigador" label="Filtrar por nombre de investigador" required></v-text-field>

					</v-col>

					<v-col cols="12" md="4">

						<v-text-field dark v-model="codigoResultado" label="Filtrar por código (SGPS, SIGP, Iniciativa de centro)" required></v-text-field>

					</v-col>

				</v-row>

				<v-row>

					<v-col cols="12" md="3">

						<v-text-field dark v-model="trlResultado" label="Filtrar por TRL del resultado de investigación" required></v-text-field>

					</v-col>

					<v-col cols="12" md="3">

						<v-text-field dark v-model="regionalResultado" label="Filtrar por regional del resultado de investigación" required></v-text-field>

					</v-col>

					<v-col cols="12" md="3">

						<v-checkbox dark v-model="checkbox" label="Filtrar resultados propios" required></v-checkbox>

					</v-col>

					<v-col cols="12" md="3">

						<v-btn color="info" style="width: 100%; margin-top: 10px;">Descargar reporte</v-btn>

					</v-col>

				</v-row>

			</v-container>

		</v-form>

	</div>

</template>

<script>

	export default {

		name: 'FormularioFiltrosResultados',
		data: () => ({

			nombreResultado: '',
			nombreInvestigador: '',
			codigoResultado: '',
			trlResultado: '',
			regionalResultado: '',
			checkbox: '',

		}),
		mounted () {

			//

		},
		methods: {

			//

		}

	}

</script>