import Vue from "vue";

export const state = () => ({
    permanences: {}
});

export const mutations = {
    SET_PERMANENCES(state, payload) {
        // console.log("SET_PERMANENCES vuex: ", payload);
        const { year, quarter, data } = payload;
        console.log("year: ", year);
        console.log("quarter: ", quarter);
        console.log("data: ", data);
        if (!state.permanences[year]) {
            Vue.set(state.permanences, year, {});
        }
        if (!state.permanences[year][quarter]) {
            Vue.set(state.permanences[year], quarter, {});
        }
        state.permanences[year][quarter] = data[year][quarter];
    }
};

export const actions = {
    async fetchPermanences({ commit }, payload) {
        console.log("[VUEX] fetchPermanences: ", payload);
        const { year, quarter } = payload;
        const { data } = await axios.get(
            `/api/v1/permanences?year=${year}&quarter=${quarter}`
        );
        console.log("data: ", data);
        commit("SET_PERMANENCES", { year, quarter, data });
    },
    async updatePermanence({ commit, dispatch }, payload) {
        console.log("[VUEX] updatePermanence ", payload);
        const { year, quarter, permanenceId, updatedPermanence } = payload;
        // const abc = { week_attr: 1 }
        console.log("updatedPermanence vuex: ", updatedPermanence);
        const { data } = await axios.put(
            `/api/v1/permanences/${permanenceId}`,
            updatedPermanence
        );
        console.log("data: ", data);
        // commit('SET_PERMANENCE', data)
        dispatch("fetchPermanences", { year, quarter });
    }
};

export const getters = {
    permanences(state) {
        return state.permanences;
    }
};
