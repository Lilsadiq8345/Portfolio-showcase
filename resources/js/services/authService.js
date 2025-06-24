import { reactive } from 'vue';

const state = reactive({
    user: null,
    isAuthenticated: false,
});

const tokenKey = 'auth_token';
const userKey = 'auth_user';

export default {
    state,

    checkAuth() {
        const token = localStorage.getItem(tokenKey);
        const userString = localStorage.getItem(userKey);

        if (token && userString && userString !== 'undefined') {
            try {
                state.user = JSON.parse(userString);
                state.isAuthenticated = true;
            } catch (e) {
                this.logout();
            }
        } else {
            this.logout();
        }
    },

    login(token, user) {
        localStorage.setItem(tokenKey, token);
        localStorage.setItem(userKey, JSON.stringify(user));
        state.isAuthenticated = true;
        state.user = user;
    },

    logout() {
        localStorage.removeItem(tokenKey);
        localStorage.removeItem(userKey);
        state.isAuthenticated = false;
        state.user = null;
    }
}; 