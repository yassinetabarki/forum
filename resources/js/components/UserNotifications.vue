<template>
  <il class="dropdown" v-if="notifications">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <span class="glyphicon glyphicon-bell"></span>
      </a>

      <ul class="dropdown-menu">
          <li v-for ="notification in notifications">
              <a href="#" >yassinee</a>
          </li>
      </ul>
  </il>
</template>

<script>
export default {

    data() {
        return {
        
            notifications : false
        }
    },

    created() {
        axios.get("/profile/"+window.App.user.name+"/notifications")
        .then(response => this.notifications = response.data);
    }
}
</script>

<style>

</style>