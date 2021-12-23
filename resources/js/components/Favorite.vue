<template>
    <button type="submit" :class="classes" @click="toggle">
     <span class=" glyphicon glyphicon-bed"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
    export default {
        props:['reply'],
        data(){
            return {
                favoritesCount:this.reply.favoritesCount,
                
                isFavorited:this.reply.isFavorited
            }
        },
        computed:{
            classes(){
                return ['btn',this.isFavorited ? 'btn-primary' : 'btn-default'];
            },
            endpoint(){
               return '/replies/'+ this.reply.id +'/favorites';
            }
        },
        methods:{
            toggle(){
                return this.isFavorited ? this.destroy() : this.create();
            },
            destroy(){
                axios.delete(this.endpoint);
                this.isFavorited=false;
                this.favoritesCount--;
            },
            create(){
                axios.post(this.endpoint);
                this.isFavorited=true;
                this.favoritesCount++;
            }
        }
    }
</script>


