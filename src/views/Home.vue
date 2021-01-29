<template @scroll="aumentarEstadisticas">

	<div>

		<app-menu></app-menu>
		
		<app-carrusel></app-carrusel>

		<app-informacion></app-informacion>

		<div class="d-none d-md-flex d-lg-none">

			<app-conceptos></app-conceptos>

		</div>

		<app-estadisticas></app-estadisticas>

		<app-footer></app-footer>

	</div>

</template>

<script>

	import CarruselIndex from '../components/CarruselIndex.vue';

	import ComparacionInformacionValtec from '../components/ComparacionInformacionValtec.vue';

	import CarruselConceptos from '../components/CarruselConceptos.vue';

	import SeccionEstadisticasIndex from '../components/SeccionEstadisticasIndex.vue';

	import FooterIndex from '../components/FooterIndex.vue';

	import MenuIndex from '../components/MenuIndex.vue';

	export default {

		name: 'Principal',
		components: {

			'app-carrusel': CarruselIndex,
			'app-informacion': ComparacionInformacionValtec,
			'app-conceptos': CarruselConceptos,
			'app-estadisticas': SeccionEstadisticasIndex,
			'app-footer': FooterIndex,
			'app-menu': MenuIndex,

		},
		data: () => ({

			menuLateral: false,

		}),

	}

</script>