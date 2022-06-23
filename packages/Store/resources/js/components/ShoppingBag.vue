<template>
    <div style="padding: 20px">
        <h1>Shopping Bag: {{this.productsCount}}</h1>

        <div v-for="product in this.products" :key="product.id">
            {{product.title}} | quantidade: {{product.qty}} | <button type="button" @click="removeFromCart(product.id)">remover</button> |
            <button type="button" @click="decrementQuantity(product.id, product.qty)">diminuir</button> | <button type="button" @click="incrementQuantity(product.id, product.qty)">aumentar</button>
        </div>

        <div>
            Total: {{this.total}} €
        </div>
    </div>
</template>
<script>
export default {
    created() {
        this.$store.dispatch('cart/get');
    },

    computed:{
        products(){
            return this.$store.getters['cart/content'];
        },

        productsCount(){
            return this.$store.getters['cart/content_count'];
        },

        total(){
            return this.$store.getters['cart/total'];
        }
    },

    methods:{
        removeFromCart(product_id){

            this.$store.dispatch('cart/removeProduct', product_id).then(response => {
                //caso seja removido com sucesso
            }).catch(error => {
                console.log(error.response.data.errors);
            });

        },

        updateProductQuantity(data){

            this.$store.dispatch('cart/updateProductQuantity', data).then(response => {
                //caso seja alterado com sucesso
            }).catch(error => {
                console.log(error.response.data.errors);
            });

        },

        decrementQuantity(product_id, qty){
            let data = {
                product_id: product_id,
                quantity: qty - 1,
            };

            this.updateProductQuantity(data);
        },

        incrementQuantity(product_id, qty){
            let data = {
                product_id: product_id,
                quantity: qty + 1,
            };

            this.updateProductQuantity(data);
        }
    }
}
</script>
