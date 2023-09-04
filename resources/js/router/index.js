import { createRouter, createWebHistory } from 'vue-router';
import { useStore } from 'vuex';

import MainLayout from '@/Layouts/Main';
import SidebarLeftAdmin from '@/Components/Sidebar/LeftAdmin';
import Home from '@/Pages/Home';

// User
import Login from '@/Pages/Auth/Login';
import Register from '@/Pages/Auth/Register';
import EmailVerify from '@/Pages/Auth/EmailVerify';
import ForgotPassword from '@/Pages/Auth/ForgotPassword';
import PasswordReset from '@/Pages/Auth/PasswordReset';

// Surveys
import SurveysIndex from '@/Pages/Surveys/Index';
import SurveysShow from '@/Pages/Surveys/Show';
import SurveyAnswers from '@/Pages/Surveys/SurveyAnswers';

// Admin - Surveys
import AdminSurveysIndex from '@/Pages/Admin/Surveys/Index';
import AdminSurveysCreate from '@/Pages/Admin/Surveys/Create';
import AdminSurveysEdit from '@/Pages/Admin/Surveys/Edit';

// Admin - Questions
import AdminQuestionsIndex from '@/Pages/Admin/Questions/Index';
import AdminQuestionsCreate from '@/Pages/Admin/Questions/Create';
import AdminQuestionsEdit from '@/Pages/Admin/Questions/Edit';

// Another
import AccessDenied from '@/Pages/Errors/AccessDenied';
import NotFound from '@/Pages/Errors/404';

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
                    main: Login,
                },
                beforeEnter: checkAuth(false),
            },
            {
                path: 'register',
                name: 'register',
                components: {
                    main: Register,
                },
                beforeEnter: checkAuth(false),
            },
            {
                path: 'email/verify',
                name: 'email.verify',
                components: {
                    main: EmailVerify,
                },
                beforeEnter: checkAuth(true),
            },
            {
                path: 'forgot-password',
                name: 'forgot.password',
                components: {
                    main: ForgotPassword,
                },
                beforeEnter: checkAuth(false),
            },
            {
                path: 'password-reset/:token',
                name: 'password.reset',
                components: {
                    main: PasswordReset,
                },
                beforeEnter: checkAuth(false),
            },
            {
                path: '',
                name: 'home',
                components: {
                    'left-sidebar': SidebarLeftAdmin,
                    main: Home,
                },
            },
            {
                path: 'surveys',
                name: 'surveys.index',
                components: {
                    'left-sidebar': SidebarLeftAdmin,
                    main: SurveysIndex,
                },
            },
            {
                path: 'surveys/:survey_id',
                name: 'surveys.show',
                components: {
                    'left-sidebar': SidebarLeftAdmin,
                    main: SurveysShow,
                },
            },
            {
                path: 'surveys/:survey_id/answers',
                name: 'survey.answers',
                components: {
                    'left-sidebar': SidebarLeftAdmin,
                    main: SurveyAnswers,
                },
            },
            {
                path: 'admin/',
                children: [
                    {
                        path: 'surveys',
                        name: 'admin.surveys.index',
                        components: {
                            'left-sidebar': SidebarLeftAdmin,
                            main: AdminSurveysIndex,
                        },
                    },
                    {
                        path: 'surveys/create',
                        name: 'admin.surveys.create',
                        components: {
                            'left-sidebar': SidebarLeftAdmin,
                            main: AdminSurveysCreate,
                        },
                    },
                    {
                        path: 'surveys/:survey_id/edit',
                        name: 'admin.surveys.edit',
                        components: {
                            'left-sidebar': SidebarLeftAdmin,
                            main: AdminSurveysEdit,
                        },
                    },
                    {
                        path: 'questions',
                        name: 'admin.questions.index',
                        components: {
                            'left-sidebar': SidebarLeftAdmin,
                            main: AdminQuestionsIndex,
                        },
                    },
                    {
                        path: 'questions/create',
                        name: 'admin.questions.create',
                        components: {
                            'left-sidebar': SidebarLeftAdmin,
                            main: AdminQuestionsCreate,
                        },
                    },
                    {
                        path: 'questions/:question_id/edit',
                        name: 'admin.questions.edit',
                        components: {
                            'left-sidebar': SidebarLeftAdmin,
                            main: AdminQuestionsEdit,
                        },
                    },
                ],
                beforeEnter: checkRole(['admin', 'super-admin']),
            },
            {
                path: 'access-denied',
                name: 'access.denied',
                components: {
                    main: AccessDenied,
                },
            },
            {
                name: 'not-found',
                path: ':catchAll(.*)',
                components: {
                    main: NotFound,
                },
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(), routes,
});

export default router;
