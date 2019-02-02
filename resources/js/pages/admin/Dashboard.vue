<template>
<div class="container">
    <div class="card card-default">
        <div class="card-header">Admin Dashboard</div>
        <div class="card-body">
            Welcome to EventHub, Admin!
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">User List</div>
        <div class="card-body">
            <userList></userList>
        </div>
    </div>
</div>
</template>
<script>
    import userList from '../../components/UserList.vue'
    export default {
        mounted() {
            //
        },
        components: {
            userList
        }
    }
</script>