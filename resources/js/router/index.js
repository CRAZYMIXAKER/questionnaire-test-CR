import { createRouter, createWebHistory } from 'vue-router';
import MainLayout from '@/Views/Layouts/Main';
import SidebarDefault from '@/Views/Menu/Default';
import Home from '@/Pages/Home';
import SurveysShow from '@/Pages/Surveys/Show';
import SurveyAnswers from '@/Pages/Surveys/SurveyAnswers';
import SurveysIndex from '@/Pages/Surveys/Index';

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
