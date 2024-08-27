<template>
    <div>
        <ul class="pagination pagination-outline" v-if="pagination">
            <li v-if="pagination.current_page > 1" class="page-item previous">
                <a href="#" class="page-link" @click.prevent="changePage(pagination.current_page - 1)">
                    <i class="previous"></i>
                </a>
            </li>
            <li v-for="page in pages" :key="page" class="page-item" @click.prevent="changePage(page)" :class="{ active: page == pagination.current_page }">
                <a href="#" class="page-link" @click.prevent="changePage(page)" >{{ page }}</a>
            </li>
            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                <a href="#" class="page-link" @click.prevent="changePage(pagination.current_page + 1)">
                    <i class="next"></i>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        pagination: {
            type:  [Array,Object],
            required: true,
            default: () => [],
        },
        onPageChange: Function,
    },
    computed: {
        pages() {
            let pagesArray = [];

            // Add current page and surrounding pages
            for (let i = this.pagination.current_page - 2; i <= this.pagination.current_page + 2; i++) {
                if (i >= 1 && i <= this.pagination.last_page) {
                    pagesArray.push(i);
                }
            }

            // Add ellipses if necessary
            if (pagesArray[0] > 1) {
                pagesArray.unshift('...');
            }
            if (pagesArray[pagesArray.length - 1] < this.pagination.last_page) {
                pagesArray.push('...');
            }

            return pagesArray;
        },
    },
    methods: {
        changePage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                console.log(page)
                this.onPageChange(page);
            }
        },
    },
};
</script>

