export default {
    namespaced: true,
    state: {
        content:[],
        total:0.00,
        content_count:0,
        loading:false,
    },

    getters: {
        content: (state)=>{
            return state.content;
        },

        total: (state)=>{
            return state.total;
        },

        content_count: (state)=>{
            return state.content_count;
        },

        loading: (state)=>{
            return state.loading;
        }
    },

    mutations: {
        SET_CONTENT:(state, payload) => {
            state.content = payload;
        },

        SET_TOTAL:(state, payload) => {
            state.total = payload;
        },

        SET_CONTENT_COUNT:(state, payload) => {
            state.content_count = payload;
        },

        SET_LOADING:(state, payload) => {
            state.loading = payload;
        }
    },

    actions: {
        get: async (context, payload) => {
            let {data} = await axios.get('/store/cart');
            context.commit('SET_CONTENT', data.content);
            context.commit('SET_TOTAL', data.total);
            context.commit('SET_CONTENT_COUNT', data.content_count);
        },

        addProduct: async (context, payload) => {
            context.commit('SET_LOADING', true);

            await axios.post('/store/cart', payload).then(response => {
                context.commit('SET_CONTENT', response.data.content);
                context.commit('SET_TOTAL', response.data.total);
                context.commit('SET_CONTENT_COUNT', response.data.content_count);
                context.commit('SET_LOADING', false);
            }).catch(error => {
                context.commit('SET_LOADING', false);
                throw error;
            })
        },

        removeProduct: async (context, payload) => {
            context.commit('SET_LOADING', true);

            await axios.delete('/store/cart/remove/'+payload).then(response => {
                context.commit('SET_CONTENT', response.data.content);
                context.commit('SET_TOTAL', response.data.total);
                context.commit('SET_CONTENT_COUNT', response.data.content_count);
                context.commit('SET_LOADING', false);
            }).catch(error => {
                context.commit('SET_LOADING', false);
                throw error;
            })
        },

        updateProductQuantity: async (context, payload) => {

            context.commit('SET_LOADING', true);

            await axios.patch('/store/cart', payload).then(response => {
                context.commit('SET_CONTENT', response.data.content);
                context.commit('SET_TOTAL', response.data.total);
                context.commit('SET_CONTENT_COUNT', response.data.content_count);
                context.commit('SET_LOADING', false);
            }).catch(error => {
                context.commit('SET_LOADING', false);
                throw error;
            })
        },
    }
}

