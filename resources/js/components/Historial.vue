<template>
    <div :class="{'dark-mode': darkMode}" class="flex flex-col justify-center items-center min-h-screen">
        <h1 class="titulo text-7xl p-2">Historial de {{ summonerNameTag }}</h1>
        <div class="p-10">
            <form class="flex flex-row gap-5" @submit.prevent="getMatchesHistory()">
                <input type="text" v-model="summonerName" placeholder="Summoner Name">
                <input type="text" v-model="summonerTag" placeholder="#">
                <select name="" v-model="region" id="">
                    <option value="americas">LATAM/NA</option>
                    <option value="eun1">Europa</option>
                    <option value="kr">Corea</option>
                    <option value="br1">Brasil</option>
                </select>
                <button class="font-bold" type="submit">Buscar</button>
            </form>
            <p v-if="error==true" class="text-red-700 mt-3">{{ errortext }}</p>
        </div>
        <div class="tabla p-15">
            <table v-if="matches.length">
                <thead class="min-w-screen">
                    <tr>
                        <th class="rounded-tl-lg">Resultado</th>
                        <th>Compo</th>
                        <th>Posición</th>
                        <th class="rounded-tr-lg">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                <tr v-for="match in matches" :key="match.info?.match_id">
                    <td v-if="match.info && match.info.participants[0].win === true">Ganaste</td>
                    <td v-else>Perdiste</td>
                    <td class="flex flex-row gap-3 p-5">
                        <p v-for="units in match.info.participants[0].units" :key="units.character_id">
                            {{ units.character_id.replace("TFT13_","").replace("tft13_","") }}
                        </p>
                    </td>
                    <td v-if="match.info && match.info.participants[0].placement">{{ match.info.participants[0].placement }}</td>
                    <td class="flex flex-row p-5" v-if="match.info && match.info.game_datetime">{{ new Date(match.info.game_datetime).toLocaleString() }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "HistorialComponent",
    data(){
        return{
            error:false,
            errortext:'',
            summonerName:'',
            summonerTag:'',
            puuid:'',
            region:'',
            matches: [],
        };
    },
    methods:{
        async getMatchesHistory(){
            try{
                this.error=false;
                const summonerInfo = await axios.get(`http://127.0.0.1:8000/api/riot/summoner`, { // obtenemos primeramente el puuid haciendo el llamado al endpoint en route api.php Route::get('/riot/summoner', function (Request $request)
                params: {
                    summonerName: this.summonerName,
                    summonerTag: this.summonerTag,
                    region: this.region,
                },
                });
                
                if(summonerInfo.data){
                    this.puuid = summonerInfo.data.puuid;
                    console.log("puuid: ",this.puuid);
                    this.getMatches();
                }
                
            }catch(error){
                console.error("Error al obtener la información del invocador:", error);
                this.errortext = "Verifica el nombre del invocador, tag o región ingresada!";
                this.error=true;
            }            
        },
        async getMatches(){
            try{
                const matchesResponse = await axios.get(`http://127.0.0.1:8000/api/riot/matches`, { 
                    params: {
                        puuid: this.puuid,
                        region: this.region,
                    },
                });

                if (matchesResponse.data) {
                    this.matches = matchesResponse.data;
                    console.log("Historial de partidas:", this.matches);
                }

            }catch(error){
                console.error("Error al obtener el historial del invocador:", error);
                this.errortext = "Fallo en la obtención del historial de invocador error->",error;
                this.error=true;
            }
        },
    },
    computed:{
        summonerNameTag(){
            const fullName = `${this.summonerName} # ${this.summonerTag}`;
            return fullName.toUpperCase();
        },
        darkMode() {
            return this.$store.getters.darkMode;
        }
    }
}
</script>

<style scoped>

*{
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

h1{
    color: #141416; 
    transition: color 0.5s ease-in-out;
}

input {
    padding: 0.5em;
    margin-right: 0.5em;
    border: 2px solid #ddd;
    border-radius: 16px;
}


input:focus{
    border: 2px solid #141416;
    background-color: #f7f8f3;
}

select{
    border-radius: 16px;
    width: 15vw;
    padding: 10px;
    background-color: #f7f8f3;
    border: 2px solid #ddd;
}

select:focus{
    border: 2px solid #141416;
}

button {
    padding: 0.5em 2em;
    background-color: #dc291e;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 16px;
}

button:hover {
    background-color: #c9231a;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    text-align: center;
}

th {
    padding: 1rem;
    background-color: #dc291e;
    color: white;
}

td {
    background-color: #f9f9f9;
}

tr:nth-child(even) td {
    background-color: #e6e6e6; /* Alterna colores para filas del table */
}

/* hover de las filas */
tr:hover td {
    background-color: #f7f8f3;
}

.dark-mode h1{
    color: #f7f8f3;
    transition: color 0.5 ease-in-out;
}

.dark-mode{
    background-color: #0e0e0f;
    transition: background-color 0.5s ease-in-out;
}

</style>