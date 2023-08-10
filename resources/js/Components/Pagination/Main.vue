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
                    v-if="Number(link.label) &&
                    (pagination.current_page - link.label < 2 && pagination.current_page - link.label > -2) ||
                    Number(link.label) === 1 ||
                    Number(link.label) === pagination.last_page"
                    :class="link.active ? 'pagination__list-item--active' : ''"
                    class="pagination__list-item"
                >
                    <a class="pagination__list-link" @click="updatePage(link.label)">
                        <span>{{ link.label }}</span>
                    </a>
                </li>
                <li
                    v-if="Number(link.label) &&
                    pagination.current_page !== 3 &&
                    (pagination.current_page - link.label === 2) ||
                    Number(link.label) &&
                    pagination.current_page !== pagination.last_page - 2 &&
                    (pagination.current_page - link.label === -2 )"
                    class="pagination__list-item pagination__list-item--gap"
                />
            </template>
            <li
                v-if="pagination.current_page < pagination.last_page"
                class="pagination__list-item pagination__list-item--next">
                <a class="pagination__list-link" @click="updatePage(pagination.current_page + 1)">
                    <span>Next</span>
                </a>
            </li>
            <li
                v-if="pagination.current_page !== pagination.last_page"
                class="pagination__list-item pagination__list-item--last">
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
        showPage(page) {
            return;
        },
    },
};
</script>

<style lang="scss" scoped>
@keyframes pagination-in {
    from {
        transform: scale(1.5);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.pagination {
    &__list {
        align-items: center;
        animation-timeout: 200ms;
        animation: pagination-in 500ms ease both;
        display: flex;
        gap: 3px 6px;
        justify-content: center;
        list-style: none;
        margin: 0;
        padding: 0;
        position: relative;
        text-align: center;
        z-index: 6;
    }

    &__list-link {
        display: block;
        height: 100%;
        width: 100%;
    }

    &__list-item {
        border-radius: 38px;
        border: 2px solid #fff;
        color: #fff;
        display: inline-block;
        font-size: 14px;
        font-weight: 700;
        height: 38px;
        letter-spacing: .03em;
        line-height: 38px;
        min-width: 38px;
        padding: 0;
        text-decoration: none;
        text-transform: uppercase;
        transition: background 250ms;

        &--active {
            background-color: #000;
            color: #fff;
        }

        &--first,
        &--last {
            margin: 0 9px;
        }

        &--previous,
        &--next {
            margin: 0 5px;
        }

        &--first,
        &--last,
        &--previous,
        &--next {
            .pagination__list-link {
                padding: 0 16px;
                width: calc(100% - 32px);
            }
        }

        &--gap {
            border-color: transparent;
            color: transparent;
            display: inline-block;
            pointer-events: none;
            width: 50px;

            &::after {
                color: #fff;
                content: '...';
                font-size: 32px;
            }
        }

        &:hover {
            background-color: #000;
            color: #fff;
            cursor: pointer;
        }
    }
}
</style>
