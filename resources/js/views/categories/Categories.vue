<template>
    <div id="categories">
        <category-list/>        
    </div>    
</template>
<script>
import CategoryList from './CategoryList'
export default {
    components:{
        'category-list': CategoryList
    }
}
</script>