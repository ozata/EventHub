<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/">EventHub</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active" v-if="$auth.check(2)">
                            <router-link :to="{ name: 'dashboard' }" class="nav-link">Dashboard</router-link>
                        </li>

                        <li class="nav-item dropdown" v-if="$auth.check(1) | $auth.check(2)">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Events and Games
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <router-link :to="{ name: 'event.index' }" class="dropdown-item">Event List
                                </router-link>
                                <router-link :to="{ name: 'game.index' }" class="dropdown-item">Game List</router-link>
                                <!-- <div class="dropdown-divider"></div> -->
                            </div>
                        </li>


                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <!--UNLOGGED-->
                        <li class="nav-item" v-if="!$auth.check()">
                            <router-link :to="{ name : 'register' }"class="nav-link">
                                Register
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="!$auth.check()">
                            <router-link :to="{ name : 'login' }"class="nav-link">
                                Login
                            </router-link>
                        </li>
                        <!--LOGGED USER-->
                        <li class="nav-item" v-if="$auth.check(1)" v-for="(route, key) in routes.user"
                            v-bind:key="route.path">
                            <router-link :to="{ name : route.path }" :key="key" class="nav-link">
                                {{route.name}}
                            </router-link>
                        </li>

                        <!--LOGGED ADMIN-->
                        <li class="nav-item" v-if="$auth.check(2)" v-for="(route, key) in routes.admin"
                            v-bind:key="route.path">
                            <router-link :to="{ name : route.path }" :key="key" class="nav-link">
                                {{route.name}}
                            </router-link>
                        </li>

                        <!--LOGOUT-->
                        <li class="nav-item" v-if="$auth.check()">
                            <a href="#" @click.prevent="$auth.logout()">Logout</a>
                        </li>

                        <!--
                        <li class="nav-item" v-if="$auth.check()">
                            <router-link v-on:click="$auth.logout()" :to="{name : Dashboard}" class="nav-link">
                                Logout
                            </router-link>
                        </li>
                        -->


                    </ul>
                </div>
            </div>
        </nav>


    </div>
</template>
<script>
    export default {
        data() {
            return {
                routes: {
                    // UNLOGGED
                    unlogged: [
                        {
                            name: 'Register',
                            path: 'register'
                        },
                        {
                            name: 'Login',
                            path: 'login'
                        }
                    ],
                    // LOGGED USER
                    user: [
                        {
                            name: 'Dashboard',
                            path: 'dashboard'
                        },
                        {
                            name: '',
                        }
                    ],
                    // LOGGED ADMIN
                    admin: [
                        {
                            name: 'Dashboard',
                            path: 'admin.dashboard'
                        }
                    ]
                }
            }
        },
        mounted() {
            //
        }
    }
</script>