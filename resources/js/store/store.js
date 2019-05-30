import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
    state : {
        user : null,
        admin: false
    },
    mutations: {
        setUser(state, user) {
          state.user = user
        },
        setAdmin(state, admin) {
            state.admin = admin
        }
    },
    getters: {
        user: state => state.user,
        admin: state => state.admin
    }
})
