<style type="text/css">

.seccionEstadisticas {

	background-image: url('../assets/imagenes/fondos/Sin-título-3.gif');
	min-width: 100%;
	max-width: 100%;
	min-height: 100vh;
	background-size: cover;

}

.textoCentrado {

	text-align: center;

}

h2.textoCentrado {

	font-weight: bold;
	font-size: 3em;
	margin-bottom: 10px;

}

.mt-5 {

	transition: .5s;

}

.mt-5:hover {

	transition: .5s;
	transform: translateY(-10px);

}

</style>

<template>
	
	<div class="seccionEstadisticas contenedorComparativo" id="bannerEstadistica">

		<v-container>

			<v-layout wrap>

				<v-flex class="mt-5" xs12 lg3>

					<v-card class="mx-auto hoverArriba" max-width="300" min-width="300" min-height="115" max-height="115">

						<v-card-text>

							<h2 class="textoCentrado">{{contadorTotalRI}}</h2>

							<p class="textoCentrado">RESULTADOS DE INVESTIGACIÓN REGISTRADOS</p>

						</v-card-text>

					</v-card>

				</v-flex>

				<v-flex class="mt-5" xs12 lg3>

					<v-card class="mx-auto hoverArriba" max-width="300" min-width="300" min-height="115" max-height="115">

						<v-card-text>

							<h2 class="textoCentrado">{{contadorTotalPatentes}}</h2>

							<p class="textoCentrado">POSIBLES PATENTES</p>

						</v-card-text>

					</v-card>

				</v-flex>

				<v-flex class="mt-5" xs12 lg3>

					<v-card class="mx-auto hoverArriba" max-width="300" min-width="300" min-height="115" max-height="115">

						<v-card-text>

							<h2 class="textoCentrado">{{contadorTotalMercado}}</h2>

							<p class="textoCentrado">RESULTADOS DE INVESTIGACIÓN LISTOS PARA INICIAR EN EL MERCADO</p>

						</v-card-text>

					</v-card>

				</v-flex>

				<v-flex class="mt-5" xs12 lg3>

					<v-card class="mx-auto hoverArriba" max-width="300" min-width="300" min-height="115" max-height="115">

						<v-card-text>

							<h2 class="textoCentrado">{{contadorTotalUsuarios}}</h2>

							<p class="textoCentrado">USUARIOS REGISTRADOS</p>

						</v-card-text>

					</v-card>

				</v-flex>
				
			</v-layout>

		</v-container>

	</div>

</template>

<script>

	import { mapGetters } from 'vuex'

	export default {

		name: 'SeccionEstadisticasIndex',
		data: () => ({

			contadorTotalRI: 0,
			contadorTotalPatentes: 0,
			contadorTotalMercado: 0,
			contadorTotalUsuarios: 0,
			limiteTotalRI: 0,
			limiteTotalPatentes: 0,
			limiteTotalMercado: 0,
			limiteTotalUsuarios: 0,

		}),
		mounted () {

			this.consultarCantidadResultadosRegistrados();
			this.consultarCantidadResultadosMercado();
			this.consultarCantidadResultadosMercado();

			this.aumentarEstadisticas();

		},
		computed: {

			...mapGetters(['ruta']),

		},
		methods: {

			consultarCantidadResultadosRegistrados: function () {

				axios.post(this.ruta + 'recepcionConsultaEstadisticasIndex.php', {estadistica: 'totalRI'}).then(response => {

					this.limiteTotalRI = response.data.totalRI;

				});

			},

			consultarCantidadResultadosMercado: function () {

				axios.post(this.ruta + 'recepcionConsultaEstadisticasIndex.php', {estadistica: 'totalMercado'}).then(response => {

					this.limiteTotalMercado = response.data.totalMercado;

				});

			},

			consultarCantidadResultadosMercado: function () {

				axios.post(this.ruta + 'recepcionConsultaEstadisticasIndex.php', {estadistica: 'totalUsuarios'}).then(response => {

					this.limiteTotalUsuarios = response.data.totalUsuarios;

				});

			},

			aumentarEstadisticas: function () {

				this.contadorTotalRI = this.limiteTotalPatentes;
				this.contadorTotalMercado = this.limiteTotalMercado;
				this.contadorTotalUsuarios = this.limiteTotalUsuarios;

			}

		}

	}

</script>