// import Vue from 'vue'
// import Vuex from 'vuex'

// Vue.use(Vuex)

// const store = new Vuex.Store({
//     state: {
//         count: 0,
//         lawyers: [
//             {
//                 name: 'Cyril'
//             },
//             {
//                 name: 'Olivier'
//             }
//         ]
//     },
//     mutations: {
//         INCREMENT(state) {
//             console.log('INCREMENT mutations')
//             state.count++
//         }
//     },
//     actions: {}
// })

// export default store

import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

// Load store modules dynamically.
const requireContext = require.context("./modules", false, /.*\.js$/);

const modules = requireContext
    .keys()
    .map(file => [file.replace(/(^.\/)|(\.js$)/g, ""), requireContext(file)])
    .reduce((modules, [name, module]) => {
        if (module.namespaced === undefined) {
            module.namespaced = true;
        }

        return { ...modules, [name]: module };
    }, {});

export default new Vuex.Store({
    modules
});
