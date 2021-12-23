 <template>
    <div :id="'reply-'+id" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profile/'+data.owner.id"  v-text="data.owner.name">
                    </a> said <span v-text="ago"></span> 
                </h5>
                        <div>
                         <favorite :reply="data">

                            </favorite>
                            </div>
            </div>
        </div>

        <div class="panel-body">
            <div v-if="editing" >
                <div class="forum-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing=false">Cancel</button>
            </div>
            <div v-else>
                <article>
                    <div class="body" v-text="body"></div>
                </article>
            </div>
            <hr>
        </div>
            <div class="panel-footer level" v-if="canUpdate">
                <button class="btn btn-xs mr-1" @click="editing=true">Edit</button>
                <button class="btn btn-xs btn-danger mr-1" @click="destroy">Delete</button>
            </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment   from 'moment'
    export default {
        props:['data'],


        components: { Favorite },


        data(){
            return{
                editing :false,
                id :this.data.id,
                body :this.data.body
            };
        },
        computed:{
            ago(){
                return moment(this.data.created_at).fromNow();
            },
            singedIn(){
                return window.App.singedIn;
            },
            canUpdate(){
                return this.authorize(user => this.data.user_id == user.id);
           /*      return data.user.id == window.App.user.id */
            }
        },


        methods:{ 
            update(){
                axios.patch('/replies/'+this.data.id,{
                    'body':this.body
                });
                this.editing=false;
                flash('update');
            },
            destroy(){
                axios.delete('/replies/'+this.data.id);

                this.$emit ('deleted' ,this.data.id)
                // $(this.$el).fadeOut(300,() => {
                //     flash('You reply has deleted');
                // });

            }
        }
    }
</script>

