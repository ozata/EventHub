<template>
    <div id="app">
        <navbar/>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Navbar from "./Navbar";
    export default {
        // Component'ı local olarak import ediyoruz.
        components: {
            Navbar
        }
    }
</script>