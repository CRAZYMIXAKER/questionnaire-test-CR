import { createRouter, createWebHistory } from 'vue-router';
import MainLayout from '@/Views/Layouts/Main';
import SidebarDefault from '@/Views/Menu/Default';
import Home from '@/Pages/Home';

const routes = [
    {
        path: '/',
        component: MainLayout,
        children: [
            {
                path: '',
                name: 'home',
                components: {
                    default: Home,
                    menu: SidebarDefault,
                },
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(), routes,
});

export default router;
