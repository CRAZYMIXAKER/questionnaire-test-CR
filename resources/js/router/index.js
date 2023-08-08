import { createRouter, createWebHistory } from 'vue-router';
import MainLayout from '@/Views/Layouts/Main';
import SidebarDefault from '@/Views/Menu/Default';
import Home from '@/Pages/Home';
import Survey from '@/Pages/Surveys/Survey';
import SurveyAnswers from '@/Pages/Surveys/SurveyAnswers';

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
                path: 'survey/:survey_id',
                name: 'survey',
                components: {
                    default: Survey,
                    menu: SidebarDefault,
                },
            },
            {
                path: 'survey/:survey_id/answers',
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
