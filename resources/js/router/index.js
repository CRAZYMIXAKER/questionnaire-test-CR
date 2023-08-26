import { createRouter, createWebHistory } from 'vue-router';
import { useStore } from 'vuex';
import Login from '@/Pages/Auth/Login';
import Register from '@/Pages/Auth/Register';
import EmailVerify from '@/Pages/Auth/EmailVerify';
import ForgotPassword from '@/Pages/Auth/ForgotPassword';
import PasswordReset from '@/Pages/Auth/PasswordReset';
import MainLayout from '@/Views/Layouts/Main';
import SidebarDefault from '@/Views/Menu/Default';
import Home from '@/Pages/Home';
import SurveysShow from '@/Pages/Surveys/Show';
import SurveyAnswers from '@/Pages/Surveys/SurveyAnswers';
import SurveysIndex from '@/Pages/Surveys/Index';
import AdminIndex from '@/Pages/AdminDashboard/Index';
import AccessDenied from '@/Pages/Errors/AccessDenied';
import NotFound from '@/Pages/Errors/NotFound';

const checkAuth = (authRequired) => (to, from, next) => {
    const store = useStore();

    if (
        (authRequired && store.getters.user) ||
        (!authRequired && !store.getters.user)
    ) {
        next();
    } else {
        next(authRequired ? '/login' : '/');
    }
};

const checkRole = (allowedRoles = ['user', 'admin', 'super-admin']) => (to, from, next) => {
    const store = useStore();
    const user = store.getters.user;

    if (user === null) {
        next('/login');
    }

    if (
        (allowedRoles.includes('user') && user.roleses_name.includes('user')) ||
        (allowedRoles.includes('admin') && user.roleses_name.includes('admin')) ||
        (allowedRoles.includes('super-admin') && user.roleses_name.includes('super-admin'))
    ) {
        next();
    } else {
        next('/access-denied');
    }
};

const routes = [
    {
        path: '/',
        component: MainLayout,
        children: [
            {
                path: 'login',
                name: 'login',
                components: {
                    default: Login,
                    menu: SidebarDefault,
                },
                beforeEnter: checkAuth(false),
            },
            {
                path: 'register',
                name: 'register',
                components: {
                    default: Register,
                    menu: SidebarDefault,
                },
                beforeEnter: checkAuth(false),
            },
            {
                path: 'email/verify',
                name: 'email.verify',
                components: {
                    default: EmailVerify,
                    menu: SidebarDefault,
                },
                beforeEnter: checkAuth(true),
            },
            {
                path: 'forgot-password',
                name: 'forgot.password',
                components: {
                    default: ForgotPassword,
                    menu: SidebarDefault,
                },
                beforeEnter: checkAuth(false),
            },
            {
                path: 'password-reset/:token',
                name: 'password.reset',
                components: {
                    default: PasswordReset,
                    menu: SidebarDefault,
                },
                beforeEnter: checkAuth(false),
            },
            {
                path: '',
                name: 'home',
                components: {
                    default: Home,
                    menu: SidebarDefault,
                },
            },
            {
                path: 'surveys',
                name: 'surveys.index',
                components: {
                    default: SurveysIndex,
                    menu: SidebarDefault,
                },
            },
            {
                path: 'surveys/:survey_id',
                name: 'surveys.show',
                components: {
                    default: SurveysShow,
                    menu: SidebarDefault,
                },
            },
            {
                path: 'surveys/:survey_id/answers',
                name: 'survey.answers',
                components: {
                    default: SurveyAnswers,
                    menu: SidebarDefault,
                },
            },
            {
                path: 'admin/index',
                name: 'admin.index',
                components: {
                    default: AdminIndex,
                    menu: SidebarDefault,
                },
                beforeEnter: checkRole(['admin', 'super-admin']),
            },
            {
                path: 'access-denied',
                name: 'access.denied',
                components: {
                    default: AccessDenied,
                    menu: SidebarDefault,
                },
            },
            {
                name: 'not-found',
                path: ':catchAll(.*)',
                components: {
                    default: NotFound,
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
