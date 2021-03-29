import axios from 'axios';
import Vue from 'vue'

export const state = () => ({
	folders: []
})

export const mutations = {
	SET_FOLDERS (state, payload) {
		const { year, quarter, data } = payload;
		// state.folders = payload
		if (!state.folders[year]) {
            Vue.set(state.folders, year, {});
        }
        if (!state.folders[year][quarter]) {
            Vue.set(state.folders[year], quarter, {});
		}
		state.folders[year][quarter] = data[year][quarter];
	}
}

export const actions = {
	async fetchFolders ({ commit }, payload) {
		try {
            console.log('[VUEX] fetchFolders: ', payload)
            const { data } = await axios.get(`/api/v1/folders`)
            // console.log('data: ', data)
            return data
        } catch (error) {
            console.log('[VUEX] fetchFolders error: ', error)
        }
    },
    async createFolder({}, payload) {
        try {
            // const path = '/new folder/new folder 2'
            const { path } = payload
			const { data } = await axios.post(`/api/v1/folders`, { path })
            console.log('[VUEX] data: ', data)
        } catch (error) {
            console.log("[VUEX] error: ", error);
            throw error
        }
    },
    async renameFolder({}, payload) {
        try {
            const { path, newName } = payload
            const { data } = await axios.put(`/api/v1/folders/${newName}`, { path, newName })
            console.log('data: ', data)
        } catch (error) {
            throw error
        }
    },
    async deleteFolder({}, payload) {
        try {
            // const folderName = encodeURI('new folder 2')
            // const { folderName } = payload
            // const encodedFolderName = encodeURI(folderName)
			// const { data } = await axios.delete(`/api/v1/folders/${encodedFolderName}`)
            const { path } = payload
			const { data } = await axios.post(`/api/v1/folders/destroy`, { path })
            console.log('[VUEX] data: ', data)
        } catch (error) {
            console.log("[VUEX] error: ", error);
            throw error
        }
    }
}

export const getters = {
	folders (state) {
		return state.folders
	}
}
