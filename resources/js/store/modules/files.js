import Vue from 'vue'

export const state = () => ({
	files: []
})

export const mutations = {
	SET_FILES (state, payload) {
		const { year, quarter, data } = payload;
		// state.files = payload
		if (!state.files[year]) {
            Vue.set(state.files, year, {});
        }
        if (!state.files[year][quarter]) {
            Vue.set(state.files[year], quarter, {});
		}
		state.files[year][quarter] = data[year][quarter];
	}
}

export const actions = {
	async fetchFiles ({ commit }, payload) {
		console.log('[VUEX] fetchFiles: ', payload)
        const { data } = await axios.get(`/api/v1/files`)
        console.log('data: ', data)
        return data
		commit('SET_FILES', { data })
    },
    async fetchFile({}, payload) {
        try {
			const { filePath } = payload
			console.log('filePath: ', filePath)
            const data = await axios.get(`/api/v1/files/${filePath}`, {
				responseType: 'blob'
			});
			// const data = await axios.get(`/api/v1/files/${filePath}`);
			console.log('data: ', data)
			return data
        } catch (error) {
            console.log("error: ", error);
        }
    }
}

export const getters = {
	files (state) {
		return state.files
	}
}
