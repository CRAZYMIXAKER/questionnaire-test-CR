<template>
    <nav v-if="pagination.last_page > 1" class="pagination">
        <ul class="pagination__list">
            <li v-if="pagination.current_page !== 1" class="pagination__list-item pagination__list-item--first">
                <a class="pagination__list-link" @click="updatePage(1)"><span>First</span></a>
            </li>
            <li v-if="pagination.current_page >= 2" class="pagination__list-item pagination__list-item--previous">
                <a class="pagination__list-link" @click="updatePage(pagination.current_page - 1)">
                    <span>Previous</span>
                </a>
            </li>

            <template v-for="link in pagination.links">
                <li
                    v-if="showPage(link)"
                    :class="link.active ? 'pagination__list-item--active' : ''"
                    class="pagination__list-item"
                >
                    <a class="pagination__list-link" @click="updatePage(link.label)">
                        <span>{{ link.label }}</span>
                    </a>
                </li>
                <li v-if="showGap(link)" class="pagination__list-item pagination__list-item--gap"/>
            </template>
            <li
                v-if="pagination.current_page < pagination.last_page"
                class="pagination__list-item pagination__list-item--next"
            >
                <a class="pagination__list-link" @click="updatePage(pagination.current_page + 1)">
                    <span>Next</span>
                </a>
            </li>
            <li
                v-if="pagination.current_page !== pagination.last_page"
                class="pagination__list-item pagination__list-item--last"
            >
                <a class="pagination__list-link" @click="updatePage(pagination.last_page)">
                    <span>Last</span>
                </a>
            </li>
        </ul>

    </nav>
</template>

<script>

export default {
    name: 'PaginationMain',
    props: {
        pagination: {
            type: Object,
            require: true,
        },
    },
    methods: {
        updatePage(page) {
            return this.$emit('update-page', page);
        },
        showPage(link) {
            return Number(link.label) &&
                (this.pagination.current_page - link.label < 2 && this.pagination.current_page - link.label > -2) ||
                Number(link.label) === 1 ||
                Number(link.label) === this.pagination.last_page;
        },
        showGap(link) {
            let currentPage = this.pagination.current_page;

            return Number(link.label) &&
                currentPage !== 3 &&
                (currentPage - link.label === 2) ||
                Number(link.label) &&
                currentPage !== this.pagination.last_page - 2 &&
                (currentPage - link.label === -2);
        },
    },
};
</script>
