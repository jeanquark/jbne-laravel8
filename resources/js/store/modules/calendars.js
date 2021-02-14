import Vue from 'vue'

export const state = () => ({
	calendars: {}
})

export const mutations = {
	SET_CALENDARS (state, payload) {
		const { year, quarter, data } = payload;
		// state.calendars = payload
		if (!state.calendars[year]) {
            Vue.set(state.calendars, year, {});
        }
        if (!state.calendars[year][quarter]) {
            Vue.set(state.calendars[year], quarter, {});
		}
		state.calendars[year][quarter] = data[year][quarter];
	}
}

export const actions = {
	async fetchCalendars ({ commit }, payload) {
		console.log('[VUEX] fetchCalendars: ', payload)
		const { year, quarter } = payload
        const { data } = await axios.get(`/api/v1/calendars?year=${year}&quarter=${quarter}`)
        console.log('data: ', data)
		commit('SET_CALENDARS', { year, quarter, data })
	}
}

export const getters = {
	calendars (state) {
		return state.calendars
	}
}