<template>

	<v-container style="position: relative; width: 100%; background: rgb(89,181,72); background: linear-gradient(180deg, rgba(89,181,72,1) 0%, rgba(35,130,118,1) 100%);" fluid>

		<vue-particles style="position: absolute; z-index: 0; width: 100%; height: 100%; top: 0; left: 0; max-height: 100%;" color="#D3D3D3"></vue-particles>

		<div>
			
			<v-layout class="mr5" justify-center wrap>

				<v-flex class="mr-md-8" xs12 md5>

					<div style="text-align: justify; position: relative; z-index: 1;">

						<h1 style="color: #FFFFFF;">¿QUÉ ES VALTEC?</h1>

						<p style="color: #FFFFFF;">La plataforma de Valoración de Tecnologías, ValTec, es un aplicativo que ayuda a conocer el estado de maduración de una tecnología. Iniciando desde la idea, hasta llegar al mercado, generando de esta forma innovación. Basado en la guía de TRL, creada por la NASA. Ayuda a los usuarios a conocer el estado real en el que se encuentra su Resultado de Investigación. De esta manera podrá conocer las fases posteriores de investigación, identificando aspectos regulatorios relacionados al Resultado de Investigación, la producción intelectual vinculada a este y el nivel inventivo del Resultado de Investigación.</p>

						<p style="color: #FFFFFF;">Se espera que, con el aplicativo, se puedan clasificar los resultados de investigación obtenidos en el marco de la estrategia SENNOVA, generando la información pertinente, como base para la generación de innovación.</p>

						<p style="color: #FFFFFF;">ValTec nació como el resultado de un modelo propuesto por el grupo investigación Tecnología y Productividad, liderado por Carlos Alberto Malagón Sánchez y Lady Johanna Malagón Sánchez.</p>

					</div>

				</v-flex>

				<v-flex xs12 class="ml-11 mt-5" md5>

					<iframe style="text-align: justify; position: relative; z-index: 1;" width="80%" height="300" src="https://www.youtube-nocookie.com/embed/sEtpzPFgvkY?controls=0&rel=0&modestbranding=1" class="rounded-lg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

				</v-flex>

			</v-layout>

		</div>

	</v-container>

</template>

<script>

	export default {

		name: 'ComparacionInformacionValtec',

	};

</script>