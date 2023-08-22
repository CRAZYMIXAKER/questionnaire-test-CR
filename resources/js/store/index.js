import { createStore } from 'vuex';
import User from '@/store/modules/user';

export default createStore({
  modules: {
    User,
  },
});
