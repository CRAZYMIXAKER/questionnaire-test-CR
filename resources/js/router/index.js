import { createRouter, createWebHistory } from 'vue-router';
import { useStore } from 'vuex';
import Login from '@/Pages/Auth/Login';
import Register from '@/Pages/Auth/Register';
import ForgotPassword from '@/Pages/Auth/ForgotPassword';
import MainLayout from '@/Views/Layouts/Main';
import SidebarDefault from '@/Views/Menu/Default';
import Home from '@/Pages/Home';
import SurveysShow from '@/Pages/Surveys/Show';
import SurveyAnswers from '@/Pages/Surveys/SurveyAnswers';
import SurveysIndex from '@/Pages/Surveys/Index';

const isAuth = (to, from, next) => {
  const store = useStore();

   if (store.getters.user) next('/');

  next();
};

const checkRole = (allowedRoles = ['user', 'admin', 'super-admin']) => (to, from, next) => {
  const store = useStore();

  if (store.getters.user === null) next('login');

  if (allowedRoles.includes('user')) {
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
        beforeEnter: isAuth,
      },
      {
        path: 'register',
        name: 'register',
        components: {
          default: Register,
          menu: SidebarDefault,
        },
        beforeEnter: isAuth,
      },
      {
        path: 'forgot-password',
        name: 'password.request',
        components: {
          default: ForgotPassword,
          menu: SidebarDefault,
        },
        beforeEnter: isAuth,
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
    ],
  },
];

const router = createRouter({
  history: createWebHistory(), routes,
});

export default router;
