import Vue from 'vue'

export const state = () => ({
	auth: 'student'
})

export const mutations = {
	SET_AUTH (state, payload) {
		state.auth = payload;
	}
}

export const actions = {
}

export const getters = {
	auth (state) {
		return state.auth
	}
}