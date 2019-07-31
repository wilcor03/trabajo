<template>
<div id="base-employer">
    <EmployerHeader/>
    <v-container grid-list-md>
        <router-view></router-view>
    </v-container>
</div>
</template>
<script>
import EmployerHeader from '../../components/EmployerHeader.vue';
export default {
    components:{EmployerHeader}
}
</script>