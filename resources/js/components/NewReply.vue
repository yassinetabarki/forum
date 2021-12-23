<template>
<div >
     <!-- <form method="POST" action="{ endpoint }" > -->
        <div v-if="signedIn">
        <div class="form-group">
             <label for="body"></label>
             <textarea  name="body" 
                        id="body" 
                        class="form-control" 
                        placeholder="have something to say ?" 
                        rows="5" 
                        v-model="body" required></textarea>
             <button type="submit" class="btn btn-group" @click="addReply">post</button>
         </div>
        </div>
        
     <!-- </form> -->
     <p class="text-center" v-else>
         Please <a href="/login"> sign in</a>
         to paticiptate in the discussion</p>
      
</div>
    
</template>

<script>
export default {
    data() {
        return{
            body:'',
        };
    },
    computed: {
       signedIn() {
           return window.App.signedIn;
       }
    },
    methods: {
        addReply(){

           axios.post( location.pathname +'/replies' ,{ body: this.body })
           .then(({data}) => {
               this.body='';

               flash("Your reply has been created.");

               this.$emit('created', data);
           });
        }
    }
}
</script>