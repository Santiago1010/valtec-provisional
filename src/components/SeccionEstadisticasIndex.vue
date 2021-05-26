<template>
	<div class="seccionEstadisticas contenedorComparativo" id="bannerEstadistica">
		<v-container>

			<v-layout wrap>
				<v-flex class="mt-5" xs12 lg3>
					<v-card class="mx-auto hoverArriba" max-width="300" min-width="300" min-height="115" max-height="115">
						<v-card-text>
							<h2 class="textoCentrado">{{ totalRI }}</h2>
							<p class="textoCentrado">RESULTADOS DE INVESTIGACIÓN REGISTRADOS</p>
						</v-card-text>
					</v-card>
				</v-flex>

				<v-flex class="mt-5" xs12 lg3>
					<v-card class="mx-auto hoverArriba" max-width="300" min-width="300" min-height="115" max-height="115">
						<v-card-text>
							<h2 class="textoCentrado">{{ contadorTotalPatentes }}</h2>
							<p class="textoCentrado">POSIBLES PATENTES</p>
						</v-card-text>
					</v-card>
				</v-flex>

				<v-flex class="mt-5" xs12 lg3>
					<v-card class="mx-auto hoverArriba" max-width="300" min-width="300" min-height="115" max-height="115">
						<v-card-text>
							<h2 class="textoCentrado">{{ totalMarket }}</h2>
							<p class="textoCentrado">RESULTADOS DE INVESTIGACIÓN LISTOS PARA INICIAR EN EL MERCADO</p>
						</v-card-text>
					</v-card>
				</v-flex>

				<v-flex class="mt-5" xs12 lg3>
					<v-card class="mx-auto hoverArriba" max-width="300" min-width="300" min-height="115" max-height="115">
						<v-card-text>
							<h2 class="textoCentrado">{{ totalUsers }}</h2>
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
			totalRI: 0,
			limiteTotalPatentes: 0,
			totalMarket: 0,
			totalUsers: 0,
		}),
		mounted () {
			this.readRegisterResults();
			this.readResultsBigger();
			this.readTotalUsers();
		},
		computed: {
			...mapGetters(['route']),
		},
		methods: {
			readRegisterResults: function () {
				axios.post(this.route + 'receivers/receptionStats.php', { typeFunction:'readRegisterResults' }).then(response => {
					this.totalRI = response.data.total;
				});
			},
			readResultsBigger: function () {
				axios.post(this.route + 'receivers/receptionStats.php', { typeFunction:'readResultsBigger' }).then(response => {
					this.totalMarket = response.data.total;
				});
			},
			readTotalUsers: function () {
				axios.post(this.route + 'receivers/receptionStats.php', { typeFunction:'readTotalUsers' }).then(response => {
					this.totalUsers = response.data.total;
				});
			},
		}
	}
</script>

<style type="text/css">
	.seccionEstadisticas {
		background-image: url('../assets/imagenes/fondos/Sin-título-3.gif');
		min-width: 100%;
		max-width: 100%;
		min-height: 100vh;
		background-size: cover;
	}
	.textoCentrado {
		text-align: center
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