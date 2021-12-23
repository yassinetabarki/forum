<template>
    <button type="submit" :class="classses" @click="subscribe">
        Subscribe 
    </button>
</template>

<script>

export default {
    props : ['active'],

    computed : {
        classses(){
            return ['btn' , this.active ? 'btn btn-primary' : ' btn btn-default' ]
        }
    },
    
    methods : {
        subscribe() {
      
            axios[this.active ? 'delete' : 'post'](location.pathname+'/subscriptions');

            this.active = ! this.active;
          
        }
    }
}
</script>

<style>

</style>