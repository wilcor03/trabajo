<template>
<div id="dashboard">   
  <router-view></router-view>
</div>
</template>
<script>
import { getToken } from '../services/Auth';
export default {
    data: () => ({
      show: false
    })
}
</script>
