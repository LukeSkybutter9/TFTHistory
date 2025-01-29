<template>
    <div class="nav flex flex-row p-5 justify-center">
        <button class="logo flex items-center">
            <svg class="svg-icon ml-5" :class="['svg-icon', darkMode ? 'dark' : 'light']" width="28px" height="28px" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg"><title>Riot Games icon</title><path d="M12.534 21.77l-1.09-2.81 10.52.54-.451 4.5zM15.06 0L.307 6.969 2.59 17.471H5.6l-.52-7.512.461-.144 1.81 7.656h3.126l-.116-9.15.462-.144 1.582 9.294h3.31l.78-11.053.462-.144.82 11.197h4.376l1.54-15.37Z"/></svg>
        </button>
        <div class="switchmode mr-5 flex items-center">
            <button class="button-switch p-2" :class="['button-switch', darkMode ? 'dark' : 'light']" @click="toggleDarkMode">
                <img class="svg-icon-moon" v-if="darkMode" src="../../../public/icons/moon.svg" height="40px" width="40px" alt="">
                <img class="svg-icon-sun"  v-else src="../../../public/icons/sun.svg" height="40px" width="40px" alt="">
                <!--<svg class="svg-icon-moon"  v-if="darkMode" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" ><path d="M479.96-117.05q-151.32 0-257.11-105.8-105.8-105.79-105.8-257.11t105.81-257.27Q328.66-843.19 480-843.19q9.44 0 19.46.55 10.03.55 23.37 1.88-35.27 31.96-55.46 77.63-20.18 45.68-20.18 96.75 0 91.38 64.08 155.4 64.09 64.03 155.66 64.03 51.09 0 96.72-19.06 45.63-19.07 77.35-52.5 1.09 12.01 1.64 20.88.55 8.87.55 17.39 0 151.28-105.96 257.23-105.95 105.96-257.27 105.96Z"/></svg>
                <svg class="svg-icon" :class="['svg-icon', darkMode ? 'dark' : 'light']" v-else xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" ><path d="M480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM205.5-434.5h-171v-91h171v91Zm720 0h-171v-91h171v91Zm-491-320v-171h91v171h-91Zm0 720v-171h91v171h-91ZM255.76-641.87 147.35-746.52l64.41-67.13 104.13 107.17-60.13 64.61Zm492.48 495.52L643.11-254.52 704-317.65l108.65 104.17-64.41 67.13ZM642.35-704l104.17-108.65 67.13 64.41-107.17 104.13L642.35-704Zm-496 492.24 108.17-105.13L317.65-256 213.48-147.35l-67.13-64.41Z"/></svg> -->
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            
        }
    },
    methods: {
        toggleDarkMode() {
            this.$store.dispatch('toggleDarkMode');  
        }
    },
    computed: {
        darkMode() {
            return this.$store.getters.darkMode;  // Obtener el estado global de darkMode
        }
    },    
}
</script>

<style scoped>
.svg-icon{
    fill: white;
}

.nav{
    background-color: #141416;
}

.logo{
    width: 50%;
    justify-content: left;
}

.switchmode{
    width: 50%;
    justify-content: right;
}

.button-switch{
    background-color: #2a2a2e;
    border-radius: 5em;
}

.button-switch.dark{
    border-radius: 5em;
}
</style>