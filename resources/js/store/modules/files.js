import axios from "axios";
import Vue from "vue";

export const state = () => ({
    files: []
});

export const mutations = {
    SET_FILES(state, payload) {}
};

export const actions = {
    async fetchFiles({ commit }, payload) {
        try {
            console.log("[VUEX] fetchFiles: ", payload);
            const { data } = await axios.get(`/api/v1/files`);
            // console.log('data: ', data)
            return data;
        } catch (error) {
            console.log("error: ", error);
        }
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
};

export const getters = {
    files(state) {
        return state.files;
    }
};
