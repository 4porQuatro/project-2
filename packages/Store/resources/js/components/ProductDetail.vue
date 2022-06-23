<template>
    <div style="padding: 20px">
        <h1>Titulo: {{this.product.title}}</h1>
        <h3>REF: {{this.product.ref}}</h3>
        <h2 v-if="this.attributes.brand">{{this.attributes_options.brand[0].title}}</h2>
        <h3>Preço: {{this.product.promoted_price ? this.product.promoted_price : this.product.price}}€</h3>

        <div v-if="this.attributes.color">
            <h2>{{ this.attributes.color.title }}:</h2>

            <div v-for="color in this.attributes_options.color" :key="color.id">
                <label>
                    <input type="radio" :value="color.id" name="color" v-model="selected_color" @change="changeProduct()">
                    <span>{{color.title}}</span>
                </label>
            </div>
        </div>

        <div v-if="this.attributes.size">
            <h2>{{ this.attributes.size.title }}:</h2>

            <div v-for="size in this.attributes_options.size" :key="size.id">
                <label>
                    <input type="radio" :value="size.id" name="size" v-model="selected_size" @change="changeProduct()">
                    <span>{{size.title}}</span>
                </label>
            </div>
        </div>

        <div>
            <button type="button" @click="addToCart()" :disabled="!canBeAddedToCart">adicionar</button>
        </div>
    </div>
</template>
<script>
export default {
    props:[
        'prop_product',
        'attributes',
        'attributes_options',
        'default_variation'
    ],

    computed:{
        //loading do carrinho de compras (true|false)
        cartLoading(){
            return this.$store.getters['cart/loading'];
        },

        //exemplo de uma variavel de controlo para saber se o produto esta pronto para ser adicionado ao carrinho (true|false)
        canBeAddedToCart(){
            return this.cartLoading === false && this.is_valid_product === true && this.selected_color != null && this.selected_size != null;
        }
    },

    data(){
        return{
            product:null,
            main_product_id:null,
            selected_color:null,
            selected_size:null,
            is_valid_product:false,
        }
    },

    created() {
        //a variavel product poderá se alterada quando o utilziador seleciona um novo atributo, é feita esta associação para o produto visivel ja ter fotos e preços finais
        this.product = this.default_variation;

        //esta variavel é fixa para ser utilizada apenas para obter as variantes do produto
        this.main_product_id = this.prop_product.id;

        //preseleciona-se automaticamente a cor que corresponde a variante default do produto
        if(this.default_variation.attributesOptions.color)
        {
            this.selected_color = this.default_variation.attributesOptions.color[0].id;
        }
    },

    methods:{
        //função para adicionar produto ao carinho de compras
        addToCart() {
            if(this.canBeAddedToCart)
            {
                let data = {
                    product_id: this.product.id,
                    quantity: 1,
                };

                this.$store.dispatch('cart/addProduct', data).then(response => {
                    //caso seja adicionado com sucesso
                }).catch(error => {
                    console.log(error.response.data.errors);
                });
            }
        },

        //exemplo de função a ser chamada quando é necessario obter nova informação relativamente ao produto
        changeProduct(){
            //retorna um array de todos os attributos selecionados e remove os vazios
            let attribute_options = _.compact([this.selected_color, this.selected_size]);

            let params = {
                attribute_options:attribute_options,
            };

            //pedido ao servidor para obter uma variante do produto principal que contenha os attributos selecionados
            axios.get('/store/products/'+this.prop_product.id, {params:params}).then(response => {

                //em caso de sucesso, o produto é alterado para os dados se refletirem no front
                this.product = response.data;
                this.is_valid_product = true;
            }).catch(error => {

                //em caso de erro, o produto mantem-se igual, aqui é um bom sitio para avisar o cliente que não existe stock para as variantes selecionadas
                this.is_valid_product = false;
                console.log("não foi encontrado um produto para os atributos selecionados");
            })
        },
    },
}
</script>
