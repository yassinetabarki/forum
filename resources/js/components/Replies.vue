<template>
    <div>
        <div v-for="(reply,index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)" ></reply>
        </div>
         <paginator :dataSet="dataSet" @changed="fetch"> </paginator>
        <new-reply  @created="add" ></new-reply>
        
    </div>
</template>

<script>
    import NewReply from './NewReply.vue';
    import Reply from './Reply.vue';
    import collection from '../mixins/collection'
    export default {
       
        components :{ Reply, NewReply },

        mixins:[collection],

        data(){
            return {
                dataSet:false,
    
            }
        },
        created(){
                this.fetch();
            },
        methods: {

            fetch(page){
                axios.get(this.url(page)).then(this.refresh);
            },
            /** this were we left off of to day */
            url( page ){
                if(! page){
                    let query = location.search.match(/page=(\d+)/);
                    page = query ? query[1]: 1;
                }
                return `${location.pathname}/replies/?page=${page}`;
            },
            refresh({data}){
            
                this.dataSet=data;
                this.items=data.data;

                window.scrollTo(0,0);
            },
        }
    }
</script>

