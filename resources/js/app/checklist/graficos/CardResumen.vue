<template>
    <div class="row gy-5 g-xl-10 mt-8">
        <div v-for="card in cards" :key="card.area_name" class="col-sm-6 col-xl-2 mb-xl-10">
            <div class="card h-lg-100">
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <!-- Contenido del ícono -->
                    <div class="m-0">
                        <!--begin::Svg Icon | path: icons/duotune/graphs/gra001.svg-->
                        <span class="svg-icon svg-icon-2hx svg-icon-gray-600">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path opacity="0.3" d="M14 3V21H10V3C10 2.4 10.4 2 11 2H13C13.6 2 14 2.4 14 3ZM7 14H5C4.4 14 4 14.4 4 15V21H8V15C8 14.4 7.6 14 7 14Z" fill="currentColor"></path>
																<path d="M21 20H20V8C20 7.4 19.6 7 19 7H17C16.4 7 16 7.4 16 8V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z" fill="currentColor"></path>
															</svg>
														</span>
                        <!--end::Svg Icon-->
                    </div>
                    <div class="d-flex flex-column my-7">
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ card.total }}</span>
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400"> Ticket de {{ card.area_name }}</span>
                        </div>
                    </div>
                    <!-- Contenido de la insignia (badge) -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            cards: [], // Ajusta según sea necesario para abiertos/cerrados
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        async fetchData() {
            // Ajusta la URL según tu API
            const response = await axios.get('/getTicketStatus');
            this.cards = response.data.ticketsAbiertosPorArea;

            //agregar objecto para tickets abiertos  , iconos y colores
            this.cards.forEach((card) => {
                card.icon = 'icons/duotune/graphs/gra001.svg';
                card.color = 'gray-600';
            });


            // O ajusta según los datos que quieras mostrar
            // Repite para tickets cerrados si es necesario
        },
    },
};
</script>


